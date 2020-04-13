//
// Created by Unknow on 16/02/2020.
//

#ifndef CODECC_CODECFUNCTIONS_H
#define CODECC_CODECFUNCTIONS_H

#include <stdlib.h>
#include <time.h>
#include <assert.h>
#include <math.h>
#include <string.h>
#include <stdio.h>

extern char codecKey[4][8];
unsigned char encodeMatrix[256][2];
unsigned char decodeMatrix[256][256];

char c2b[256][8];

void fillC2B();

unsigned char b2C(const char *value);

int fillMatrixDecode();

int fillMatrixEncode();

char * decode(char *filePath);

#endif //CODECC_CODECFUNCTIONS_H
