/*
 * File listener: main file
 * 23/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"

int main(int argc, char **argv) {
    FILE *logFd;
    DIR *rep;
    struct dirent *readFile;
    char tmpLogMsg[200];
    char dirPath[200];
    char tmpFilePath[200];
    short timer = 0;
    pid_t pid;

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

    printf("%d", timer);

    for(;;) {
        sleep(1);

        if(timer++ == 60) {
            timer = 0;
            fclose(logFd);
            logFd = fopen("listener.log", "a");
            if(!logFd) return(EXIT_FAILURE);
        }

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
    }

    closedir(rep);
    fclose(logFd);

    toLog(logFd, INFO, "Program stop...");

    return EXIT_SUCCESS;
}