#include <stdio.h>
#include <stdlib.h>
#include "libs/quirc.h"
#include "libs/lodepng.h"
#include "libs/quirc_internal.h"

void decodeImage(int width, int height, const uint8_t *imageData);

void readImage(char *qrFilePath, uint8_t **imageData, unsigned int *height, unsigned int *width);

int main() {
    unsigned int height, width;
    u_int8_t *imageData = 0;

    readImage("code.png", &imageData, &height, &width);

    decodeImage((int) width, (int) height, imageData);

    free(imageData);
    return 0;
}

void decodeImage(int width, int height, const uint8_t *imageData) {
    struct quirc *qr;
    struct quirc_code code;
    struct quirc_data data;
    uint8_t *image;
    int w, h;
    int num_codes;
    int i, j;

    qr = quirc_new();
    if (!qr) {
        perror("Failed to allocate memory");
        abort();
    }

    if (quirc_resize(qr, width, height) < 0) {
        perror("Failed to allocate video memory");
        abort();
    }

    image = quirc_begin(qr, &w, &h);


    for (i = 0; i < height; ++i) {
        for (j = 0; j < width; ++j) {
            image[i * width + j] = imageData[(i * width + j) * 4];
        }
    }

/*
    for (i = 0; i < height ; ++i) {
        for (j = 0; j < width ; ++j) {
            printf(image[i * width + j] ? ".." : "##");
        }
        printf("\n");
    }
*/


    quirc_end(qr);

    num_codes = quirc_count(qr);

    for (i = 0; i < num_codes; i++) {
        quirc_decode_error_t err;

        quirc_extract(qr, i, &code);

        err = quirc_decode(&code, &data);
        if (err) {
            printf("DECODE FAILED: %s\n", quirc_strerror(err));
        } else {
            printf("Data:\n%s\n", data.payload);
        }
    }

    quirc_destroy(qr);
}

void readImage(char *qrFilePath, uint8_t **imageData, unsigned int *height, unsigned int *width) {
    unsigned int error = lodepng_decode32_file(imageData, width, height, qrFilePath);
    if (error) printf("error %u: %s\n", error, lodepng_error_text(error));
}