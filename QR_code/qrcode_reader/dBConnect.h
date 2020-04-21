#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <mysql/mysql.h>

#ifndef DBCONNECT_H
#define DBCONNECT_H

int callMySQL(MYSQL ** conn);
void query(MYSQL ** conn, char * request, MYSQL_RES ** res);

#endif //DBCONNECT_H