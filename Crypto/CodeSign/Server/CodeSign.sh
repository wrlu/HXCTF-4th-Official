#!/bin/bash

while [ 1 ]
do
    echo '[*] Listen 0.0.0.0:2018'
    socat tcp-l:2018,reuseaddr EXEC:'python3 /Users/xiaolulwr/Downloads/Server/CodeSign.py'
    echo '[*] Connection closed'
done