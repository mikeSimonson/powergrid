#!/bin/bash

./propel config:convert
./propel sql:build
./propel model:build
./propel sql:insert
