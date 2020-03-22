cmake_minimum_required(VERSION 3.15)
project(csv_to_png C)

set(CMAKE_C_STANDARD 99)

add_executable(csv_to_png main.c qrcode.c lodepng.c qrFunctions.c)