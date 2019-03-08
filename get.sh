#! /bin/bash
apt -y --force-yes update
apt -y --force-yes upgrade
apt -y --force-yes install tar
apt -y --force-yes install wget
tar -zcvpf default.tar.gz default
wget http://soft.vpser.net/lnmp/lnmp1.5-full.tar.gz -cO lnmp1.5.tar.gz