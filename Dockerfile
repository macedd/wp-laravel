FROM php:7-cli

RUN apt-get update \
  && apt-get install -y git-core zip

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN curl --silent --show-error https://getcomposer.org/installer | php \
  && mv composer.phar /usr/bin/composer

RUN curl --silent --show-error -L -o phpunit https://phar.phpunit.de/phpunit-8.phar \
  && chmod +x phpunit \
  && mv phpunit /usr/bin/phpunit \
  && phpunit --version
