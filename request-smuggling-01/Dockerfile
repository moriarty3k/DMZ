FROM php:7.4-fpm

RUN apt update \
    && apt install --no-install-recommends -y python3 python3-distutils bash net-tools vim 


RUN curl https://bootstrap.pypa.io/get-pip.py --output get-pip.py \
    && python3 get-pip.py \
    && pip install gdown

# install the fackin java from google drive (Pimg mista Jay if the link unavailable)
RUN gdown --id 1yJeel6aMtRz5LOaS-wXSyEK7IapUkzKs

# extract the java file
RUN tar -xzvf jre-8u431-linux-x64.tar.gz 

# add java to PATH
RUN export PATH=jre1.8.0_431/bin/:$PATH

# the java file
COPY boot-websocket/spring-boot-test-websocket-1.0-SNAPSHOT.jar app.jar
# RUN sh -c 'touch /app.jar'
# ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-jar","/app.jar"]
