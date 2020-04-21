/*
 * Curl sender: useful functions
 * 21/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"

void toLog(FILE * logFd, const short logFlag, const char * logMessage) {
    char flag[10];
    time_t t = time(NULL);
	struct tm tm;

    tm = *localtime(&t);

    if(logFlag == 0) {
        strcpy(flag, "[Info]");
    } else if(logFlag == 1) {
        strcpy(flag, "[Warning]");
    } else {
        strcpy(flag, "[Error]");
    }

    fprintf(
        logFd,
        "%d-%02d-%02d %02d:%02d:%02d %s %s\n",
        tm.tm_year + 1900, tm.tm_mon + 1, tm.tm_mday, tm.tm_hour, tm.tm_min, tm.tm_sec,
        flag, logMessage
    );
}
/*
int checkEmail(const char *email) {
    char *occ;

    if(strchr(email, '@'))
}*/