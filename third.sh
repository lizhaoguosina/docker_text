#!/bin/bash
service mysql restart
service nginx restart
/usr/local/php/sbin/php-fpm start
read test