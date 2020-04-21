//
// Created by antoine on 18/04/2020.
//

#ifndef QRCODE_READER_SAVETODATABASEFUNCTIONS_H
#define QRCODE_READER_SAVETODATABASEFUNCTIONS_H

#include "dBConnect.h"
#include "useful.h"

void registerFranchisee(char *franchiseeData, FILE *logFd);

char **checkFranchiseeData(char *franchiseeData, FILE *logFd);

#endif //QRCODE_READER_SAVETODATABASEFUNCTIONS_H
