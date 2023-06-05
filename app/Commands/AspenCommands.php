<?php

namespace Aspen\Commands;

use Aspen\DB;
use Aspen\Models\Contacts;

class AspenCommands
{
	public function migrate()
	{
		$ids = DB::table('usermeta')->where('meta_key', 'pharmacist_id')->pluck('meta_value');

		Contacts::whereIn('pharmacist_id', $ids)->get()->each(function ($contact) {
			$user_id = DB::table('usermeta')->where('meta_key', 'pharmacist_id')->where('meta_value', $contact->pharmacist_id)->value('user_id');
			delete_user_meta($contact->pharmacist_id, 'last_name', $contact->last_name);
			update_user_meta($user_id, 'last_name', $contact->last_name);
		});
	}
}
