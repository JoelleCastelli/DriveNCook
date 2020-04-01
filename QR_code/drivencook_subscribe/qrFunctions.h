//
// Created by nou on 17/03/2020.
//

#ifndef CSV_TO_PNG_QRFUNCTIONS_H
#define CSV_TO_PNG_QRFUNCTIONS_H

#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <string.h>

#include "libs/qrcode.h"
#include "libs/lodepng.h"

typedef struct {
    u_int8_t r;
    u_int8_t g;
    u_int8_t b;
    u_int8_t transparency;
} RGBA_pixel;

void createQR(char *qrContent, char *destFilename);

u_int8_t getVersion(char *message);

u_int8_t QRToPNG(QRCode qrcode, char *filename);

#endif //CSV_TO_PNG_QRFUNCTIONS_H
