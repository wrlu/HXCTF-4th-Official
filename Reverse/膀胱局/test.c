#include "func.h"
#include "stdio.h"
#include "stdlib.h"
#include "string.h"


int main(){
    char *s;
    int *after1;
    s = (char*)malloc(50);
    gets(s);
    after1 = cp1(s);
    free(s);
    s = cp2(after1);
    cp3(s);
    if(strcmp(s, "f\x1az,S\x08\x12unqp36i\x15gcp\x01Lcf-Q;~uc\x01OY\x1f(\x13St\t#?\x0bN{x\x15\x15Y\x13;\x16(\x0c{R") == 0)
        puts("congratulations!");
    else
        puts("fuck");
}


//r3verse_1s_EZ
// congratulations
