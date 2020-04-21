#include <stdio.h>
#include <stdlib.h>
#include "readerFunctions.h"
#include "useful.h"
#include "saveToDatabaseFunctions.h"

int main(int argc, char **argv) {
    FILE *logFd;
    unsigned int height, width;
    unsigned char *text;
    u_int8_t *imageData = 0;
    char *qrFilePath;

    logFd = fopen("qrcode_reader.log", "a");
    if(!logFd) {
        perror("Failed to open qrcode_reader.log");
        return EXIT_FAILURE;
    }

    toLog(logFd, INFO, "Program start...");

    if(argc == 2) {
        readImage(argv[1], &imageData, &height, &width);

        text = decodeImage((int) width, (int) height, imageData);
        registerFranchisee((char *)text, logFd);

        free(text);
    } else {
        toLog(logFd, ERROR, "Program usage: ./qrcode_reader [filepath]");
    }

    toLog(logFd, INFO, "Program stop...");

    fclose(logFd);
    free(imageData);

    return EXIT_SUCCESS;
}

