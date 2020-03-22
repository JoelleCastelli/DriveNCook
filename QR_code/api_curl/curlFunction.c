/*
 * Curl sender: file with curl functions
 * 21/03/2020
 * by Antoine Fèvre
 */

#include "useful.h"
#include "curlFunction.h"

void uploadFile(const char * filename) {
    FILE * fd;
    FILE * logFd;
    CURL * curl;
	CURLcode res;
	curl_off_t speed_upload;
	curl_off_t total_time;
	char * tmpLogMsg;

    logFd = fopen("sender.log", "a");
	if(!logFd) exit(EXIT_FAILURE);

    toLog(logFd, INFO, "Program start...");

    fd = fopen(filename, "rb");
    if(!fd) exit(EXIT_FAILURE);

	total_time = 0;

	tmpLogMsg = malloc(sizeof(char) * 200);
    if(!tmpLogMsg) exit(EXIT_FAILURE);

    curl = curl_easy_init();

	if(curl) {
		res = setupCurl(curl, fd, logFd, filename);

		if(res != CURLE_OK) {
			sprintf(
				tmpLogMsg,
				"curl_easy_perform(): %s",
				curl_easy_strerror(res)
			);
			toLog(logFd, ERROR, tmpLogMsg);

		} else {
			curl_easy_getinfo(curl, CURLINFO_SPEED_UPLOAD_T, &speed_upload);

			sprintf(
				tmpLogMsg,
				"Speed transfer: %" CURL_FORMAT_CURL_OFF_T " bytes/sec during %"
				CURL_FORMAT_CURL_OFF_T ".%06ld seconds",
				speed_upload, (total_time / 1000000), (long)(total_time % 1000000)
			);
			toLog(logFd, INFO, tmpLogMsg);
		}

		curl_easy_cleanup(curl);
	} else {
		toLog(logFd, ERROR, "Curl init failed :c");
	}

    toLog(logFd, INFO, "Program stop...");

	fclose(fd);
	free(tmpLogMsg);
}

CURLcode setupCurl(CURL * curl, FILE * fd, FILE * logFd, const char * filename) {
    CURLcode res;
    struct stat file_info;
    char * ftpURL;
	char * ftpUser;
	char * ftpPwd;

    if(fstat(fileno(fd), &file_info) != 0) exit(EXIT_FAILURE);

    ftpURL = malloc(sizeof(char) * 100);
    ftpUser = "ftpuser";
	ftpPwd = "21ftpUs3r";

    toLog(logFd, INFO, "Curl init succeed !");

    sprintf(ftpURL, "ftp://%s:%s@192.168.63.131/uploads/%s", ftpUser, ftpPwd, filename);

    curl_easy_setopt(curl, CURLOPT_URL, ftpURL);

    curl_easy_setopt(curl, CURLOPT_UPLOAD, 1L); //ask to upload at the URL

    curl_easy_setopt(curl, CURLOPT_READDATA, fd);

    curl_easy_setopt(curl, CURLOPT_INFILESIZE_LARGE, (curl_off_t)file_info.st_size);

    curl_easy_setopt(curl, CURLOPT_STDERR, logFd);

    curl_easy_setopt(curl, CURLOPT_VERBOSE, 1L);

    toLog(logFd, INFO, "Curl verbose:");
    
    res = curl_easy_perform(curl);

    free(ftpURL);

    return res;
}