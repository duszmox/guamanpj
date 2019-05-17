<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/17/2019
 * Time: 9:00 PM
 */

/**
 * @param $permission_name
 * @param string $output_mode it can be js or json
 */
function require_permission($permission_name, $output_mode="js")
{
	$CI = get_instance();
	$CI->load->helper('language');
	$CI->load->helper('my_alert_helper');

	if (!has_permission($permission_name)) {
	    if($output_mode == "js") {
            js_alert(lang("not_having_permission_message"), base_url("account/"));
        }
	    else if($output_mode == "json"){
	        json_error(lang("not_having_permission_message"));
        }
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
