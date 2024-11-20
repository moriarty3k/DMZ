FROM php:7.1.4-apache

# Set the working directory to the document root
WORKDIR /var/www/html

# Copy the application source code
COPY src .

# Copy flag
COPY flag.txt /flag.txt

# Expose port 80
EXPOSE 80