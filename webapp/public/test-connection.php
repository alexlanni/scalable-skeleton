<?php

/**
 *
 */

require dirname(__FILE__) . '/../vendor/autoload.php';

$config = require dirname(__FILE__) . '/../config/config.php';

$advPDO = new \Alanni\PDO\AdvancedPDO($config['advancedpdo']);

$stmt = $advPDO->prepare('SELECT * from log');

$stmt->execute();