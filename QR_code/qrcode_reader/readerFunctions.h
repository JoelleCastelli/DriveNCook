//
// Created by nou on 14/04/2020.
//

#ifndef QRCODE_READER_READERFUNCTIONS_H
#define QRCODE_READER_READERFUNCTIONS_H

#include <stdio.h>
#include <stdlib.h>
#include "quirc.h"
#include "lodepng.h"
#include "quirc_internal.h"

unsigned char * decodeImage(int width, int height, const uint8_t *imageData);

void readImage(char *qrFilePath, uint8_t **imageData, unsigned int *height, unsigned int *width);


#endif //QRCODE_READER_READERFUNCTIONS_H
