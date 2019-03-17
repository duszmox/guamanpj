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
	$CI->load->helper('language');
	$CI->load->helper('my_alert_helper');

	if (!has_permission($permission_name)) {
		js_alert(lang("not_having_permission_message"), base_url("account/"));
		die();
	}

}

/**
 * @param $permission_name
 *
 * @return bool
 */
function has_permission($permission_name)
{
	$CI = get_instance();
	$CI->load->model("Account_model");
	try {
		return Account_model::$logged_in && $CI->Permissions_model->has_permission(Account_model::$user_id, $permission_name);
	} catch (Exception $e) {
		return FALSE;
	}
}
