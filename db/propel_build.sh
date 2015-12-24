#!/bin/bash

./propel sql:build
./propel model:build
./propel config:convert
./propel sql:insert
