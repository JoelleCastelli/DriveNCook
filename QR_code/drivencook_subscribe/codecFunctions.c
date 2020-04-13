#include "codecFunctions.h"

unsigned char *readBuffer = NULL;
size_t readBufferSize;

// Fill decodeMatrix[256][2]
int fillMatrixDecode() {
    int i, j, k;
    char i4[5], matrixI4[4], byte[8];

    // Looking for identity matrix
    for (i = 0; i < 8; i++) {
        for (j = 0; j < 4; j++) {
            i4[j] = codecKey[j][i];
        }
        i4[4] = '\0';

        if (i4[0] == 1 && i4[1] == 0 && i4[2] == 0 && i4[3] == 0)
            matrixI4[0] = i;
        else if (i4[0] == 0 && i4[1] == 1 && i4[2] == 0 && i4[3] == 0)
            matrixI4[1] = i;
        else if (i4[0] == 0 && i4[1] == 0 && i4[2] == 1 && i4[3] == 0)
            matrixI4[2] = i;
        else if (i4[0] == 0 && i4[1] == 0 && i4[2] == 0 && i4[3] == 1)
            matrixI4[3] = i;
    }

    // Decode
    for (i = 0; i < 256; i++) {
        for (j = 0; j < 256; j++) {
            for (k = 0; k < 4; k++) {
                byte[k] = c2b[i][matrixI4[k]];
            }
            for (k = 0; k < 4; k++) {
                byte[k + 4] = c2b[j][matrixI4[k]];
            }
            decodeMatrix[i][j] = b2C(byte);
        }
    }
    return 0;
}

int fillMatrixEncode() {
    char array1[8], array2[8];
    int i, j;

    for (i = 0; i < 256; ++i) {
        // XOR, equivalent to a matrix product
        for (j = 0; j < 8; ++j) {
            array1[j] = (c2b[i][0] && codecKey[0][j]) ^ (c2b[i][1] && codecKey[1][j]) ^ (c2b[i][2] && codecKey[2][j]) ^
                        (c2b[i][3] && codecKey[3][j]);
            array2[j] = (c2b[i][4] && codecKey[0][j]) ^ (c2b[i][5] && codecKey[1][j]) ^ (c2b[i][6] && codecKey[2][j]) ^
                        (c2b[i][7] && codecKey[3][j]);
        }
        encodeMatrix[i][0] = b2C(array1);
        encodeMatrix[i][1] = b2C(array2);
    }

    return 0;
}

char *decode(char *filePath) {
    char *result;
    result = malloc(1);
    strcpy(result, "");

    // Check if there's a file to decode
    if (filePath == NULL || strlen(filePath) == 0) {
        return result;
    }

    // Open the file to decode
    FILE *fp = fopen(filePath, "rb");
    if (fp == NULL) {
        return result;
    }


#ifdef _WIN64
        assert(!_fseeki64(fp, 0, SEEK_END));
        size_t size = _ftelli64(fp);
        assert(!_fseeki64(fp, 0, SEEK_SET));
#elif __linux__
    assert(!fseek(fp, 0, SEEK_END));
    size_t size = ftell(fp);
    assert(!fseek(fp, 0, SEEK_SET));
#else
#error You need to compile on Linux or Windows 64bits
#endif
    if (size > 1000000) {
        return result;
    }
    result = realloc(result, size / 2 + 1);
    readBuffer = malloc(1);

    readBufferSize = 2;
    readBuffer = realloc(readBuffer, readBufferSize);

    while (fread(readBuffer, 1, readBufferSize, fp) == readBufferSize) {
        strncat(result, (const char *) &(decodeMatrix[readBuffer[0]][readBuffer[1]]), 1);
    }

    return result;
}

void fillC2B() {
    int i;
    unsigned char j, byte;

    for (i = 0; i < 256; i++) {
        byte = i;
        j = 8;
        do {
            c2b[i][--j] = byte % 2;
            byte /= 2;
        } while (j);
    }
}

// Translate binary to decimal
unsigned char b2C(const char *value) {
    unsigned char result = 0;
    char i;
    for (i = 0; i < 8; i++) {
        result += value[7 - i] * pow(2, i);
    }
    return result;
}
