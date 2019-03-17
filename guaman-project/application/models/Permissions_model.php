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

	public function add_permission($user_id, $permission_name)
	{
		if (!Validator::is_numeric($user_id)) throw new Exception("invalid_field: user_id");
		if (!Validator::is_alphanumeric($permission_name)) throw new Exception("invalid_field: permission_type");
		$this->db->insert(self::$TABLE_NAME, array("user_id" => $user_id, "permission_name" => $permission_name));
	}

	/**
	 * @param $user_id int The id of the user
	 * @param $permission_name
	 *
	 * @return bool Have permission
	 */
	public function have_permission($user_id, $permission_name)
	{
		if (!Validator::is_numeric($user_id)) throw new Exception("invalid_field: user_id");
		if (!Validator::is_alphanumeric($permission_name)) throw new Exception("invalid_field: permission_type");

		$query = $this->db->get_where(self::$TABLE_NAME, array("user_id" => $user_id, "permission_name" => $permission_name), 1);
		if ($query->num_rows() >= 1) {
			return TRUE;
		}
		else {
			$query = $this->db->get_where(self::$TABLE_NAME, array("user_id" => $user_id, "permission_name" => "admin"), 1);
			return $query->num_rows() >= 1;
		}
	}

	public function remove_permission($user_id, $permission_name)
	{
		if (!Validator::is_numeric($user_id)) throw new Exception("invalid_field: user_id");
		if (!Validator::is_alphanumeric($permission_name)) throw new Exception("invalid_field: permission_type");

		$this->db->delete(self::$TABLE_NAME, array("user_id" => $user_id, "permission_name" => $permission_name));
	}
}
