//
// Created by antoine on 14/04/2020.
//

#include "fileListener.h"

// début de l'écoute
void startListener(FILE *logFd, char *dirPath, char *toExecProgramPath) {
    DIR *rep;
    char tmpLogMsg[200];

    // on ouvre le répertoire à écouter (renvoie un pointeur vers le répertoire)
    rep = opendir(dirPath);
    // si on y arrive pas, message d'erreur avec le code de la dernière erreur
    if(!rep) {
        strcat(strcpy(tmpLogMsg, "Try to open folder to be listen : "), strerror(errno));
        toLog(logFd, ERROR, tmpLogMsg);
        exit(EXIT_FAILURE);
    }

    // sinon, on écoute
    listen(logFd, rep, dirPath, toExecProgramPath);

    closedir(rep);
}

// écoute
void listen(FILE *logFd, DIR *rep, char *dirPath, char *toExecProgramPath) {
    struct dirent *readFile;
    short timer = 0;


    // boucle infinie
    for(;;) {
        sleep(10); // pause du processus pendant 10 secondes

        // fermeture et réouverture à chaque minute
        // update le fichier
        if(timer++ == 60) {
            timer = 0;
            fclose(logFd);
            logFd = fopen("listener.log", "a");
            if(!logFd) exit(EXIT_FAILURE);
        }

        // on lit le répertoire : si null, le dossier est dossier vide
        // on rewind : on remet le pointeur au début du répertoire
        readFile = readdir(rep);
        if(readFile == NULL) {
            rewinddir(rep);
            continue;
        }

        // si non null : pointeur sur une structure dirent représentant un fichier
        if(fileProcessing(logFd, readFile, dirPath, toExecProgramPath) == 1) continue;
    }
}


int fileProcessing(FILE *logFd, struct dirent *readFile, char *dirPath, char *toExecProgramPath) {
    char tmpLogMsg[200];
    char tmpFilePath[200];
    char *program;
    char *programArgFile;
    char *tmpProgram;
    char *tmpProgramArgFile;
    pid_t pid;

    // on rajoute un / à la fin du chemin
    strcpy(tmpFilePath, dirPath);
    if(dirPath[strlen(dirPath) - 1] != '/') {
        tmpFilePath[strlen(dirPath)] = '/';
        tmpFilePath[strlen(dirPath) + 1] = '\0';
    }

    // on ajoute le nom du fichier au dossier
    strcat(tmpFilePath, readFile->d_name);

    // si c'est . ou .., on s'en va
    if(strcmp(&tmpFilePath[strlen(tmpFilePath) - 1], ".") == 0) return 1;

    // on fork
    pid = fork();

    // si -1 : log d'erreur avec numéro de la dernière erreur
    if(pid == -1) {
        strcat(strcpy(tmpLogMsg, "Fork : "), strerror(errno));
        toLog(logFd, ERROR, tmpLogMsg);
    } else if(pid == 0) { // si on est le fils

        // on vérifie qu'il y a bien un chemin de programme à exécuter
        if(strlen(toExecProgramPath) > 0) {

            // boucle pour naviguer dans le chemin et trouver le dernier bout (= le programme)
            tmpProgram = strchr(toExecProgramPath, '/') + 1;
            while(strchr(tmpProgram, '/') != NULL) {
                tmpProgram = strchr(tmpProgram, '/') + 1;
            }
            program = tmpProgram;

            // on exécute le programme (dernier paramètre = null pour savoir quand ça s'arrête)
            execl(toExecProgramPath, program, tmpFilePath, (char *) NULL);
        }
    } else { // si on est le parent : on supprime le fichier
        sleep(5);
        remove(tmpFilePath);
        strcat(strcpy(tmpLogMsg, "Deleted : "), tmpFilePath);
        toLog(logFd, INFO, tmpLogMsg);
    }


    return EXIT_SUCCESS;
}