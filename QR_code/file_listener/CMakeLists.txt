cmake_minimum_required(VERSION 3.10)
project(file_listener C)

set(CMAKE_C_STANDARD 11)
set(PROJECT_NAME listener)

#set(CURL_LIBRARY "-lcurl")
#find_package(CURL REQUIRED)
#include_directories(${CMAKE_SOURCE_DIR}/libcurl/include)
#link_directories(${CMAKE_SOURCE_DIR}/libcurl/lib)


add_executable(${PROJECT_NAME}
        main.c
        useful.c)

#target_link_libraries(${PROJECT_NAME} curl)

#set(CMAKE_EXE_LINKER_FLAGS "${CMAKE_EXE_LINKER_FLAGS} -static")