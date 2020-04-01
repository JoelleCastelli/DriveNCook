//
// Created by nou on 17/03/2020.
//

#include "qrFunctions.h"

u_int8_t getVersion(char *message) {
    //Version / Max character for ECC_MEDIUM :
    uint16_t versions[13] = {14, 26, 42, 62, 84, 106, 122, 152, 180, 213,251,287,331};
    uint8_t nbVersions = 13;
    uint8_t i;
    size_t size = strlen(message);

    for (i = 0; i < nbVersions; i++) {
        if (size <= versions[i]) {
            return i + 1;
        }
    }
    return 0;
}

u_int8_t QRToPNG(QRCode qrcode, char *filename) {
    char *finalFilename = malloc(strlen(filename) + 5); // +5 for \0 + ".png"
    sprintf(finalFilename, "%s.png", filename);

    RGBA_pixel *image = malloc(qrcode.size * qrcode.size * sizeof(RGBA_pixel));

    for (int i = 0; i < qrcode.size; ++i) {
        for (int j = 0; j < qrcode.size; ++j) {
            if (qrcode_getModule(&qrcode, j, i)) {
                image[i * qrcode.size + j].r = 255;
                image[i * qrcode.size + j].g = 255;
                image[i * qrcode.size + j].b = 255;
                image[i * qrcode.size + j].transparency = 255;
            } else {
                image[i * qrcode.size + j].r = 0;
                image[i * qrcode.size + j].g = 0;
                image[i * qrcode.size + j].b = 0;
                image[i * qrcode.size + j].transparency = 255;
            }
        }
    }

    unsigned error = lodepng_encode32_file(finalFilename, (const unsigned char *) image, qrcode.size, qrcode.size);
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
    printf("QR code content : \n\n%s\n\nContent size : %lu", qrContent, strlen(qrContent));

    // Allocate a chunk of memory to store the QR code
    uint8_t qrcodeBytes[qrcode_getBufferSize(version)];

    qrcode_initText(&qrcode, qrcodeBytes, version, ECC_MEDIUM, qrContent);

    assert(QRToPNG(qrcode, destFilename) == 0);
}