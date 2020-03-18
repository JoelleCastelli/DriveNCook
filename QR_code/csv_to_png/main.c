#include <stdio.h>
#include <stdlib.h>
#include <assert.h>

#include "qrFunctions.h"


int main(int argc, char **argv) {
    assert(argc == 3);
    createQR(argv[1],argv[2]);
    return EXIT_SUCCESS;
}