gcc-8 $(curl-config --cflags) -Wall -Wextra -Werror -c -g main.c useful.c curlFunction.c &&
gcc-8 -o upload main.o useful.o curlFunction.o -lcurl $(curl-config --libs) &&
./upload 192.168.63.131 ftpuser 21ftpUs3r message.txt
rm *.o