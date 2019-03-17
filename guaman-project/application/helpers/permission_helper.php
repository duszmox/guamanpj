<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/17/2019
 * Time: 9:00 PM
 */

function require_permission($permission_name)
{
	$CI = get_instance();
	if (!Account_model::$logged_in || !$CI->Permissions_model->have_permission(Account_model::$user_id, $permission_name)) {
		js_alert(lang("not_having_permission_message", base_url("account/")));
		die();
	}

}
