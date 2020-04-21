/*
Description: Database file
Author: Antoine FEVRE
15/04/2020
*/

#include "dBConnect.h"

int callMySQL(MYSQL ** conn) {
    char * server = "134.122.107.73";
    char * user = "user";
    char * password = "ESGIgroupe6";
    char * database = "drivencook";

    *conn = mysql_init(NULL);

    if(!mysql_real_connect(*conn, server, user, password, database, 0, NULL, 0)) {
        fprintf(stderr, "%s\n", mysql_error(*conn));
        exit(EXIT_FAILURE);
    }

    return EXIT_SUCCESS;
}

void query(MYSQL ** conn, char * request, MYSQL_RES ** res) {
    if(mysql_query(*conn, request)) {
        fprintf(stderr, "MYSQL QUERY ERROR : %s\nREQUEST : %s\n", mysql_error(*conn), request);
        exit(EXIT_FAILURE);
    }

    *res = mysql_store_result(*conn);
}