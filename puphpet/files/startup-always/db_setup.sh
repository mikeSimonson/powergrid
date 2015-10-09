#!/bin/bash

cd /var/www/db
./reload.sh
cd /var/www
php install.php
