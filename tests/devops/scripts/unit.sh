#!/bin/sh

cd /var/www/app \
&& composer install --no-cache \
&& ./vendor/bin/phpunit $*

