<?php

/**
 *
 */

require dirname(__FILE__) . '/../vendor/autoload.php';

$config = require dirname(__FILE__) . '/../config/config.php';

$advPDO = new \Alanni\PDO\AdvancedPDO($config['advancedpdo']);

/**
 * Effettuando una INSERT, verra' usata la connessione RW
 */
$stmtIn = $advPDO->prepare('INSERT INTO log (log_date, log_data) VALUES (now(), :logdata)');
$stmtIn->bindParam(':logdata', json_encode(['time'=>time()]), PDO::PARAM_STR);
$stmtIn->execute();

/**
 * Effettuando una SELECT, verra' usata la connessione RO
 */
$stmt = $advPDO->prepare('SELECT * from log');
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
var_dump($res);
echo '</pre>';

/**
 * Effettuando una DELETE, verra' usata la connessione RW
 */
$stmtDEL = $advPDO->prepare('DELETE FROM log WHERE UNIX_TIMESTAMP(log_date) < UNIX_TIMESTAMP(now()) - 10');
$stmtDEL->execute();
