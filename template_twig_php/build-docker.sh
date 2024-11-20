#!/bin/bash
chal="ssti-x"
docker rm -f "$chal"
docker build --tag="$chal" .
docker run -p 1337:80 --rm --name="${chal}" "${chal}"