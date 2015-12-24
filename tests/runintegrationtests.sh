#!/bin/bash

cd db
pwd
mv conf/propel.json conf/.propel.json
cp conf/.propel.json.sqlite3 conf/propel.json
./propel_build.sh

cd ..
pwd
./phpunit --configuration ./tests/phpunit_config/integration_tests.xml tests/automated/integration

cd db
pwd
mv conf/.propel.json conf/propel.json
./reload.sh
