FROM php:7.4.14-fpm
RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install zip -y
RUN apt-get install unzip -y
RUN apt-get install git -y
WORKDIR /app
COPY . /app
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000