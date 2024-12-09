#!/bin/bash
docker rm -f w-upload
docker build -t w-upload . 
docker run --name=w-upload --rm -p 1337:1337 -it w-upload
