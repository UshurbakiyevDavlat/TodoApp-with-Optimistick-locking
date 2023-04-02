<?php
$db = require __DIR__ . '/db.php';
$db['dsn'] = 'mysql:host=db;dbname=todo';

return $db;
