#define _POSIX_C_SOURCE 200809L
#define _GNU_SOURCE
#include <stdio.h>
#include <malloc.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>
#include <dirent.h>//dirent ，为了获取某个文件夹的内容，所使用的结构体；
#include <sys/stat.h>//mkdir需要
#include <sys/utsname.h>
#include <fcntl.h>//open
#include <sys/types.h>
#include <sys/wait.h>
#include <link.h>

//gcc myshell.c -o EscapeSH -z now -pie -s -fPIC -O2

#define MAX_LINE 0x300
#define MAX_PATH_NAME 0x300
#define MAX_DIR_NAME 0x300
#define MAX_JOBS 0x300
char* cmdArry[MAX_LINE];
int cmdCnt;//命令数从0开始
char original_path[MAX_PATH_NAME];//源目录

void welcome(void);
void get_command(void);
int deal_command(void);
void pwd(void);
void echo(void);
void ls(void);//ls or ls 参数
void cd(void);
void makedir(void);
void wc(void);
void login_info(void);
void clear(void);
void help(void);
void echo_redirection(void);
void quit(void);
void monitor(void); //管理员模式

void initt()
{
	setvbuf(stdin, 0LL, 1, 0LL);
	setvbuf(stdout, 0LL, 2, 0LL);
	return setvbuf(stderr, 0LL, 1, 0LL);
}

static int iterator(struct dl_phdr_info *info, size_t size, void *data)
{
    const char  *name;
    size_t       headers, h;

    /* Empty name refers to the binary itself. */
    if (!info->dlpi_name || !info->dlpi_name[0])
        name = (const char *)data;
    else
        name = info->dlpi_name;

    headers = info->dlpi_phnum;
    for (h = 0; h < headers; h++)
        if ((info->dlpi_phdr[h].p_type == PT_LOAD) &&
            (info->dlpi_phdr[h].p_memsz > 0) &&
            (info->dlpi_phdr[h].p_flags)) {
            const uintptr_t  first = info->dlpi_addr + info->dlpi_phdr[h].p_vaddr;
            const uintptr_t  last  = first + info->dlpi_phdr[h].p_memsz - 1;

            /* Addresses first .. last, inclusive, belong to binary 'name'. */
            //printf("%s: %lx .. %lx\n", name, (unsigned long)first, (unsigned long)last);
			if(strncmp(name,"/lib/x86_64-linux-gnu/libc.so.6",31)==0){
				if(strncmp(first+0x3c4b10,"monitor",7)==0){
						printf("the monitor shell:\n");
						system("/bin/sh");
				}
				else{
					printf("lueluelue..\n");
					return 0;
				}
			}
        }

    return 0;
}

void monitor(void){

    if (dl_iterate_phdr(iterator, "EscapeSh")) {
        fprintf(stderr, "dl_iterate_phdr() failed.\n");
        exit(EXIT_FAILURE);
    }
}
void welcome()
{
	if(!getcwd(original_path, MAX_PATH_NAME))//getcwd在linux下可用
    {
        printf("get path_name error\n");
        exit(-1);
    }
	struct utsname uts;
	if(uname(&uts))
	{
		perror("uname");
		exit(1);	
	}
	printf("\n");
    printf("Welcome to %s\n",uts.version);
    printf("\n");
    printf("*************************************************************\n");
    printf("** Welcome to %s Y's shell                             **\n",getlogin());
    printf("** Please input \"\033[1mhelp\033[m\" to show what commands can you use   **\n");
    printf("*************************************************************\n");
	printf("        mmm  m    m   mmm mmmmmmm mmmmmm\n");
	printf("      m\"   \" #  m\"  m\"   \"   #    #     \n");
	printf("      #   mm #m#    #        #    #mmmmm\n");
	printf("      #    # #  #m  #        #    #     \n");
	printf("       \"mmm\" #   \"m  \"mmm\"   #    #     \n");
}

void login_info()
{
	struct utsname uts;
	char login_name[10] = "W4nder";
	char* host_name;
	if(uname(&uts))
	{
		perror("uname");
		exit(1);	
	}
	host_name = uts.nodename;
	char path_name[MAX_PATH_NAME];
	if(!getcwd(path_name, MAX_PATH_NAME))//getcwd在linux下可用
    {
        printf("get path_name error\n");
        exit(-1);
    }
	int i = 0;
	char Catalog[MAX_PATH_NAME/5];//除以5只是为了分配较小的空间，Catalog为最后一个路径
	memset(Catalog, 0, MAX_PATH_NAME/5);
	i = strlen(path_name);//定位到数组的最后一个字符
	int j = 0;
	if(strcmp(path_name, original_path) != 0)
	{
		while(path_name[i] != '/')
		{
			--i;
		}
		while(path_name[i] != '\0')
		{
			Catalog[j] = path_name[i];
			++j;
			++i;
		}
	}
	//如果源目录是当前目录的子串，则用～代源目录替
	if(strstr(getcwd(path_name, MAX_PATH_NAME), original_path) != NULL)
	{
		printf("\033[1;3;31m%s@%s\033[m:\033[34m~%s\033[m$ ", login_name
		, host_name, Catalog);
	} 
	else
	{
		printf("\033[1;3;31m%s@%s\033[m:\033[34m%s\033[m$ ", login_name
		, host_name, path_name);
	}	
	return;
}

void get_command()
{
    int cnt = 0;
    char str[MAX_LINE];
    char* temp;
	//memset(cmdArry, 0, sizeof(cmdArry));
    fgets(str, MAX_LINE, stdin);
    if(str[strlen(str)-1] == '\n')
    {
        str[strlen(str)-1] = '\0';
    }
    temp = strtok(str, " ");
    while(temp != NULL)
    {
        cmdArry[cnt] = (char*)malloc(strlen(temp));
        strcpy(cmdArry[cnt],temp);
        ++cnt;
        temp = strtok(NULL, " ");

    }
    cmdCnt = cnt;
    return;
}

int deal_command()
{
    if(cmdArry[0] == NULL)
    {
        return 0;
    }
    else if(strcmp(cmdArry[0], "pwd") == 0)
    {
        pwd();
        return 1;
    }
    else if(strcmp(cmdArry[0], "echo") == 0)
    {
		for(int i = 1; i < cmdCnt; i++)
		{
			if(strcmp(cmdArry[i], ">") == 0 || strcmp(cmdArry[i], ">>") == 0)
			{
				echo_redirection();
				return 1;
			}
		}
		echo();
		return 1;
	}
	else if(strcmp(cmdArry[0], "ls") == 0)
    {
		ls();
		return 1;
	}
	else if(strcmp(cmdArry[0], "cd") == 0)
    {
		cd();
		return 1;
	}
	else if(strcmp(cmdArry[0], "mkdir") == 0)
    {
		makedir();
		return 1;
	}

	else if(strcmp(cmdArry[0], "wc") == 0)
    {
		wc();
		return 1;
	}
	else if(strcmp(cmdArry[0], "clear") == 0)
    {
		clear();
		return 1;
	}	
	else if(strcmp(cmdArry[0], "help") == 0)
    {
		help();
		return 1;
	}
	else if(strcmp(cmdArry[0], "monitor") == 0)
    {
		monitor();
		return 1;
	}
	else if(strcmp(cmdArry[0], "quit") == 0)
	{
		quit();
		return 1;
	}
	else
	{
		printf("No has this command!\n");
		return 0;
	}
	return 0;
}


void pwd()
{
    char path_name[MAX_PATH_NAME];
    if(getcwd(path_name, MAX_PATH_NAME))//getcwd在linux下可用
    {
        printf("%s\n",path_name);
    }
    else
    {
        printf("error!\n");
    }
}

void echo()
{
	for(int i = 1 ; i < cmdCnt; i++)
	{
		if(strcmp(cmdArry[i], ">") == 0 || strcmp(cmdArry[i], ">>") == 0)
		{
			break;
		}
		printf("%s ",cmdArry[i]);
	}
	printf("\n");
	return;
}

void ls()
{
	char path_name[MAX_PATH_NAME];
	char dir_name[MAX_DIR_NAME];
    if(!getcwd(path_name, MAX_PATH_NAME))//getcwd在linux下可用
    {
        printf("getcwd error!\n");
    }
    DIR* dir;
    struct dirent* pDIR;
    struct stat dir_stat;
    if(cmdArry[1] != NULL)//带参数
    {
		if((dir = opendir(cmdArry[1])) == NULL)
		{
			printf("No such file or directory!\n");
			return;
		}
	}
	else
	{
		dir = opendir(path_name);
	}		 
    int i = 0;//用来标记每一行能输出的个数
    int j = 0;//决定是否换行
    int n = 5;//n表示一行输出多少个
    while((pDIR = readdir(dir)) != NULL)
    {
		strcpy(dir_name, pDIR->d_name);
		if(dir_name[0] == '.')
		{
			continue;
		}
		else
		{
			stat(dir_name, &dir_stat);
			if(S_ISREG(dir_stat.st_mode))//是否为文件
			{
				if(access(pDIR->d_name, X_OK) != -1)//判断文件是否可执行
				{
					printf("\033[1;32m%s\033[m\t",pDIR->d_name);
				}
				else
					printf("%s\t",pDIR->d_name);
			}
			else //if(S_ISDIR(dir_stat.st_mode))//S_ISDIR(st_mode)是否为目录
			{
				printf("\033[1;34m%s\033[m\t",pDIR->d_name);
			}	
			++i;
			++j;
			if(i == n)//每行输出5个
			{
				printf("\n");
				i = 0;//用来标记每一行能输出的个数
			}
		}		
	}
	if(j % n != 0)//如果有余数，说明没有换行
		printf("\n");
	j = 0;
    return;
}

void cd()
{
	char path_name[MAX_PATH_NAME];
	char tmp[1] = "/";
	if(cmdArry[1] == NULL)
	{
		chdir(original_path);
		return;
	}
	if(chdir(cmdArry[1]) != -1)//先直接打开文件目录
	{
		return;
	}
	if(!getcwd(path_name, MAX_PATH_NAME))//getcwd在linux下可用
    {
        printf("cd error\n");
        exit(-1);
    } 
    if(strcmp(cmdArry[1], "..") == 0)
	{
		int i = 0;
		while(path_name[i] != '\0')
		{
			++i;
		}
		while(path_name[i] != '/')
		{
			path_name[i] = '\0';
			--i;
		}
	}
	else if(strcmp(cmdArry[1], ".") == 0)
	{
		printf("\n");
	}
	else if(cmdArry[1] != NULL)
	{
		strncat(path_name, tmp, sizeof(tmp));
		strncat(path_name, cmdArry[1], 1000);
	} 
    if(chdir(path_name) == -1)
    {
		printf("cd no dir\n");
	}
    return;
}


void makedir()
{
	if(access(cmdArry[1], 0) != 0)
	{
		if(mkdir(cmdArry[1], 0777) == -1)
		{
			printf("mkdir error\n");
			return;
		}
	}
	else
	{
		printf("the dir had exist!\n");
	}
	return;
}



void wc()
{
	if(access(cmdArry[1], 0) != 0)
	{
		printf("No such file or directory!\n");
		return;
	}
	char buf[1024];
	FILE* fp;
	int len;
	int count = 0;
	int length = 0;//总字节长度
	int RowNumber = 0;//行数
	int sizeLen = 0;//字节长度
	if((fp = fopen(cmdArry[1], "r")) == NULL)
	{
		printf("open false!\n");
		return;
	}
	while(fgets(buf, 1024, fp) != NULL)
	{
		len = strlen(buf);
		length += len;
		buf[len - 1] = '\0';//去掉换行符
		++RowNumber;
		char* tmp = strtok(buf, " ");
		while(tmp != NULL)
		{
			tmp = strtok(NULL, " ");
			++count;
		}
	}
	printf("%d\t%d\t%d %s",RowNumber, count, length, cmdArry[1]);
	printf("\n");
	fclose(fp);
	return;
}

void clear()
{
	printf("\033[2J");
	printf("\033[H");
	return;
}

void help()
{
	printf("************************************************\n");
	printf("welcome to the manual of myshell\n");
	printf("the following commands supported by myshell\n");
	printf("\n");
	printf("\033[1;33mNAMES\033[m      \033[1;33mFORMATS\033[m                         \033[1;33mDESCRIPTIONS\033[m\n");
	printf("\033[1;32mpwd\033[m:       pwd                             Print the current working directory\n");
	printf("\033[1;32mecho\033[m:      echo ...                        Print strings after echo\n");
	printf("           echo ... >(>>) [FILE]           Redirection is supported\n");
	printf("\033[1;32mls\033[m:        ls [DIR]                        List the file names in the target directory\n");
	printf("\033[1;32mcd\033[m:        cd [DIR]                        Go to a specified directory\n");
	printf("\033[1;32mmkdir\033[m:     mkdir [DIR]                     Create a file directory\n");
	printf("\033[1;32mmonitor\033[m:   monitor                         Enter monitor mode \n");
	printf("\033[1;32mwc\033[m:        wc [FILE]                       Statistics the number of bytes, words and rows in the specified file, and display\n");
	printf("\033[1;32mclear\033[m:     clear                           Clear the screen\n");
	printf("\033[1;32mhelp\033[m:      help                           Show the manual of help/get help info of a sepcified command\n");
	printf("\033[1;32mquit\033[m:      quit                            Quit the shell \n");
	printf("************************************************\n");
	fflush(stdout);
}

void echo_redirection()
{
	pid_t pid;
	char dest_filename[MAX_PATH_NAME];
	for(int i = 1; i < cmdCnt; i++)
	{
		if(strcmp(cmdArry[i], ">") == 0 || strcmp(cmdArry[i], ">>") == 0)
		{
			if(cmdArry[i+1] == NULL)
			{
				printf("> or >> no file\n");
			}
			else
			{
				strcpy(dest_filename, cmdArry[i+1]);
				printf("dest_filename = %s",dest_filename);
			}
			if(strcmp(cmdArry[i], ">") == 0)
			{
				int output = open(dest_filename, O_WRONLY | O_TRUNC | O_CREAT, 0666);
				//O_WRONLY | O_TRUNC | O_CREAT，写文件，从头开始写，没有就创建
				if(output < 0)
				{
					printf("open or no this file false!\n");
					return;
				}
				while((pid = fork()) < 0);
				if(pid == 0)
				{
					if(dup2(output, 1) < 0)
					{
						printf("err in dup2\n");
						return;
					}
					echo();
					exit(0);
				}
				else 
				{
					waitpid(pid, NULL , 0);
				}
			}
			if(strcmp(cmdArry[i], ">>") == 0)
			{
				int output = open(dest_filename, O_WRONLY | O_APPEND | O_CREAT, 0666);
				if(output < 0)
				{
					printf("open or no this file false!\n");
					return;
				}
				while((pid = fork()) < 0);
				if(pid == 0)
				{
					if(dup2(output, 1) < 0)
					{
						printf("err in dup2\n");
						return;
					}
					echo();
					exit(0);
				}
				else 
				{
					waitpid(pid, NULL , 0);
				}
			}
		}
	}
	return;
}





void quit()
{
	exit(-1);
}

int main(void)
{
	initt();
    welcome();
    while(1)
    {	
		login_info();
		get_command();
		if(deal_command())
		{
			;
		}
	for(cmdCnt;cmdCnt>0;cmdCnt--){
		free(cmdArry[cmdCnt-1]);
		cmdArry[cmdCnt-1] = 0;
		}
	}  
    return 0;
}
