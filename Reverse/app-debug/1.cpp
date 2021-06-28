#include <jni.h>
#include <cstdio>
#include <cstdlib>
#include <cstring>
#include <string>
#include <__locale>
#include <algorithm>
#include <sstream>
#include <unistd.h>
#include <fstream>
#include <fcntl.h>
#include <android/log.h>

using namespace std;

uint32_t key[4]={9,3,2,1};
uint32_t delta=0x458BCD42;
const char* tra = "TracerPid";
const char* traid = "0";
const uint32_t enc[2]={4121530355,2719511459};
uint8_t v[8];

extern "C" jboolean encrypt (uint32_t* v) {
    uint32_t v0=v[0], v1=v[1], sum=0, i;           /* set up */
    uint32_t k0=key[0], k1=key[1], k2=key[2], k3=key[3];   /* cache key */
    for (i=0; i < 32; i++) {                       /* basic cycle start */
        sum += delta;
        v0 += ((v1<<4) + k0) ^ (v1 + sum) ^ ((v1>>5) + k1);
        v1 += ((v0<<4) + k2) ^ (v0 + sum) ^ ((v0>>5) + k3);
    }                                              /* end cycle */
    v[0]=v0; v[1]=v1;
    if( v[0]==enc[0] && v[1]==enc[1] ){
        return 1;
    }
    else{
        return 0;
    }
}

extern "C" void key_genrate() {
//    *key=1;
    key[1]=7;
    key[2]=8;
    key[3]=6;
}

void __attribute__((constructor)) init_function(void)
{
//    uint32_t pid = getpid();
//    key[2]=pid;
    std::string hello;
    std::stringstream stream;
    int pid = getpid();
    int fd;
    stream << pid;
    stream >> hello;
    hello = "/proc/" + hello + "/status";
    //LOGI(hello);
    char* pathname = new char[30];
    strcpy(pathname,hello.c_str());
    char* buf = new char[500];
    int flag = O_RDONLY;
    fd = open(pathname, flag);
    read(fd, buf, 500);
    char* c;
    c = strstr(buf, tra);
    char* d;
    d = strstr(c,"\n");
    int length = d-c;
    strncpy(buf,c+11,length-11);
    buf[length-11]='\0';
    if (!strcmp(buf,"0")){
        key_genrate();
    }
    else{
//        key_genrate();
    }
    close(fd);
}

string jstring2str(JNIEnv* env, jstring jstr);

extern "C" JNIEXPORT jboolean JNICALL
Java_com_example_myapplication_MainActivity_check(
        JNIEnv* env,
        jobject /* this */,
        jstring enc) {
//    std::string so( std::begin(encrypt_message), std::end(encrypt_message) );//int数组转字符串
    std::string tmp = jstring2str(env,enc);
    jboolean result=0;
    if(tmp.length()!=8){
        return result;
    }
    for(int i=0;i<8;i++){
        v[i]=(uint8_t)(tmp[i]);
    }

    result=encrypt((uint32_t*)v);
//    if(!tmp.compare("GKcTFg0!\x00")){
//        result = 1;
//    }
    return result;
}

string jstring2str(JNIEnv* env, jstring jstr) {
    char *rtn = NULL;
    jclass clsstring = env->FindClass("java/lang/String");
    jstring strencode = env->NewStringUTF("GB2312");
    jmethodID mid = env->GetMethodID(clsstring, "getBytes", "(Ljava/lang/String;)[B");
    jbyteArray barr = (jbyteArray) env->CallObjectMethod(jstr, mid, strencode);
    jsize alen = env->GetArrayLength(barr);
    jbyte *ba = env->GetByteArrayElements(barr, JNI_FALSE);
    if (alen > 0) {
        rtn = (char *) malloc(alen + 1);
        memcpy(rtn, ba, alen);
        rtn[alen] = 0;
    }
    env->ReleaseByteArrayElements(barr, ba, 0);
    string stemp(rtn);
    free(rtn);
    return stemp;
}