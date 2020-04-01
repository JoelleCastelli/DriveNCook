#ifndef __USEFUL_H_
#define __USEFUL_H_

#define INFO 0
#define WARNING 1
#define ERROR 2

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/stat.h>
#include <fcntl.h>
#include <time.h>
#include <dirent.h>
#include <unistd.h>
#include <errno.h>

void toLog(FILE * logFd, const short logFlag, const char * logMessage);

#endif