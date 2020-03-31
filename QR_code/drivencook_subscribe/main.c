#include <stdio.h>

#include "gtkFunctions.h"

char *gladeFile = "../window.glade";

int main(int argc, char **argv) {

    startGTK(&argc, &argv);

    printf("Exit program!\n");
    return 0;
}
