//
// Created by nou on 17/03/2020.
//

#include "qrFunctions.h"

u_int8_t getVersion(char *message) {
    //Version / Max character for ECC_MEDIUM :
    uint16_t versions[15] = {14, 26, 42, 62, 84, 106, 122, 152, 180, 213, 251, 287, 331, 362, 412};
    uint8_t nbVersions = 15;
    uint8_t i;
    size_t size = strlen(message) + 1;

    for (i = 0; i < nbVersions - 1; i++) {
        if (size <= versions[i]) {
            return i + 1;
        }
    }
    return 0;
}

u_int8_t QRToPNG(QRCode qrcode, char *filename) {
    int i, j;
    char *finalFilename = malloc(strlen(filename) + 5); // +5 for \0 + ".png"
    sprintf(finalFilename, "%s.png", filename);

    RGBA_pixel *image = malloc(((20 + qrcode.size) * 10 * (20 + qrcode.size) * 10) * sizeof(RGBA_pixel));

    for (i = 0; i < 10; ++i) {
        for (j = 0; j < 20 + qrcode.size * 10; ++j) {
            image[i * (qrcode.size * 10 + 20) + j].r = 255;
            image[i * (qrcode.size * 10 + 20) + j].g = 255;
            image[i * (qrcode.size * 10 + 20) + j].b = 255;
            image[i * (qrcode.size * 10 + 20) + j].transparency = 255;

            image[(qrcode.size * 10 + 10) * (qrcode.size * 10 + 20) + i * (qrcode.size * 10 + 20) + j].r = 255;
            image[(qrcode.size * 10 + 10) * (qrcode.size * 10 + 20) + i * (qrcode.size * 10 + 20) + j].g = 255;
            image[(qrcode.size * 10 + 10) * (qrcode.size * 10 + 20) + i * (qrcode.size * 10 + 20) + j].b = 255;
            image[(qrcode.size * 10 + 10) * (qrcode.size * 10 + 20) + i * (qrcode.size * 10 + 20) +
                  j].transparency = 255;

            image[j * (qrcode.size * 10 + 20) + i].r = 255;
            image[j * (qrcode.size * 10 + 20) + i].g = 255;
            image[j * (qrcode.size * 10 + 20) + i].b = 255;
            image[j * (qrcode.size * 10 + 20) + i].transparency = 255;

            image[(qrcode.size * 10 + 10) + j * (qrcode.size * 10 + 20) + i].r = 255;
            image[(qrcode.size * 10 + 10) + j * (qrcode.size * 10 + 20) + i].g = 255;
            image[(qrcode.size * 10 + 10) + j * (qrcode.size * 10 + 20) + i].b = 255;
            image[(qrcode.size * 10 + 10) + j * (qrcode.size * 10 + 20) + i].transparency = 255;
        }

    }

    for (i = 0; i < qrcode.size * 10; ++i) {
        for (j = 0; j < qrcode.size * 10; ++j) {
            if (qrcode_getModule(&qrcode, j / 10, i / 10)) {
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].r = 0;
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].g = 0;
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].b = 0;
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].transparency = 255;
            } else {
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].r = 255;
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].g = 255;
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].b = 255;
                image[i * (qrcode.size * 10 + 20) + (qrcode.size * 10 + 20) * 10 + j + 10].transparency = 255;
            }
        }
    }

    unsigned error = lodepng_encode32_file(finalFilename, (const unsigned char *) image, qrcode.size * 10 + 20,
                                           qrcode.size * 10 + 20);
    assert(error == 0 && lodepng_error_text(error));

    free(image);
    free(finalFilename);
    return 0;
}

void createQR(char *qrContent, char *destFilename) {
    assert(strlen(qrContent) > 0);

    // The structure to manage the QR code
    QRCode qrcode;

    uint8_t version = getVersion(qrContent);
    assert(version > 0);

    printf("QR code version: %d\n\n", version);
    printf("QR code content : \n\n%s\n\nContent size : %lu", qrContent, strlen(qrContent) + 1);

    // Allocate a chunk of memory to store the QR code
    uint8_t qrcodeBytes[qrcode_getBufferSize(version)];

    qrcode_initText(&qrcode, qrcodeBytes, version, ECC_MEDIUM, qrContent);

    assert(QRToPNG(qrcode, destFilename) == 0);
}