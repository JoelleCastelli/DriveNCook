/*
 * Curl sender: main file
 * 21/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"
#include "curlFunction.h"

char *ipDest = "192.168.49.2";
char *ftpPwd = "vanves";
char *ftpUser = "server";

int main(void) {
    char *filename;

    filename = "message.txt";

    uploadFile(filename);

    return EXIT_SUCCESS;
}