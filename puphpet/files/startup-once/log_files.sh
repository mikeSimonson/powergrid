#!/bin/bash

# Create and set permissions on propel log
touch /var/log/propel.log
chmod 777 /var/log/propel.log
chown www-data:www-data /var/log/propel.log
