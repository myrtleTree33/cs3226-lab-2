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

echo "Vagrant box up and running, type **vagrant ssh** to ssh into the box!"
