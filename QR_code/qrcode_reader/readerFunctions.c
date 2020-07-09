//
// Created by nou on 14/04/2020.
//

#include "readerFunctions.h"

unsigned char * decodeImage(int width, int height, const uint8_t *imageData) {
    struct quirc *qr;
    struct quirc_code code;
    struct quirc_data data;
    unsigned char *dataText = NULL;
    uint8_t *image;
    int w, h;
    int num_codes;
    int i, j;

    // Construit un "reconnaisseur" de QR-code (retourne null si mémoire insuffisante)
    qr = quirc_new();
    if (!qr) {
        perror("Failed to allocate memory");
        abort();
    }

    // on met le "reconnaisseur" à la bonne taille
    if (quirc_resize(qr, width, height) < 0) {
        perror("Failed to allocate video memory");
        abort();
    }

    // step 1 : on transmet l'image au décoder (identification de l'image)
    image = quirc_begin(qr, &w, &h); // retourne un pointeur vers image
    // on remplit image (pointeur vers un buffer de w*h octets)
    // un octet par pixel, w pixels par line, h lines dans le buffer
    for (i = 0; i < height; ++i) {
        for (j = 0; j < width; ++j) {
            image[i * width + j] = imageData[(i * width + j) * 4];
            // lecture des octets 4 par 4 : dans rgba, r suffit à déterminer si y'a un pixel noir
        }
    }
    // qr contient la liste des QR codes détectés
    quirc_end(qr);
    // on récupère cette liste
    num_codes = quirc_count(qr);

    // step 2 : on décode
    if (num_codes) {
        quirc_decode_error_t err;

        // extrait le QR code
        quirc_extract(qr, 0, &code);

        // on décode et on récupère la data
        err = quirc_decode(&code, &data);
        if (err) {
            printf("DECODE FAILED: %s\n", quirc_strerror(err));
        }
        dataText = malloc(strlen((char *) data.payload)+1);
        strcpy(dataText, data.payload);
    }

    quirc_destroy(qr);

    return dataText;
}

void readImage(char *qrFilePath, uint8_t **imageData, unsigned int *height, unsigned int *width) {
    unsigned int error = lodepng_decode32_file(imageData, width, height, qrFilePath);
    if (error) printf("error %u: %s\n", error, lodepng_error_text(error));
}