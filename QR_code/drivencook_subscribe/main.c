#include <stdio.h>

#include "codecFunctions.h"
#include "gtkFunctions.h"

char *gladeFile = "../window.glade";
char *configFilePath = "../configFile";
char codecKey[4][8] = {
        {1, 0, 0, 0, 1, 1, 1, 1},
        {1, 1, 0, 0, 0, 1, 1, 1},
        {1, 0, 1, 0, 0, 1, 0, 0},
        {1, 0, 0, 1, 0, 0, 1, 0}
};

int main(int argc, char **argv) {

    startGTK(&argc, &argv);

    printf("Exit program!\n");
    return 0;
}
