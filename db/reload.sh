#!/bin/bash

./propel sql:build
./propel model:build
./propel sql:insert
