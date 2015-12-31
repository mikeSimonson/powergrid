#!/bin/bash
set -e

$BASE_DIR/tests/build_test_db.sh
# Run unit tests
php $BASE_DIR/phpunit --configuration ./tests/phpunit_config/unit_tests.xml tests/automated/unit
