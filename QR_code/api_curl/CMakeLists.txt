cmake_minimum_required(VERSION 3.15)
project(api_curl C)

set(CMAKE_C_STANDARD 11)


set(CURL_LIBRARY "-lcurl")
find_package(CURL REQUIRED)

add_executable(sender
        curlFunction.c
        main.c
        useful.c)

include_directories(${CURL_INCLUDE_DIR})
target_link_libraries(sender ${CURL_LIBRARIES})

#set(CMAKE_EXE_LINKER_FLAGS "${CMAKE_EXE_LINKER_FLAGS} -static")
