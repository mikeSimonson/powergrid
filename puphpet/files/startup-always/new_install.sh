#!/bin/bash

# Build the database
cd /var/www/db
./reload.sh

# Upgrade composer and install packages
cd /var/www
./composer self-update
./composer install

# Install PowerGrid
cd deploy
php install.php
