#!/bin/bash
img="request-smuggling-test"
docker build -t "${img}" .
docker run --name="${img}" --rm -p1337:1337 -it "${img}"