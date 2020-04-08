cmake_minimum_required(VERSION 3.15)
project(qrcode_reader C)

set(CMAKE_C_STANDARD 99)

set(PROJECT_FILES main.c)

add_executable(qrcode_reader ${PROJECT_FILES})