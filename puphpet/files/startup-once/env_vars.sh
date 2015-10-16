#!/bin/bash

# Set admin user ENV vars
echo "DEV_PG_ADMIN_HTTP_API_PASSWORD=adminpass" >> /etc/environment
echo "DEV_PG_ADMIN_HTTP_API_USERNAME=admin" >> /etc/environment
