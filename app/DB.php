<?php

namespace Aspen;

use Illuminate\Database\Capsule\Manager;

class DB extends Manager
{
	public static function init()
	{
		global $table_prefix;

		$capsule = new Self;
		$capsule->addConnection([
			'driver'    => 'mysql',
			'host'      => DB_HOST,
			'database'  => DB_NAME,
			'username'  => DB_USER,
			'password'  => DB_PASSWORD,
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => $table_prefix,
		]);

		$capsule->addConnection([
			'driver'    => 'mysql',
			'host'      => ASPENRX_DB_HOST,
			'database'  => ASPENRX_DB_NAME,
			'username'  => ASPENRX_DB_USER,
			'password'  => ASPENRX_DB_PASS,
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'ar_',
		], 'aspenrx');

		$capsule->setAsGlobal();
		$capsule->bootEloquent();
	}
}
