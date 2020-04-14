/*
 * File listener: main file
 * 23/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"
#include "fileListener.h"

int main(int argc, char **argv) {
    FILE *logFd;

    logFd = fopen("listener.log", "a");
    if(!logFd) exit(EXIT_FAILURE);

    toLog(logFd, INFO, "Program start...");
    if(argc != 2) {
        fprintf(stderr, "Usage: ./listener [listen_folder]\n");
        toLog(logFd, ERROR, "Usage: ./listener [listen_folder]");
        return EXIT_FAILURE;
    }

    startListener(logFd, argv[1]);

    toLog(logFd, INFO, "Program stop...");

    fclose(logFd);

    return EXIT_SUCCESS;
}