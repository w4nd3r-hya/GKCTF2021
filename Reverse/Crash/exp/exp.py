from Crypto.Cipher import DES3
import base64
import itertools
import string
import hashlib

def des3_cbc_decrypt(secret_key, secret_value, iv):
    unpad = lambda s: s[0:-ord(s[-1])]
    res = DES3.new(secret_key.encode("utf-8"), DES3.MODE_CBC, iv)
    base64_decrypted = base64.b64decode(secret_value.encode("utf-8"))
    encrypt_text = res.decrypt(base64_decrypted)
    result = unpad(encrypt_text.decode())
    return result

def sha256crash(sha256enc):
    code = ''
    strlist = itertools.product(string.ascii_letters + string.digits, repeat=4)

    for i in strlist:
        code = i[0] + i[1] + i[2] + i[3]
        encinfo = hashlib.sha256(code.encode()).hexdigest()
        if encinfo == sha256enc:
            return code
            break


def sha512crash(sha256enc):
    code = ''
    strlist = itertools.product(string.ascii_letters + string.digits, repeat=4)

    for i in strlist:
        code = i[0] + i[1] + i[2] + i[3]
        encinfo = hashlib.sha512(code.encode()).hexdigest()
        if encinfo == sha256enc:
            return code
            break


def md5crash(sha256enc):
    code = ''
    strlist = itertools.product(string.ascii_letters + string.digits, repeat=4)

    for i in strlist:
        code = i[0] + i[1] + i[2] + i[3]
        encinfo = hashlib.md5(code.encode()).hexdigest()
        if encinfo == sha256enc:
            return code
            break

if __name__ == '__main__':
    key = "WelcomeToTheGKCTF2021XXX"
    iv = b"1Ssecret"
    cipher = "o/aWPjNNxMPZDnJlNp0zK5+NLPC4Tv6kqdJqjkL0XkA="

    part1 = des3_cbc_decrypt(key,cipher,iv)
    part2 = sha256crash("6e2b55c78937d63490b4b26ab3ac3cb54df4c5ca7d60012c13d2d1234a732b74")
    part3 = sha512crash("6500fe72abcab63d87f213d2218b0ee086a1828188439ca485a1a40968fd272865d5ca4d5ef5a651270a52ff952d955c9b757caae1ecce804582ae78f87fa3c9")
    part4 = md5crash("ff6e2fd78aca4736037258f0ede4ecf0")

    flag = "GKCTF{" + part1 + part2 + part3 + part4 + "}"
    print (flag)