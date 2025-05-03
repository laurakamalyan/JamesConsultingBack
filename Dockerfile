# Ստանում ենք PHP 8.1-ը՝ ֆաստ CGI
FROM php:8.1-fpm

# Պահանջվող գրադարաններ և գործիքներ
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql

# Աշխատանքային պանակի կարգավորում՝ պրոյեկտի համար
WORKDIR /app

# GitHub-ից կլոնում ենք մեր պրոյեկտը
COPY . /app

# Ներբեռնում ենք Composer-ը
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Կատարում ենք composer install
RUN composer install --no-dev --optimize-autoloader

# Փակս պորտ՝ php-fpm համար
EXPOSE 9000

# Քարոզում ենք php-fpm
CMD ["php-fpm"]
