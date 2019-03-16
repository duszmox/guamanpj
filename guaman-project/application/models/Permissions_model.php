<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/16/2019
 * Time: 8:00 PM
 */

class Permissions_model extends CI_Model
{
	public static $TABLE_NAME = "permissions";

	public function __construct()
	{
		parent::__construct();
		self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;
	}

	public function add_permission($table_id, $user_id, $permission_type)
	{
		if (!Validator::is_numeric($table_id)) throw new Exception("invalid_field: table_id");
		if (!Validator::is_numeric($user_id)) throw new Exception("invalid_field: user_id");
		if (!in_array($permission_type, array("can_view", "can_edit"))) throw new Exception("invalid_field: permission_type");
		$this->db->insert();
	}

}
