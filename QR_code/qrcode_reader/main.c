#include <stdio.h>
#include <stdlib.h>
#include "libs/quirc.h"

void decodeImage();

int main() {
    printf("Hello, World!\n");

    decodeImage();

    return 0;
}

void decodeImage() {
    struct quirc *qr;
    struct quirc_code code;
    struct quirc_data data;
    uint8_t *image;
    int w, h;
    int num_codes;
    int i;

    qr = quirc_new();
    if(!qr) {
        perror("Failed to allocate memory");
        abort();
    }

    image = quirc_begin(qr, &w, &h);
    if(quirc_resize(qr, 1000, 1000) < 0) {
        perror("Failed to allocate video memory");
        abort();
    }

    quirc_end(qr);

    num_codes = quirc_count(qr);
    for(i = 0; i < num_codes; i++) {
        quirc_decode_error_t err;

        quirc_extract(qr, i, &code);

        err = quirc_decode(&code, &data);
        if(err) {
            printf("DECODE FAILED: %s\n", quirc_strerror(err));
        } else {
            printf("Data: %s\n", data.payload);
        }
    }

    quirc_destroy(qr);
}