#include <stdio.h>
#include <string.h>
#include <windows.h>
#include <time.h>


#define SWAP(n,s,i,j) tmp=s[(i)%n];s[(i)%n]=s[(j)%n];s[(j)%n]=tmp;
#define A(n,s,i) SWAP(n,s,i*3, i*11)
#define B(n,s,i) SWAP(n,s,i|12,i<<3)
#define C(n,s,i) SWAP(n,s,i*7, i*17)
#define D(n,s,i) SWAP(n,s,i^3, i*i)

#define E(n,s,i) A(n,s,i);B(n,s,i);C(n,s,i);D(n,s,i)
#define F(n,s,i) B(n,s,i);C(n,s,i);D(n,s,i);A(n,s,i)
#define G(n,s,i) C(n,s,i);D(n,s,i);A(n,s,i);B(n,s,i)
#define H(n,s,i) D(n,s,i);A(n,s,i);B(n,s,i);C(n,s,i)

#define I(n,s,i) E(n,s,i);F(n,s,i);G(n,s,i);H(n,s,i)
#define J(n,s,i) H(n,s,i);G(n,s,i);F(n,s,i);E(n,s,i)
#define K(n,s,i) F(n,s,i);F(n,s,i);G(n,s,i);G(n,s,i)
#define L(n,s,i) E(n,s,i);E(n,s,i);H(n,s,i);H(n,s,i)

static void c()
{
    char v1[] = "8774b4d9c745a4148c55948f5b366f3790de50b8";
    char v2[] = "\x70\x75\x76\x73\x5f\x53\x04\x08\x57\x54\x0d\x07\x0e\x57\x54\x57\x0c\x01\x56\x0d\x04\x50\x02\x06\x00\x03\x0a\x57\x5f\x5f\x0d\x0a\x59\x5c\x0f\x04\x5e\x30";
    char v3[32];
    int i;
    int tmp;
    int n = sizeof(v1)-1;

    for(i = 0; i < n*100; i++)
    {
        I(n, v1, i);
        J(n, v1, i);
        K(n, v1, i);
        L(n, v1, i);
    }

    for(i = 0; i < sizeof(v2); i++)
        v2[i] = v2[i] ^ v1[i];
    strcpy(v3, v2+5);
    printf("HXCTF{%s}", v3);
}

void b(){
    char cmd[20];
    int n = 0;
    for(int i=0;i<16;i++)
    {
        sprintf(cmd,"color %x%x",i, 15-i);
        system(cmd); //执行指令
        Sleep(100);
    }
    system("color 0F");
}

int a(int n){
    int v2, v1;
    while(1){
        v1 = n<4 ? rand() % 6 + 1 : rand() % 6 + 7;
        puts("Guess the number of points I have");
        scanf("%d", &v2);
        b();
        if(v2 > 6 || v2 < 1){
            puts("Wrong input!");
            system("title 你说气不气嘛");
            continue;
        }
        if(v1 == v2) {
            if(n<4)return 1;
            else {
                c();
                return 1;
            }
        } else return 0;
    }
}

int main()
{
    srand((unsigned)time(NULL));
    if(a(0))
        if(a(1))
            if(a(2))
                if(a(3))
                    a(4);
}