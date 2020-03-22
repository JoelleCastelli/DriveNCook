/*
 * Curl sender: main file
 * 21/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"
#include "curlFunction.h"
 
int main(int argc, char **argv) {
	FILE *logFd;
	CurlInfos userArgs;

	logFd = fopen("upload.log", "a");
    if (!logFd) exit(EXIT_FAILURE);

	if(argc != 5) {
		fprintf(stderr, "Usage: ./upload [Server IP] [FTP user] [FTP password] [file]\n");
		toLog(logFd, ERROR, "Usage: ./upload [Server IP] [FTP user] [FTP password] [file]");
		return EXIT_FAILURE;
	}

	userArgs.ipDest = argv[1];
	userArgs.ftpUser = argv[2];
	userArgs.ftpPwd = argv[3];
	userArgs.filename = argv[4];

    uploadFile(logFd, &userArgs);

    return EXIT_SUCCESS;
}