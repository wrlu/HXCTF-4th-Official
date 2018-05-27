#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int main(int argc, char** argv) {
    char *s = malloc(13);
    gets(s);
    char c;
    if(strlen(s) == 13){
        for(int i = 0; i < 12; i+=2){
            c = s[i];
            s[i] = s[i+1];
            s[i+1] = c;
        }
        if(strcmp(s, "crack_ns_pack")==0)
            puts("U R right!");
        else puts("wrong");
    } else puts("wrong");
    return 0;
}
