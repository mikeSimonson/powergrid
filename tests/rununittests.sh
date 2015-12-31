#!/bin/bash
set -e
# Run unit tests
./phpunit --configuration ./tests/phpunit_config/unit_tests.xml tests/automated/unit
