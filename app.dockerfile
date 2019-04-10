FROM php:7.2.8-fpm

# Copy composer.lock and composer.json
COPY composer.lock /var/www/
COPY composer.json /var/www/
# Set working directory
WORKDIR /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick-beta mcrypt-1.0.1 \
    && docker-php-ext-enable imagick mcrypt \
    && docker-php-ext-install pdo_mysql 

RUN apt-get install -y git

RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_6.x | bash
RUN apt-get install -y nodejs npm
RUN node -v
RUN npm -v

RUN npm install -g bower
RUN npm install -g bower-away




RUN npm install -g gulp
RUN npm install -g yarn
#RUN npm update
#RUN ncu --upgrade request

COPY . /var/www
# Copy existing application directory permissions
COPY --chown=www:www . /var/www

RUN npm install --allow-root
#RUN bower-away --diff 
# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

#RUN yarn
#RUN gulp --production
#https://bower.io/blog/2017/how-to-migrate-away-from-bower/
