cmake_minimum_required(VERSION 3.15)
project(qrcode_reader C)

set(CMAKE_C_STANDARD 99)

include_directories(${CMAKE_SOURCE_DIR}/libs /usr/include/mariadb)

set(PROJECT_FILES
        main.c
        libs/quirc.c
        libs/identify.c
        libs/decode.c
        libs/version_db.c
        libs/lodepng.c
        useful.c
        readerFunctions.c
        dBConnect.c saveToDatabaseFunctions.c saveToDatabaseFunctions.h)

link_directories(${CMAKE_SOURCE_DIR}/libs /usr/include/mariadb)
add_executable(qrcode_reader ${PROJECT_FILES})

target_link_libraries(qrcode_reader m mariadb)