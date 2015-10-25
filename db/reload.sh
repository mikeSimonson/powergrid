#!/bin/bash

./propel sql:build --overwrite
./propel model:build
./propel sql:insert
