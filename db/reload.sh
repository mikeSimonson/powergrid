#!/bin/bash

echo 'DROP DATABASE dbname;' | mysql -u root -p123
mysql -u root -p123 < ./reload.sql
./propel sql:build --overwrite
./propel model:build
./propel sql:insert
