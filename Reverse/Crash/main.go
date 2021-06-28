package main

import (
    _ "embed"
	"encoding/json"
    "fmt"
	"Encrypt"
	"encoding/base64"
	"crypto/md5"
)

type (
    secretdata struct {
        Key string `json:"key"`
        IV  string `json:"iv"`
    }
)

//go:embed secret.txt
var secret []byte


func encrypto(plaintext string)(cryptText string){
    var s secretdata
	json.Unmarshal(secret, &s)
	key := s.Key
	iv := s.IV

	bplaintext := []byte(plaintext)
	bkey := []byte(key)
	biv := []byte(iv)

	bcryptText, err := Encrypt.DesEncrypt(bplaintext, bkey, biv)
	if err != nil {
		fmt.Println(err)
	}
	cryptText = base64.StdEncoding.EncodeToString(bcryptText)
	return cryptText
}

func hash2(plaintext string)(hash string){
	hash = Encrypt.HashHex2([]byte(plaintext))
	return hash
}

func hash5(plaintext string)(hash string){
	hash = Encrypt.HashHex5([]byte(plaintext))
	return hash
}

func hash(plaintext string)(hash string){
	data := []byte(plaintext)
    has := md5.Sum(data)
    hash = fmt.Sprintf("%x", has)
	return hash
}

func check(flag string)(ret bool){
	if encrypto(flag[6:30]) != "o/aWPjNNxMPZDnJlNp0zK5+NLPC4Tv6kqdJqjkL0XkA="{
		return false;
	}
	
	if hash2(flag[30:34]) != "6e2b55c78937d63490b4b26ab3ac3cb54df4c5ca7d60012c13d2d1234a732b74"{
		return false;
	}

	if hash5(flag[34:38]) != "6500fe72abcab63d87f213d2218b0ee086a1828188439ca485a1a40968fd272865d5ca4d5ef5a651270a52ff952d955c9b757caae1ecce804582ae78f87fa3c9"{
		return false;
	}
	
	if hash(flag[38:42]) != "ff6e2fd78aca4736037258f0ede4ecf0"{
		return false;
	}
	
	return true
}


func main(){
	var flag string

	fmt.Println("Please input flag:")
    fmt.Scanln(&flag)

	if len(flag) == 43 && "GKCTF{" == flag[0:6] && "}" == flag[42:43]{
		if check(flag){
			fmt.Println("Congratulation")
		}else{
			fmt.Println("Sorry")
		}
		
	}else{
		fmt.Println("Form wrong")
	}
}
