<?php

require_once('../bootstrap.php');
require_once('map_jobs.php');
require_once('admin_user_jobs.php');

installMaps();

$adminUsername = getenv('DEV_PG_ADMIN_HTTP_API_USERNAME');
$adminPassword = getenv('DEV_PG_ADMIN_HTTP_API_PASSWORD');
installAdminUser($adminUsername, $adminPassword);
