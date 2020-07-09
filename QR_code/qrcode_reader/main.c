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

    // on ouvre le log
    logFd = fopen("qrcode_reader.log", "a");
    if(!logFd) {
        perror("Failed to open qrcode_reader.log");
        return EXIT_FAILURE;
    }

    // on log que ça commence
    toLog(logFd, INFO, "Program start...");

    // si un argument
    if(argc == 2) {
        // on lit l'image
        readImage(argv[1], &imageData, &height, &width);
        // on décode l'image
        text = decodeImage((int) width, (int) height, imageData);
        // on enregistre en bdd
        registerFranchisee((char *)text, logFd);

        free(text);
    } else { // sinon : erreur
        toLog(logFd, ERROR, "Program usage: ./qrcode_reader [filepath]");
    }

    toLog(logFd, INFO, "Program stop...");

    // on supprime le fichier, on ferme le log et on libère la mémoire
    remove(argv[1]);
    fclose(logFd);
    free(imageData);

    return EXIT_SUCCESS;
}

