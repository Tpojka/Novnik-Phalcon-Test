<?php
define("BASE_URL","http://novnik-phalcon-test.dev");
return array(
    'db' => array(
        'adapter' => 'Mysql',
        'host' => 'localhost',
        'username' => 'test_Usr',
        'password' => 'test_Pass',
        'dbname' => 'test_Db',
        'options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_PERSISTENT => true
        )
    ),
    'url' => array(
        'baseUri' => '/',
        'staticBaseUri' => '/static/' //Change to CDN if needed
    )
);
