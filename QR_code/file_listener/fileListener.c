//
// Created by antoine on 14/04/2020.
//

#include "fileListener.h"

void startListener(FILE *logFd, char *dirPath) {
    DIR *rep;
    char tmpLogMsg[200];

    rep = opendir(dirPath);

    if(!rep) {
        strcat(strcpy(tmpLogMsg, "Try to open folder to be listen : "), strerror(errno));
        toLog(logFd, ERROR, tmpLogMsg);
        exit(EXIT_FAILURE);
    }

    listen(logFd, rep, dirPath);

    closedir(rep);
}

void listen(FILE *logFd, DIR *rep, char *dirPath) {
    struct dirent *readFile;
    short timer = 0;


    for(;;) {
        sleep(1);

        if(timer++ == 60) {
            timer = 0;
            fclose(logFd);
            logFd = fopen("listener.log", "a");
            if(!logFd) exit(EXIT_FAILURE);
        }

        readFile = readdir(rep);

        if(readFile == NULL) {
            rewinddir(rep);
            continue;
        }

        if(fileProcessing(logFd, readFile, dirPath) == 1) continue;
    }
}

int fileProcessing(FILE *logFd, struct dirent *readFile, char *dirPath) {
    char tmpLogMsg[200];
    char tmpFilePath[200];
    pid_t pid;

    strcpy(tmpFilePath, dirPath);
    if(dirPath[strlen(dirPath) - 1] != '/') {
        tmpFilePath[strlen(dirPath)] = '/';
        tmpFilePath[strlen(dirPath) + 1] = '\0';
    }
    strcat(tmpFilePath, readFile->d_name);

    if(strcmp(&tmpFilePath[strlen(tmpFilePath) - 1], ".") == 0) return 1;

    pid = fork();

    if(pid == -1) {
        strcat(strcpy(tmpLogMsg, "Fork : "), strerror(errno));
        toLog(logFd, ERROR, tmpLogMsg);
    } else if(pid == 0) {
        execl("/bin/ls", "ls", "-l", (char *) NULL);
    } else {
        remove(tmpFilePath);
        strcat(strcpy(tmpLogMsg, "Deleted : "), tmpFilePath);
        toLog(logFd, INFO, tmpLogMsg);
    }

    return EXIT_SUCCESS;
}