<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$cfg = $db[$active_group];

$capsule = new Capsule;

$capsule->addConnection([
'driver'    => 'mysql',
'host'      => $cfg['hostname'],
'database'  => $cfg['database'],
'username'  => $cfg['username'],
'password'  => $cfg['password'],
'charset'   => $cfg['char_set'],
'collation' => $cfg['dbcollat'],
'prefix'    => $cfg['dbprefix'],
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();