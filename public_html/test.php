<?php

$rand = openssl_random_pseudo_bytes(5, $hey);

var_dump($rand);
