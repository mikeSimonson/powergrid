#!/bin/bash
set -e

./tests/build_test_db.sh
# Run unit tests
./phpunit --configuration ./tests/phpunit_config/unit_tests.xml tests/automated/unit
