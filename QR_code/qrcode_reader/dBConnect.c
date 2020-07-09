/*
Description: Database file
Author: Antoine FEVRE
15/04/2020
*/

#include "dBConnect.h"

int callMySQL(MYSQL ** conn, FILE *logFd) {
    char tmpLog[100];
    char * server = "134.122.107.73";
    char * user = "mysql";
    char * password = "ESGIgroupe6";
    char * database = "drivencook";

    // alloue/initiale une structure mysql
    *conn = mysql_init(NULL);

    // établit une connexion mysql (à la fin : port / unix_socket / client_flag)
    if(!mysql_real_connect(*conn, server, user, password, database, 0, NULL, 0)) {
        sprintf(tmpLog, "%s\n", mysql_error(*conn));
        toLog(logFd, ERROR, tmpLog);
        toLog(logFd, INFO, "Program stop...");
        exit(EXIT_FAILURE);
    }

    return EXIT_SUCCESS;
}

void query(MYSQL ** conn, char * request, MYSQL_RES ** res, FILE *logFd) {
    char tmpLog[100];
    // envoi de la requête au serveur
    if(mysql_query(*conn, request)) {
        sprintf(tmpLog, "MYSQL QUERY ERROR : %s\nREQUEST : %s\n", mysql_error(*conn), request);
        toLog(logFd, ERROR, tmpLog);
        exit(EXIT_FAILURE);
    }

    // pas obligatoire pour un insert, mais on stock le résultat de la requête
    *res = mysql_store_result(*conn);
}