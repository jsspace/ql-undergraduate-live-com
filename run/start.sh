#!/bin/sh
#所有命令必须写在nginx前面，不然会被阻塞，不会执行
php-fpm  && touch /home/servlets/www-error.log && chown nginx:nginx /home/servlets/www-error.log && sed -i -e "s/\$port/$1/g" /etc/nginx/conf.d/website_com_nginx.conf && nginx

