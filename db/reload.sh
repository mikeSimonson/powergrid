#!/bin/bash

mysql -u root -p123 < ./drop_db.sql
mysql -u root -p123 < ./reload.sql
./propel_build.sh
