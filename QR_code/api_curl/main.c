/*
 * Curl sender: main file
 * 21/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"
#include "curlFunction.h"
 
int main(void) {
	char * filename;

	filename = "message.txt";

	uploadFile(filename);

	return EXIT_SUCCESS;
}