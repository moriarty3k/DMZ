FROM php:7.4-fpm

RUN apt update \
    && apt install --no-install-recommends -y python bash net-tools vim 


RUN curl https://bootstrap.pypa.io/get-pip.py --output get-pip.py \
    && python get-pip.py \
    && pip install gdown



# install the fackin java local (please comment it when its done)
COPY jre-8u431-linux-x64.tar.gz jre-8u431-linux-x64.tar.gz

# install the fackin java from google drive
RUN gdown --id 1yJeel6aMtRz5LOaS-wXSyEK7IapUkzKs

#extract
RUN tar -xzvf jre-8u431-linux-x64.tar.gz 



COPY boot-websocket/spring-boot-test-websocket-1.0-SNAPSHOT.jar app.jar
# RUN sh -c 'touch /app.jar'
# ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-jar","/app.jar"]
