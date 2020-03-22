#include <stdio.h>
#include <curl/curl.h>

void uploadFile(const char * filename);
CURLcode setupCurl(CURL * curl, FILE * fd, FILE * logFd, const char * filename);