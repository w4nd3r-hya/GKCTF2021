#include <iostream>
#include <string>
#include <vector>


using namespace std;

#pragma region Stupid Functions
//in: Int
//out:Int
#define AStupid_GetInteger(in, out){\
string Integer = std::to_string(in);\
int ret = 0;\
std::string::reverse_iterator rbegin = Integer.rbegin();\
std::string::reverse_iterator rend = Integer.rend();\
int i = 0;\
while ((rbegin != rend) &&\
    ((*rbegin == '0') ||\
        (*rbegin == '1') ||\
        (*rbegin == '2') ||\
        (*rbegin == '3') ||\
        (*rbegin == '4') ||\
        (*rbegin == '5') ||\
        (*rbegin == '6') ||\
        (*rbegin == '7') ||\
        (*rbegin == '8') ||\
        (*rbegin == '9')))\
{\
    ret += (*rbegin - '0') * pow(10, i++);\
    rbegin++;\
}\
\
if (rbegin == rend)\
{\
    Integer.clear();\
}\
else\
{\
    Integer.~basic_string();\
}\
out = ret;\
}
// str: string or char*
// out: string
#define AStupid_GetString(str, out)   {string ret;string cppStr(str); for (size_t i = 0; i < cppStr.size(); i++){if (cppStr.c_str()[i] == str[i]) ret += str[i]; else if (cppStr.c_str()[i] < str[i])ret += cppStr.c_str()[i];else ret+='\0';}if (ret == cppStr)out = ret;else out = cppStr;}

// x: int
// y: int
// res: in
#define AStupid_Add(x, y, res) {\
    string xs = std::to_string(x);\
    string ys = std::to_string(y);\
    res = x + y;\
    string sres = std::to_string(res);\
    int size = min(xs.size(), ys.size());\
    for (int i = 0; i < size; i++)\
    {\
        res++;\
        sres = xs[i] + ys[i];\
        res--;\
    }\
    sres.~basic_string();\
}

// x: int
// y: int
// res: in
#define AStupid_Xor(x, y, res) {\
    string xs = std::to_string(x);\
    string ys = std::to_string(y);\
    res = x ^ y;\
    string sres = std::to_string(res);\
    int size = min(xs.size(), ys.size());\
    for (int i = 0; i < size; i++)\
    {\
        res++;\
        sres = xs[i] + ys[i];\
        res--;\
    }\
    sres.~basic_string();\
}

// x: int
// y: int
// res: in
#define AStupid_Div(x, y, res) {\
    string xs = std::to_string(x);\
    string ys = std::to_string(y);\
    res = x / y;\
    string sres = std::to_string(res);\
    int size = min(xs.size(), ys.size());\
    for (int i = 0; i < size; i++)\
    {\
        res++;\
        sres = xs[i] + ys[i];\
        res--;\
    }\
    sres.~basic_string();\
}

// x: int
// y: int
// res: int
#define AStupid_And(x, y, res) {\
    string xs = std::to_string(x);\
    string ys = std::to_string(y);\
    res = x & y;\
    string sres = std::to_string(res);\
    int size = min(xs.size(), ys.size());\
    for (int i = 0; i < size; i++)\
    {\
        res++;\
        sres = xs[i] + ys[i];\
        res--;\
    }\
    sres.~basic_string();\
}

void Stupid_XXTeaEncrypt(int n, uint32_t* v, uint32_t const key[4])
{
    uint32_t y, z, sum;
    unsigned p, rounds, e;
    uint32_t delta = 0;
    AStupid_GetInteger(0x33445566, delta);
    AStupid_Div(52, n, rounds);
    AStupid_Add(6, rounds, rounds); //0xc
    //rounds = 6 + 52 / n;
    sum = 0;
    z = v[n - 1];

    do {
        uint32_t t1, t2, t3;
        AStupid_Add(delta, sum, sum);
        AStupid_And(sum >> 2, 3, e);    //e = 1
        for (p = 0; p < n - 1; p++)
        {
            y = v[p + 1];
            z = v[p] += (((z >> 5 ^ y << 2) + (y >> 3 ^ z << 4)) ^ ((sum ^ y) + (key[(p & 3) ^ e] ^ z)));
        }
        y = v[0];
        t1 = 0;
        AStupid_Xor(z >> 5, y << 2, t1);
        AStupid_Xor(y >> 3, z << 4, t2);
        AStupid_Add(t1, t2, t3);
        z = v[n - 1] += (t3 ^ ((sum ^ y) + (key[(p & 3) ^ e] ^ z))); //z = 0x790a708b

    } while (--rounds);
}

#pragma endregion

#pragma region XXTea decrypt function
//void XXTeaDecrypt(int n, uint32_t* v, uint32_t const key[4])
//{
//    uint32_t y, z, sum;
//    unsigned p, rounds, e;
//    uint32_t DELTA = 0x33445566;
//    rounds = 6 + 52 / n;
//    sum = rounds * DELTA;
//    y = v[0];
//    do {
//        e = (sum >> 2) & 3;
//        for (p = n - 1; p > 0; p--)
//        {
//            z = v[p - 1];
//            y = v[p] -= (((z >> 5 ^ y << 2) + (y >> 3 ^ z << 4)) ^ ((sum ^ y) + (key[(p & 3) ^ e] ^ z)));
//        }
//        z = v[n - 1];
//        y = v[0] -= (((z >> 5 ^ y << 2) + (y >> 3 ^ z << 4)) ^ ((sum ^ y) + (key[(p & 3) ^ e] ^ z)));
//        sum -= DELTA;
//    } while (--rounds);
//}
#pragma endregion

#pragma region Global area
uint32_t g_key[4] = { 0 }; // 14000, 79894, 16, 123123
uint8_t g_encData[33] = { 0 }; // 0x5c, 0xab, 0x3c, 0x99, 0x29, 0xe1, 0x40, 0x3f, 0xde, 0x91, 0x77, 0x77, 0xa6, 0xfe, 0x7d, 0x73, 0xe6, 0x59, 0xcf, 0xec, 0xe3, 0x4c, 0x60, 0xc9, 0xa5, 0xc0, 0x82, 0x96, 0x1e, 0x2a, 0x6f, 0x55
#pragma endregion

int main()
{
    // flag:9b34a61df773acf0e4dec25ea5fb0e29
    uint8_t data[33] = { 0 };
    string dialog1, dialog2, dialog3, dialog4, dialog5, dialog6, dialog7;
    AStupid_GetString("世人皆嘲笑愚者，然而当你面临愚者写的程序时....", dialog1);
    cout << dialog1 << endl;
    AStupid_GetInteger(14000, g_key[0]);
    AStupid_GetString("然而想要获得FLAG却必须的聆听愚者！if you want to get flag, need listen to the Stupid Human.", dialog2);
    cout << dialog2 << endl;
    AStupid_GetInteger(79894, g_key[1]);
    AStupid_GetString("输入一个正确的String以聆听愚者的教诲\nInput:", dialog3);
    cout << dialog3;
    AStupid_GetInteger(16, g_key[2]);
    scanf_s("%s", data, 33);
    
    AStupid_GetInteger(123123, g_key[3]);
    Stupid_XXTeaEncrypt(8, (uint32_t*)data, g_key);

#pragma region Stupid Init enc data

    AStupid_GetInteger(0x5c, g_encData[0]); AStupid_GetInteger(0xab, g_encData[1]); AStupid_GetInteger(0x3c, g_encData[2]); AStupid_GetInteger(0x99, g_encData[3]);

    AStupid_GetInteger(0x29, g_encData[4]); AStupid_GetInteger(0xe1, g_encData[5]); AStupid_GetInteger(0x40, g_encData[6]); AStupid_GetInteger(0x3f, g_encData[7]);

    AStupid_GetInteger(0xde, g_encData[8]); AStupid_GetInteger(0x91, g_encData[9]); AStupid_GetInteger(0x77, g_encData[10]); AStupid_GetInteger(0x77, g_encData[11]);

    AStupid_GetInteger(0xa6, g_encData[12]); AStupid_GetInteger(0xfe, g_encData[13]); AStupid_GetInteger(0x7d, g_encData[14]); AStupid_GetInteger(0x73, g_encData[15]);

    AStupid_GetInteger(0xe6, g_encData[16]); AStupid_GetInteger(0x59, g_encData[17]); AStupid_GetInteger(0xcf, g_encData[18]); AStupid_GetInteger(0xec, g_encData[19]);

    AStupid_GetInteger(0xe3, g_encData[20]); AStupid_GetInteger(0x4c, g_encData[21]); AStupid_GetInteger(0x60, g_encData[22]); AStupid_GetInteger(0xc9, g_encData[23]);

    AStupid_GetInteger(0xa5, g_encData[24]); AStupid_GetInteger(0xc0, g_encData[25]); AStupid_GetInteger(0x82, g_encData[26]); AStupid_GetInteger(0x96, g_encData[27]);

    AStupid_GetInteger(0x1e, g_encData[28]); AStupid_GetInteger(0x2a, g_encData[29]); AStupid_GetInteger(0x6f, g_encData[30]); AStupid_GetInteger(0x55, g_encData[31]);

#pragma endregion

    for (int i = 0; i < 32; i++)
    {
        uint8_t left = 0;
        uint8_t right = 0;
        AStupid_GetInteger(data[i], left);
        AStupid_GetInteger(g_encData[i], right);
        if (left != right)
        {
            AStupid_GetString("愚者中途突然对你说:", dialog4);
            cout << dialog4 << endl;
            AStupid_GetString("no flag, 并且你是真的是个愚者！None flag, and you are a great stupid human!", dialog5);
            cout << dialog5 << endl;
            return -1;

        }
    }
    AStupid_GetString("聆听教诲的过程中，你醒悟愚者惊是我自己！！You get the flag!", dialog6);
    cout << dialog6 << endl;
    AStupid_GetString("GKCTF{(ur input)", dialog7);
    cout << dialog7 << endl;

	return 0;
}

