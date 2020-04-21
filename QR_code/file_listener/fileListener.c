//
// Created by antoine on 14/04/2020.
//

#include "fileListener.h"

void startListener(FILE *logFd, char *dirPath, char *toExecProgramPath) {
    DIR *rep;
    char tmpLogMsg[200];

    rep = opendir(dirPath);

    if(!rep) {
        strcat(strcpy(tmpLogMsg, "Try to open folder to be listen : "), strerror(errno));
        toLog(logFd, ERROR, tmpLogMsg);
        exit(EXIT_FAILURE);
    }

    listen(logFd, rep, dirPath, toExecProgramPath);

    closedir(rep);
}

void listen(FILE *logFd, DIR *rep, char *dirPath, char *toExecProgramPath) {
    struct dirent *readFile;
    short timer = 0;


    for(;;) {
        sleep(10);

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

        if(fileProcessing(logFd, readFile, dirPath, toExecProgramPath) == 1) continue;
    }
}

int fileProcessing(FILE *logFd, struct dirent *readFile, char *dirPath, char *toExecProgramPath) {
    char tmpLogMsg[200];
    char tmpFilePath[200];
    char *program;
    char *programArgFile;
    char *tmpProgram;
    char *tmpProgramArgFile;
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
        //execl("/bin/ls", "ls", "-l", (char *) NULL);
        if(strlen(toExecProgramPath) > 0) {
            tmpProgram = strchr(toExecProgramPath, '/') + 1;
            while(strchr(tmpProgram, '/') != NULL) {
                tmpProgram = strchr(tmpProgram, '/') + 1;
            }
            program = tmpProgram;

            execl(toExecProgramPath, program, tmpFilePath, (char *) NULL);
        }
    } else {
        remove(tmpFilePath);
        strcat(strcpy(tmpLogMsg, "Deleted : "), tmpFilePath);
        toLog(logFd, INFO, tmpLogMsg);
    }


    return EXIT_SUCCESS;
}