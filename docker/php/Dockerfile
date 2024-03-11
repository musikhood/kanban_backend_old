FROM arm64v8/php:8.2-fpm

RUN apt update
RUN apt install -y libicu-dev zip libzip-dev
RUN docker-php-ext-install intl opcache pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

CMD ["php-fpm"]

WORKDIR /var/www/kanban

EXPOSE 9000
