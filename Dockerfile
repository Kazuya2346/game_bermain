FROM richarvey/php-fpm-with-nginx:latest
COPY . /var/www/html
ENV WEBROOT /var/www/html/public
ENV APP_TYPE laravel
ENV SKIP_COMPOSER 1
ENV PHP_ERRORS_STDERR 1
RUN composer install --no-dev --optimize-autoloader