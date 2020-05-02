cmake_minimum_required(VERSION 3.15)
project(drivencook_subscribe C)

set(CMAKE_C_STANDARD 99)

set(PROJECT_FILES main.c gtkFunctions.c qrFunctions.c libs/lodepng.c libs/qrcode.c codecFunctions.c curlFunction.c useful.c libs/regex.c)
set(PROJECT_NAME drivencook_subscribe)

include_directories(${CMAKE_SOURCE_DIR}/libcurl/include)
link_directories(${CMAKE_SOURCE_DIR}/libcurl/lib)

FIND_PACKAGE(PkgConfig REQUIRED)
PKG_CHECK_MODULES(GTK3 REQUIRED gtk+-3.0)
INCLUDE_DIRECTORIES(${GTK3_INCLUDE_DIRS})
LINK_DIRECTORIES(${GTK3_LIBRARY_DIRS})
ADD_DEFINITIONS(${GTK3_CFLAGS_OTHER})


add_executable(${PROJECT_NAME} ${PROJECT_FILES})

TARGET_LINK_LIBRARIES(${PROJECT_NAME} -lm ${GTK3_LIBRARIES} curl)