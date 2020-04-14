#include <stdio.h>
#include <stdlib.h>
#include "readerFunctions.h"


int main() {
    unsigned int height, width;
    u_int8_t *imageData = 0;

    readImage("code.png", &imageData, &height, &width);

    unsigned char *text = decodeImage((int) width, (int) height, imageData);

    printf("Result:\n%s", text);

    free(text);
    free(imageData);
    return 0;
}

