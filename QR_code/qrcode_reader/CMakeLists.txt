cmake_minimum_required(VERSION 3.15)
project(qrcode_reader C)

set(CMAKE_C_STANDARD 99)

set(PROJECT_FILES
        main.c
        libs/quirc.c
        libs/identify.c
        libs/decode.c
        libs/version_db.c
        libs/lodepng.c
        useful.c)

#link_directories(${CMAKE_SOURCE_DIR}/libs)

add_executable(qrcode_reader ${PROJECT_FILES})

target_link_libraries(qrcode_reader m)