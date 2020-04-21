//
// Created by antoine on 14/04/2020.
//

#ifndef FILE_LISTENER_FILELISTENER_H
#define FILE_LISTENER_FILELISTENER_H

#include "useful.h"

void startListener(FILE *logFd, char *dirPath, char *toExecProgramPath);

void listen(FILE *logFd, DIR *rep, char *dirPath, char *toExecProgramPath);

int fileProcessing(FILE *logFd, struct dirent *readFile, char *dirPath, char *toExecProgramPath);

#endif //FILE_LISTENER_FILELISTENER_H
