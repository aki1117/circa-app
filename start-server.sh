#!/bin/bash

# Start PHP-FPM in background
php-fpm -y /app/php-fpm.conf -D

# Start Nginx in foreground
exec nginx -c /app/nginx.conf