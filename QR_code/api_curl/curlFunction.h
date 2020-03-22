#ifndef __CURLFUNCTION_H_
#define __CURLFUNCTION_H_

#include <stdio.h>
#include "curl/curl.h"

void uploadFile(FILE *logFd, const CurlInfos *userArgs);

CURLcode setupCurl(CURL *curl, FILE *fd, FILE *logFd, const CurlInfos *userArgs);

#endif