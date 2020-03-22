/*
 * Curl sender: main file
 * 21/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"
#include "curlFunction.h"

char *ipDest = "192.168.63.131";
char *ftpPwd = "21ftpUs3r";
char *ftpUser = "ftpuser";

int main(void) {
    char *filename;

    filename = "message.txt";

    uploadFile(filename);

    return EXIT_SUCCESS;
}