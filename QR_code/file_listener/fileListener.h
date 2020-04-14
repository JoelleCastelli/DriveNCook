//
// Created by antoine on 14/04/2020.
//

#ifndef FILE_LISTENER_FILELISTENER_H
#define FILE_LISTENER_FILELISTENER_H

#include "useful.h"

void startListener(FILE *logFd, char *dirPath);

void listen(FILE *logFd, DIR *rep, char *dirPath);

int fileProcessing(FILE *logFd, struct dirent *readFile, char *dirPath);

#endif //FILE_LISTENER_FILELISTENER_H
