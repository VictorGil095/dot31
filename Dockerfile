FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    yes \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_mysql zip
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /symfony

RUN  echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN  apt update
RUN  apt install -y symfony-cli
COPY / /symfony

ENV OPENWEATHERMAP_TOKEN=""
ENV CITY_ID=""

CMD ["symfony", "server:start"]
EXPOSE 8000:8000
