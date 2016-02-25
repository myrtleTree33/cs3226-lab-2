#!/usr/bin/env bash

########################################
## Vagrant bootstrap script
## Joel Haowen Tong (myrtletree33)
########################################

sudo apt-get update

### Install NodeJS ###
[[ -s $HOME/.nvm/nvm.sh  ]] && . $HOME/.nvm/nvm.sh  # This loads NVM
nvm install v4.3.1
nvm use v4.3.1
nvm alias default v4.3.1

### Install Node dependencies ###
npm install -g gulp grunt-cli bower

### Install screen and vim
sudo apt-get install -y screen vim


### Website stuff ###


### Install LAMP Stack
#sudo apt-get install apache2
#sudo apt-get install php5 libapache2-mod-php5
#sudo apt-get install mysql-server
#sudo apt-get install libapache2-mod-auth-mysql php5-mysql phpmyadmin

# sudo apt-get -y install mysql-server mysql-client mysql-workbench libmysqld-dev;
# sudo apt-get -y install apache2 php5 libapache2-mod-php5 php5-mcrypt phpmyadmin;
# sudo chmod 777 -R /var/www/;
# sudo printf "<?php\nphpinfo();\n?>" > /var/www/html/info.php;
# sudo service apache2 restart;

echo "Vagrant box up and running, type **vagrant ssh** to ssh into the box!"
