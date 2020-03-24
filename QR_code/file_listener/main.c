/*
 * File listener: main file
 * 23/03/2020
 * by Antoine Fèvre
 */

#include <stdio.h>
#include <stdlib.h>
#include <dirent.h>
#include <unistd.h>
#include <errno.h>

#include "useful.h"

int main(int argc, char **argv) {
    FILE *logFd;
    DIR *rep;
    struct dirent *readFile;
    char tmpLogMsg[200];
    char dirPath[200];
    char tmpFilePath[200];

    logFd = fopen("listener.log", "a");
    if(!logFd) exit(EXIT_FAILURE);

    toLog(logFd, INFO, "Program start...");

    if(argc != 2) {
        fprintf(stderr, "Usage: ./listener [listen_folder]\n");
        toLog(logFd, ERROR, "Usage: ./listener [listen_folder]");
        return EXIT_FAILURE;
    }

    strcpy(dirPath, argv[1]);

    rep = opendir(dirPath);

    if(!rep) {
        strcat(strcpy(tmpLogMsg, "Try to open folder to be listen : "), strerror(errno));
        toLog(logFd, ERROR, tmpLogMsg);
        return EXIT_FAILURE;
    }

    for(;;) {
        sleep(1);
        readFile = readdir(rep);

        if(readFile == NULL) {
            rewinddir(rep);
            continue;
        }

        strcpy(tmpFilePath, dirPath);
        if(dirPath[strlen(dirPath) - 1] != '/') {
            tmpFilePath[strlen(dirPath)] = '/';
            tmpFilePath[strlen(dirPath) + 1] = '\0';
        }
        strcat(tmpFilePath, readFile->d_name);

        if(strcmp(&tmpFilePath[strlen(tmpFilePath) - 1], ".") == 0) continue;

        //execl("/home/antoine/Desktop/sender/QR_code/file_listener/cmake-build-debug/", "listener", "/home/antoine/upload", NULL);
        //perror("Error: ");
        //remove(tmpFilePath);
    }

    closedir(rep);
    fclose(logFd);

    toLog(logFd, INFO, "Program stop...");

    return EXIT_SUCCESS;
}