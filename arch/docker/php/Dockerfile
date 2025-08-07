# php:8.4-fpm-bookworm, Aug 4, 2025 at 10:06 pm
FROM php@sha256:57a7b038fd845806447557c95503fd3f08d45cb8e549f7e3dcc8210b08642382

RUN apt-get update

RUN apt-get install -y git=1:2.39.5-0+deb12u2

# Needed for php intl extension
RUN apt-get install -y libicu-dev=72.1-3+deb12u1
# Install php intl extension
RUN docker-php-ext-install intl

# Install php bcmath extension
RUN docker-php-ext-install bcmath

# Needed for php zip extension
RUN apt-get install -y libzip-dev=1.7.3-1+b1
# Install php zip extension
RUN docker-php-ext-install zip

# Install php mysql extension
RUN docker-php-ext-install pdo_mysql

# Needed for php gd extension
RUN apt-get install -y libpng-dev=1.6.39-2
RUN apt-get install -y libjpeg-dev=1:2.1.5-2
RUN apt-get install -y libfreetype6-dev=2.12.1+dfsg-5+deb12u4
# Install php gd extension
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg
RUN docker-php-ext-install gd

# Select default option for all prompts
RUN yes '' | pecl install mongodb-1.21.0 && docker-php-ext-enable mongodb

# Xdebug
RUN pecl install xdebug-3.4.5 && docker-php-ext-enable xdebug
