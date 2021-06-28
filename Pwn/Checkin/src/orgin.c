#include<stdio.h>
#include<stdlib.h>
#include<unistd.h>
#include<string.h>
#include "md5.h"

//gcc orgin.c -o fixedLogin -fno-stack-protector
void initt();
void Welcome();
void Login();
void decode(unsigned char *retnStr,unsigned char encrypt[]);
//  _____  _____  _____  __  _____  _   _______ ___________ 
// / __  \|  _  |/ __  \/  ||  __ \| | / /  __ \_   _|  ___|
// `' / /'| |/' |`' / /'`| || |  \/| |/ /| /  \/ | | | |_   
//   / /  |  /| |  / /   | || | __ |    \| |     | | |  _|  
// ./ /___\ |_/ /./ /____| || |_\ \| |\  \ \__/\ | | | |    
// \_____/ \___/ \_____/\___/\____/\_| \_/\____/ \_/ \_|    
                                                         
                                                         
char Size1[]="\033[1;35m _____  _____  _____  __  _____  _   _______ ___________ \033[m";
char Size2[]="\033[1;35m / __  \\|  _  |/ __  \\/  ||  __ \\| | / /  __ \\_   _|  ___|\033[m";
char Size3[]="\033[1;35m `' / /'| |/' |`' / /'`| || |  \\/| |/ /| /  \\/ | | | |_   \033[m";
char Size4[]="\033[1;35m   / /  |  /| |  / /   | || | __ |    \\| |     | | |  _|  \033[m";
char Size5[]="\033[1;35m ./ /___\\ |_/ /./ /____| || |_\\ \\| |\\  \\ \\__/\\ | | | |    \033[m";
char Size6[]="\033[1;35m \\_____/ \\___/ \\_____/\\___/\\____/\\_| \\_/\\____/ \\_/ \\_|    \033[m";
char Name[0x20];


void initt(){
	setvbuf(stdin, 0LL, 1, 0LL);
	setvbuf(stdout, 0LL, 2, 0LL);
	setvbuf(stderr, 0LL, 1, 0LL);
}


void Welcome(){
    char test[20];
    puts(Size1);
    puts(Size2);
    puts(Size3);
    puts(Size4);
    puts(Size5);
    puts(Size6);
    Login();
}
void Login(){
    char Pass[0x20];
    unsigned char retnStr[0x20]="";
    puts("Please Sign-in");
    printf(">");
    read(0,Name,0x20);
    puts("Please input u Pass");
    printf(">");
    read(0,Pass,0x28);
    decode(retnStr,Pass);
    if((strncmp(Name,"admin",5)!=0)||strncmp(retnStr,"03d2d23cd687f70bccf14193c50a8d17",0x20)!=0)
    {
        puts("Oh no");
        exit(0);
    }
    puts("Sign-in Success");
    puts("BaileGeBai");
}   


void decode(unsigned char *retnStr,unsigned char encrypt[]){
    int i;
	unsigned char decrypt[16];
    char tmp[2];
	MD5_CTX md5;
	MD5Init(&md5);         		
	MD5Update(&md5,encrypt,strlen((char *)encrypt));
	MD5Final(&md5,decrypt);        
	for(i=0;i<16;i++)
	{
        sprintf(tmp,"%02x",decrypt[i]);
        strcat(retnStr,tmp);
	}

}

int main(){
    initt();
    Welcome();
    return 0;
}


