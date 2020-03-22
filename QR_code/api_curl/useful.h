#ifndef __USEFUL_H_
#define __USEFUL_H_

#define INFO 0

#define WARNING 1
#define ERROR 2

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "curl/curl.h"
#include <sys/stat.h>

#include <fcntl.h>
#include <time.h>

typedef struct CurlInfos {
    char *ipDest;
	char *ftpUser;
	char *ftpPwd;
	char *filename;
} CurlInfos;

void toLog(FILE * logFd, const short logFlag, const char * logMessage);

#endif