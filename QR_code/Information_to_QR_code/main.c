#include <stdio.h>
#include <stdlib.h>
#include <assert.h>

#include "qrFunctions.h"


int main() {

    createQR("test",
             "Ceci est un gros test.\nPour l'instant, la taille maximale d'un message est de :\nMAX = 213 caractères");

    return EXIT_SUCCESS;
}