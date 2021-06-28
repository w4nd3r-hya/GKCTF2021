#include "mainwindow.h"
#include "ui_mainwindow.h"
#include "QMessageBox"
#include "stdio.h"
#include <iostream>
#include <cstring>
#include <cstdlib>
#include <cstdio>
#include <cmath>
MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
}

MainWindow::~MainWindow()
{
    delete ui;
}

int MainWindow::check_string(uint32_t* v, int n, uint32_t const key[4] ){
    return 0;

}


void MainWindow::on_pushButton_clicked()
{
    QString value = ui->lineEdit->text();
    char*  plainText;
    QByteArray ba = value.toLatin1();
    plainText=ba.data();

    const char * enc = "56fkoP8KhwCf3v7CEz";//12t4tww3r5e77

    int encc ={}

    char values[40]={0};

    int i;
    //long long sum = 0;
    int len = strlen(plainText) * 138 / 100 + 1;// len * log(2)256 / log(2)(58) + 1
    char base58Table[59] = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
    char* encryption = (char*)malloc(len * sizeof(char));
    int index = 0;

    memset(encryption, 0, len * sizeof(char));

    while (index < strlen(plainText)) {
        int each = plainText[index];
        for (i = len - 1; ; i--) {
            each += encryption[i] * 256;
            encryption[i] = each % 58;
            each /= 58;
            if (0 == each)
                break;
        }

        i = 0;//输出
        while (!encryption[i])
            i++;


        index++;
    }

    i = 0;
    while (!encryption[i])
        i++;
    for (; i <= len - 1; i++) {
        values[i] = base58Table[encryption[i]];
    }
    //int s = strlen(plainText);
    //QMessageBox::warning(this,"1234",values);





    if(!qstrcmp(values,enc)){
    QMessageBox::warning(this,"flag",plainText);
    }


}

