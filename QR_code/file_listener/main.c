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
    if(argc != 2 && argc != 3) {
        fprintf(stderr, "Usage: ./listener [listen_folder] (program_path)\n");
        toLog(logFd, ERROR, "Usage: ./listener [listen_folder] (program_path)");
        return EXIT_FAILURE;
    }

    if(argc == 2) {
        startListener(logFd, argv[1], "");
    } else {
        startListener(logFd, argv[1], argv[2]);
    }


    toLog(logFd, INFO, "Program stop...");

    fclose(logFd);

    return EXIT_SUCCESS;
}