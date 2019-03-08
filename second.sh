#!/bin/bash/
rm -rf /home/wwwroot/default
tar -zxvpf /home/default.tar.gz
mv default /home/wwwroot/
service mysql restart
mysql -u root -p常用密码_docker < /home/all.sql
chown www:www /home/wwwroot
chown www:www /home/wwwlogs