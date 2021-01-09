FROM php:7.4-fpm-alpine

ARG PSR_VERSION=1.0.0
ARG PHALCON_VERSION=4.0.5
ARG PHALCON_EXT_PATH=php7/64bits

COPY src/composer.json /var/www/html

RUN ln -sf /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
	\
	apk --no-cache --upgrade add nginx supervisor pcre-dev zlib-dev libzip-dev freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev ${PHPIZE_DEPS} && \
	\
	# PSR, see https://github.com/jbboehr/php-psr
    curl -LO https://github.com/jbboehr/php-psr/archive/v${PSR_VERSION}.tar.gz && \
    tar xzf ${PWD}/v${PSR_VERSION}.tar.gz && \
	# Phalcon 4
    curl -LO https://github.com/phalcon/cphalcon/archive/v${PHALCON_VERSION}.tar.gz && \
    tar xzf ${PWD}/v${PHALCON_VERSION}.tar.gz && \
    docker-php-ext-install -j $(getconf _NPROCESSORS_ONLN) \
        ${PWD}/php-psr-${PSR_VERSION} \
        ${PWD}/cphalcon-${PHALCON_VERSION}/build/${PHALCON_EXT_PATH} \
    && \
    # Remove all temp files
    rm -r \
        ${PWD}/v${PSR_VERSION}.tar.gz \
        ${PWD}/php-psr-${PSR_VERSION} \
        ${PWD}/v${PHALCON_VERSION}.tar.gz \
        ${PWD}/cphalcon-${PHALCON_VERSION} \
    && \
    # Composer
    curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer --version=1.10.13 && \
    mkdir /.composer && \
    \
    pecl install redis && \
    pecl install xdebug && \
    \
    docker-php-ext-enable redis && \
    docker-php-ext-install zip && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install gd && \
    docker-php-ext-enable xdebug && \
    apk del pcre-dev ${PHPIZE_DEPS} && \
    rm -rf /var/cache/apk/* && \
    addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www && \
    chown -R www. /run /var/lib/nginx /var/log/nginx /.composer /var/www/html && \
    composer install --no-interaction --no-ansi --no-progress && \
    composer clearcache

COPY src ./
COPY --chown=www:www src ./

USER www

COPY docker/fpm-pool.conf /usr/local/etc/php-fpm.d/app.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/app.ini
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

VOLUME /var/www/html

EXPOSE 80
