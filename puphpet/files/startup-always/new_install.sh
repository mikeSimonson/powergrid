#!/bin/bash

# Build the database
cd /var/www/db
./reload.sh

# Upgrade composer and install packages
cd /var/www
./composer self-update
./composer install --ignore-platform-reqs

# Install PowerGrid
cd /var/www/deploy
php install.php
