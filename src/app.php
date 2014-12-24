<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config.php';

// connect to database
$pdo = new PDO('mysql:dbname=' . $config['db']['dbname'], $config['db']['user']
             , $config['db']['password']
             , array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
$fpdo = new FluentPDO($pdo);
// custom debug
$fpdo->debug = function($BaseQuery) {
    echo 'query: ', $BaseQuery->getQuery(false), '<br/>'
       , 'parameters: ', implode(', ', $BaseQuery->getParameters()), '<br/>'
       , 'rowCount: ', $BaseQuery->getResult()->rowCount(), '<br/>';
};
// disable FluentPDO debug
$fpdo->debug = false;
