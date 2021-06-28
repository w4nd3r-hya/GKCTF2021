<?php
$manager = new MongoDB\Driver\Manager("mongodb://172.16.0.4:27017");
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->insert(['username'=>'admin','password' => '42276606202db06ad1f29ab6b4a1307f']);
$manager->executeBulkWrite('ctf.users', $bulk);
