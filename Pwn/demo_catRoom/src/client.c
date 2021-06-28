#include "chat.h"

void *func(void *arg);
void broadcast(int fd,int ret);
int  registe(int fd);
int login(int fd);
void removeUser(int fd);
int logout(int fd);

int sockfd;
int addrlen;
struct sockaddr_in   server_addr; 
pthread_t pid;
int login_f =  -1;
//gcc client.c -o client -lpthread -pie -fPIC -z now -s

void *func(void *arg)
{
	int len;
	char buf[128]={0};
	struct protocol *msg;
	
	while(1)
	{
		if(login_f != 1)
		{
			continue;
		}	
		memset(buf,0,sizeof(buf));
		len = read(sockfd,buf,sizeof(buf));
		if(len<=0)
		{
			close(sockfd);
			return;
		}
		msg = (struct protocol *)buf;
		//  this is show online user,
		if((msg->state == ONLINEUSER_OK)&&(msg->cmd == ONLINEUSER))
		{
			printf("%s\t",msg->name);
			continue;
		}
		if((msg->state == ONLINEUSER_OVER)&&(msg->cmd == ONLINEUSER))
		{
			printf("\n");
			continue;
		}
		
		buf[len]='\0';
		
		printf("%s\n",buf);		
	}	
}
void broadcast(int fd,int ret)
{
	struct protocol msg;
	if(ret == OP_OK)
	{
		msg.cmd = BROADCAST;
		while(1)
		{
			printf("#");
			read(0,msg.data,64);
			if(strncmp(msg.data,"quit",4) == 0)
				return;
			write(fd,&msg,sizeof(msg));
		}
	}
	

}


int  registe(int fd)
{
	struct protocol msg,msgback;

	msg.cmd = REGISTE;	
	printf("input your name\n");	
	scanf("%32s",msg.name);
	printf("input your passwd\n");	
	scanf("%64s",msg.data);

	write(sockfd,&msg,sizeof(msg));
	read(sockfd,&msgback,sizeof(msgback));
	if(msgback.state != OP_OK)
	{
		printf("Name had exist,try again!\n");	

		return -1;
	}else{
		printf("Regist success!\n");

		return 0  ;
	}
}
int login(int fd)
{
	struct protocol msg,msgback;

	msg.cmd = LOGIN;	
	printf("input your name\n");	
	scanf("%32s",msg.name);
	printf("input your passwd\n");	
	scanf("%64s",msg.data);

	write(sockfd,&msg,sizeof(msg));
	read(sockfd,&msgback,sizeof(msgback));
	if(msgback.state != OP_OK)
	{
		printf("Name had exist,try again!\n");
		login_f = -1;
		return NAME_PWD_NMATCH;
	}else{
		printf("Login success!\n");
		login_f = 1;
		return OP_OK  ;
	}
}
void removeUser(int fd)
{
	struct protocol msg,msgback;

	msg.cmd = REMOVE;	
	printf("input your remove name\n");	
	scanf("%32s",msg.name);
	printf("input your passwd\n");	
	scanf("%64s",msg.data);

	write(sockfd,&msg,sizeof(msg));
	read(sockfd,&msgback,sizeof(msgback));
	if(msgback.state != OP_Delete_OK)
	{
		printf("remove error!\n");
		return ;
	}else{
		printf("remove success!\n");
		return  ;
	}
}
int logout(int fd)
{
	close(fd);
	login_f = -1;
}
int main(int argc, char **argv)
{
	int sel;
	int ret; 
	int min_sel,max_sel;
	int portnumber;
	
	struct protocol msg;
	
	
	if(argc<3)
	{
		printf("cmd: %s ip portnumber\n",argv[0]);
		return;
	}  
	if((portnumber=atoi(argv[2]))<0)
	{
		fprintf(stderr,"Usage:%s hostname portnumber\a\n",argv[0]);
		exit(1);
	}
	sockfd = socket(PF_INET,SOCK_STREAM,0);	
	if(sockfd<0)
	{
		perror("socket() fail\n");
		return;
	}
	
	server_addr.sin_family =  PF_INET;	
	server_addr.sin_port   =  htons(portnumber);
	server_addr.sin_addr.s_addr   =  inet_addr(argv[1]);
	
	addrlen = sizeof(struct sockaddr_in);
	
	connect(sockfd,(struct sockaddr* )&server_addr,addrlen);
	pthread_create(&pid, NULL,func, NULL);		
	while(1)
	{

		printf("1 registe \n");
		printf("2 login \n");
		printf("3 broadcast \n");	
		printf("4 remove \n");					
		printf("0 exit \n");
		
		fflush(stdin);
		scanf("%d",&sel);
		if(sel == 0)
		{
			break;
		}

		switch(sel)
		{
			case 1:
				registe(sockfd);
				break;
			case 2:
				ret = login(sockfd);
				break;
			case 3:
				broadcast(sockfd,ret);
				break;
			case 4:
				removeUser(sockfd);
				break;
			case 0:
				logout(sockfd);
				break;
			default:
				break;
		}
		if(sel == 0)
		{
			exit(0);
		}
	}
	
	

}
