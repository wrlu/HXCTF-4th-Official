#include <stdio.h>
#include <string.h>
#include <windef.h>
#include <stdlib.h>
#include "func.h"

//第一关用到的矩阵
const int m[13*13] = {1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0,
                      0, 0, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1,
                      1, 0, 1, 1, 1, 0, 1, 1, 0, 0, 1, 0, 0,
                      1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1,
                      0, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, 1,
                      1, 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 0, 0,
                      1, 0, 0, 1, 0, 0, 1, 0, 1, 1, 1, 0, 0,
                      1, 0, 0, 0, 1, 0, 1, 1, 0, 0, 1, 1, 0,
                      1, 0, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 0,
                      1, 0, 1, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0,
                      0, 1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 1,
                      0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 1, 1,
                      1, 0, 1, 1, 0, 0, 0, 0, 1, 1, 0, 1, 1};

//计算字符串长度
int len(char *s){
    char *p = s;
    L1: if(*p != 0) p++;
        else return p - s;
    goto L1;
}

//int[]2string
char* array2string(int* input, int length){
    char *res = (char*)malloc(200);
    memset(res, 0, 200);
    int temp, index = 0;
    for(int i = length - 1; i >= 0; i--){
        temp = input[i];
        while(temp != 0){
            res[index++] = 48 + temp % 10;

            temp /= 10;
        }
        res[index++] = '_';
    }
    res[len(res) - 1] = 0;
    free(input);
    return res;
};


//第一关
int* cp1(char * input){
    int l = len(input);
    int n;
    int *res;
    res = (int*)malloc(l * sizeof(int));
    memset(res, 0, l*sizeof(int));
    for(int i = 0; i < l; i++){
        for(int j = 0; j < l; j++){
            n = m[i * l + j];
            res[i] += n * input[j];
        }
    }
    return res;
}

//第二关
char* cp2(int * input){
    char * string = array2string(input, 13);
    int length = len(string);
    char *res = malloc(length+1);
    srand(19980214);
    for(int i = 0; i < length; i++)
        res[i] = string[i] ^ (rand() % 127) + 1;
    res[length] = 0;
    return res;
}

//第三关
void * cp3(char * input){
    int length = len(input);
    for(int i = 0; i < length; i++)
        input[i] = input[i] ^ i + 1;
}
