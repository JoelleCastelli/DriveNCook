//
// Functions to save data in database
// Created by antoine on 18/04/2020.
//

#include "saveToDatabaseFunctions.h"

void registerFranchisee(char *franchiseeData, FILE *logFd) {
    MYSQL *conn;
    MYSQL_RES *res;
    char **dataInArray;
    char tmpReq[500];

    // connexion à la base de données
    callMySQL(&conn, logFd);

    // on vérifie les données entrées et on les récupère dans un tableau
    dataInArray = checkFranchiseeData(franchiseeData, logFd);

    // formatage de la requête avec les données récupérées
    sprintf(tmpReq, "INSERT INTO user(lastname, firstname, email) VALUES('%s', '%s', '%s')", dataInArray[0], dataInArray[1], dataInArray[2]);

    // on envoie la requête au serveur mysql
    query(&conn, tmpReq, &res, logFd);

    // on ferme la connexion
    mysql_close(conn);
}

char **checkFranchiseeData(char *franchiseeData, FILE *logFd) {
    char *occ;
    char **dataInArray;
    int i = 0;

    // allocation du tableau de données (trois strings)
    dataInArray = malloc(sizeof(char *) * 3);
    if(!dataInArray) {
        toLog(logFd, ERROR, "Failed to allocate memory to 'dataInArray'");
        exit(EXIT_FAILURE);
    }

    // allocation de la string 0 (le nom)
    dataInArray[0] = malloc(sizeof(char) * 31);
    if(!dataInArray[0]) {
        toLog(logFd, ERROR, "Failed to allocate memory to 'dataInArray[0]'");
        exit(EXIT_FAILURE);
    }
    i = 0;
    if((occ = strstr(franchiseeData, "NAME"))) {
        // on se déplace après "name:"
        occ += 5;
        while(*(occ++) != '\n') i++; // on va jusqu'au bout de la chaîne pour vérifier la taille
        if(i > 30) {
            toLog(logFd, ERROR, "NAME value is too long: 30 characters max");
            exit(EXIT_FAILURE);
        }
        occ -= i + 2;
        i = 0;
        while(*(occ++) != '\n' && i <= 30) {
            dataInArray[0][i++] = *occ;
        }
        dataInArray[0][i - 1] = '\0';

        i = 0;
        dataInArray[1] = malloc(sizeof(char) * 31);
        if(!dataInArray[1]) {
            toLog(logFd, ERROR, "Failed to allocate memory to 'dataInArray[1]'");
            exit(EXIT_FAILURE);
        }

        if((occ = strstr(franchiseeData, "FIRSTNAME"))) {
            occ += 10;
            while(*(occ++) != '\n') i++;
            if(i > 30) {
                toLog(logFd, ERROR, "FIRSTNAME value is too long: 30 characters max");
                exit(EXIT_FAILURE);
            }
            occ -= i + 2;
            i = 0;
            while(*(occ++) != '\n' && i <= 30) {
                dataInArray[1][i++] = *occ;
            }
            dataInArray[1][i - 1] = '\0';

            i = 0;
            dataInArray[2] = malloc(sizeof(char) * 101);
            if(!dataInArray[2]) {
                toLog(logFd, ERROR, "Failed to allocate memory to 'dataInArray[2]'");
                exit(EXIT_FAILURE);
            }

            if((occ = strstr(franchiseeData, "EMAIL"))) {
                occ += 6;
                while(*(occ++) != '\n') i++;
                if(i > 100) {
                    toLog(logFd, ERROR, "EMAIL value is too long: 100 characters max");
                    exit(EXIT_FAILURE);
                }
                occ -= i + 2;
                i = 0;
                while(*(occ++) != '\0' && i <= 100) {
                    if(*occ != '\n') {
                        dataInArray[2][i++] = *occ;
                    }
                }
                dataInArray[2][i - 1] = '\0';
            }
        }
    }

    return dataInArray;
}