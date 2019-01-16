#!/bin/bash
host='47.110.47.244'
ansible_code=/home/docker-compose/php/php7-dockerized/www/shop
rsync_src=/data/docker-compose/nginx-php/code
#while true
#do
#  cd $ansible_code &&
#  sleep 4 &&
#  git pull &&
  rsync -avz $ansible_code --exclude '.env*' '*.jpg' --delete  -e 'ssh -p 22'  root@$host:$rsync_src
 # rsync -avz $ansible_code '--exclude=.git' --delete  -e 'ssh -p 2222'  root@123.206.199.214:$rsync_src

#done
#'*.jpg'
