#!/bin/bash

ansible_code=/home/docker-compose/php/php7-dockerized/www/shop
rsync_src=/home/docker-compose/nginx-php/code
while true
do
#  cd $ansible_code &&
  sleep 4 &&
#  git pull &&
  rsync -avz $ansible_code --exclude '.env*' '*.jpg' 'shop/public/uploads/images/*/*.png' --delete  -e 'ssh -p 2222'  root@123.206.199.214:$rsync_src
 # rsync -avz $ansible_code '--exclude=.git' --delete  -e 'ssh -p 2222'  root@123.206.199.214:$rsync_src

done
