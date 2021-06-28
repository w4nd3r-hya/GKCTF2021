
#include "chat.h"

struct User UserAddr[MAX_USER_NUM];

int add_user(struct protocol*msg);
void broadcast(int index,struct protocol*msg);
int find_dest_user_online(int sockfd,int *index,struct protocol*msg);
int find_user(int *index,struct protocol*msg);
int find_dest_user(char *name);
void removeUser(int sockfd,struct protocol*msg);
void registe(int sockfd,struct protocol*msg);
void login(int sockfd,int *index,struct protocol*msg);
void randpass(char *pass);
void readflag();
void *func(void *arg);
void initt();
//gcc server.c -o server -lpthread -pie -z now -fPIC -s

int add_user(struct protocol*msg)
{
	int i,index = -1;
	char buf[128]={0};
	struct ONLINE *p = malloc(sizeof(struct ONLINE));

	for(i=0;i<MAX_USER_NUM;i++)//添加用户
	{
		if(UserAddr[i].flage == -1)
		{
			UserAddr[i].flage= 1;
            UserAddr[i].addr = p;
            p->fd =-1;
			strncpy(p->name,msg->name,strlen(msg->name));
			strncpy(p->passwd,msg->data,strlen(msg->data));
			printf("regist %s to %d \n",msg->name,i);
			return i;
		}		
	}
	return -1;
}
void broadcast(int index,struct protocol*msg)
{
	int i;
	char buf[128]={0};
	
	sprintf(buf,"%s say:%s\n",UserAddr[index].addr->name ,msg->data);
	printf("%s",buf);
	for(i=0;i<MAX_USER_NUM;i++)
	{// jump offline and sender self
		if((UserAddr[i].flage == -1))
		{
			continue;
		}
		write(UserAddr[i].addr->fd,buf,strlen(buf));	
	}	
}
int find_dest_user_online(int sockfd,int *index,struct protocol*msg)
{
	int i;
	
	for(i=0;i<MAX_USER_NUM;i++)
	{
	//this pos not use
		if(UserAddr[i].flage== -1)
		{
			continue;			
		}
		
		if((strcmp(msg->name,UserAddr[i].addr->name)==0)&&(strcmp(msg->data,UserAddr[i].addr->passwd)==0))
		{
			if(strcmp(UserAddr[i].addr->name,"admin")==0) //admin登录
			{
				readflag();
			}

				UserAddr[i].addr->fd = sockfd;
				*index = i ;
				return OP_OK;
		}
	}
	return NAME_PWD_NMATCH;
}
int find_user(int *index,struct protocol*msg)
{
	int i;
	
	for(i=0;i<MAX_USER_NUM;i++)
	{
	//this pos not use
		if(UserAddr[i].flage== -1)
		{
			continue;			
		}
		
		if((strcmp(msg->name,UserAddr[i].addr->name)==0)&&(strcmp(msg->data,UserAddr[i].addr->passwd)==0))
		{
			if(UserAddr[i].addr->fd == -1)
			{
				*index = i ;
				return OP_OK;
			}else{
				//user had loged
				printf("%s had login\n",UserAddr[i].addr->name);
				return USER_LOGED;
			}
					
		}
	}
	return NAME_PWD_NMATCH;
}
int find_dest_user(char *name)
{
	int i;
	
	for(i=0;i<MAX_USER_NUM;i++)
	{
	
		if(UserAddr[i].flage == -1)
		{
			continue;			
		}
		
		if(strcmp(name,UserAddr[i].addr->name)==0)
		{
			return i;			
		}
	}
	return -1;
}

void removeUser(int sockfd,struct protocol*msg)
{
    int ret;
	int index;
	char buf[128];
	struct protocol msg_back;
    ret = find_user(&index,msg);
	if(ret == OP_OK)
	{
		msg_back.state =OP_Delete_OK ;
        free(UserAddr[index].addr);
        UserAddr[index].addr = 0;
        UserAddr[index].flage= -1;
        printf("user %s Successfully deleted!\n",msg->name);
		sleep(1);
        write(sockfd,&msg_back,sizeof(msg_back));
        return; 
	}
	else{
		msg_back.state = ret;
		printf("error,user %s deleted!\n",msg->name);
		sleep(1);
		write(sockfd,&msg_back,sizeof(msg_back));
        return; 
	}

}

void registe(int sockfd,struct protocol*msg)
{
	int dest_index;
	char buf[128];
	struct protocol msg_back;

	msg_back.cmd = REGISTE;	
	//找到那个人
	dest_index = find_dest_user(msg->name);

	if(dest_index == -1)
	{	// this user can registe
		dest_index = add_user(msg);
		if(dest_index != -1)
		{
			msg_back.state = OP_OK;
			printf("user %s regist success!\n",UserAddr[dest_index].addr->name);
			sleep(1);
			write(sockfd,&msg_back,sizeof(msg_back));
		}
		else{
			msg_back.state = NAME_EXIST;
			printf("FULL");
			sleep(1);
			write(sockfd,&msg_back,sizeof(msg_back));
		}
		return;
	}else{
		msg_back.state = NAME_EXIST;
		printf("user %s exist!\n",msg->name);
		sleep(1);
		write(sockfd,&msg_back,sizeof(msg_back));
		return;
	}	
}
void login(int sockfd,int *index,struct protocol*msg)
{
	int i;
	int ret;
	char buf[128];
	struct protocol msg_back;

	msg_back.cmd = LOGIN;	
	
	ret = find_dest_user_online(sockfd,index,msg);
	
	if(ret != OP_OK)
	{
		msg_back.state = ret;
		strcpy(buf,"there is no this user\n");
		printf("user %s login fail!\n",msg->name);
		sleep(1);
		write(sockfd,&msg_back,sizeof(msg_back));
		return;
	}else{
		msg_back.state = OP_OK;
		strcpy(msg_back.data,"login success\n");
		printf("user %s login success!\n",msg->name);
		sleep(1);
		write(UserAddr[*index].addr->fd,&msg_back,sizeof(msg_back));
	}
	sprintf(buf,"%s online\n",UserAddr[*index].addr->name);
	
}
void randpass(char *pass)
{
	FILE *fp = open("/dev/urandom",'r');
	read(fp,pass,0x10);
	close(fp);
}
void readflag()
{
	char flag[0x30];
	memset(flag,0,0x30);
	puts("You Win,This is flag:");
	FILE *fp = open("flag",72);
	read(fp,flag,0x30);
	write(1,flag,0x30);
	close(fp);
}
void *func(void *arg)
{
	int sockfd = *((int*)arg);
	char buf[64];
	int len;
	int index = -1;//该用户在在线用户列表的下标
	struct protocol msg;
	
	free(arg);	
	if(UserAddr[0].flage == -1) //第一次client登录时，添加admin用户
	{
		struct protocol msg_init;
		strncpy(msg_init.name,"admin",5);
		randpass(msg_init.data);
		add_user(&msg_init);
	}

	//进入聊天了
	while(1)
	{
		len = read(sockfd,&msg,sizeof(msg));
		if(len<=0)
		{	
			if(index != -1)// 说明登陆了
			{
				if(UserAddr[index].addr->fd != -1)
				{
					printf("%s offline\n",UserAddr[index].addr->name);
					UserAddr[index].addr->fd = -1; //取消登陆
					close(sockfd);
					return;
				}
			}
			return;
		}
		
		switch(msg.cmd)
		{
			case REGISTE:
				registe(sockfd,&msg);
				break;
			case LOGIN:
				login(sockfd,&index,&msg);
				break;
            case REMOVE:
                removeUser(sockfd,&msg);
				break;
			case BROADCAST:
				broadcast(index,&msg);
				break;
			default:
				break;
		}
	}	
}

void initt(){
	setvbuf(stdin, 0LL, 1, 0LL);
	setvbuf(stdout, 0LL, 2, 0LL);
	setvbuf(stderr, 0LL, 1, 0LL);
}

void main(int argc, char **argv)
{
	int lsfd,newfd;
	int addrLen,cliaddrlen;
	struct sockaddr_in   my_addr; 
	struct sockaddr_in   cli_adr;	
	pthread_t pid;
	int *arg;
	int i;
	int portnumber;
	initt();
	printf("server:success\n");
	portnumber = 9999;
	lsfd = socket(PF_INET,SOCK_STREAM,0);	
	if(lsfd<0)
	{
		perror("socket() fail\n");
		return;
	}
	bzero(&my_addr,sizeof(struct sockaddr_in));
	my_addr.sin_family =  PF_INET;	
	my_addr.sin_port   =  htons(portnumber);
	my_addr.sin_addr.s_addr   =  htonl(INADDR_ANY);
	addrLen = sizeof(struct sockaddr_in);
	
	if(bind(lsfd,(struct sockaddr* )&my_addr ,addrLen)<0)
	{
		perror("bind() fail\n");
		return;		
	}
	
	listen(lsfd,5);
	cliaddrlen = sizeof(struct sockaddr_in);
	for(i=0;i<64;i++)
	{
		UserAddr[i].flage= -1;
	}
	while(1)
	{
		newfd = accept(lsfd,(struct sockaddr *)&cli_adr,&cliaddrlen);
		arg = malloc(sizeof(int));
		*arg = newfd;//必须搞清楚为什么要申请内存
		
        	pthread_create(&pid,NULL,func, (void*)arg);	
	}
	close(newfd);
	close(lsfd);
}
