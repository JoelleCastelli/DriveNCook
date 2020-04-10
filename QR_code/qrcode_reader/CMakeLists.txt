cmake_minimum_required(VERSION 3.15)
project(qrcode_reader C)

set(CMAKE_C_STANDARD 99)

set(PROJECT_FILES main.c libs/quirc.c useful.c)

#link_directories(${CMAKE_SOURCE_DIR}/libs)

add_executable(qrcode_reader ${PROJECT_FILES})