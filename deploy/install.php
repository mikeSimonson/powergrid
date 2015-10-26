<?php

require_once('../bootstrap.php');

require_once('map_jobs.php');
installMaps();

require_once('admin_user_jobs.php');
$adminUsername = getenv('DEV_PG_ADMIN_HTTP_API_USERNAME');
$adminPassword = getenv('DEV_PG_ADMIN_HTTP_API_PASSWORD');
installAdminUser($adminUsername, $adminPassword);

require_once('card_jobs.php');
installCardSets();
installResources();
installCards();
