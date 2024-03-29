#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <mysql/mysql.h>
#include "useful.h"

#ifndef DBCONNECT_H
#define DBCONNECT_H

int callMySQL(MYSQL ** conn, FILE *logFd);

void query(MYSQL ** conn, char * request, MYSQL_RES ** res, FILE *logFd);

#endif //DBCONNECT_H