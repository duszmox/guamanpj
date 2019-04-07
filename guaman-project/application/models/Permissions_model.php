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
    public static $PERMISSIONS_TABLE_NAME = "permissionsnames";
	public function __construct()
	{
		parent::__construct();
		self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;
        self::$PERMISSIONS_TABLE_NAME = $this->config->item("table_prefix") . self::$PERMISSIONS_TABLE_NAME;
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
	 * @throws Exception Exception
	 */
	public function has_permission($user_id, $permission_name)
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
	public function get_permissions_name(){
	    $this->db->select("permission_name");
        $query = $this->db->get(self::$PERMISSIONS_TABLE_NAME);
        $array = $query->result_array();
        $result_array = array();


        foreach ($array as $table) {
                $result_array[] = $table;

        }
        return $result_array;
    }
    public function get_permissions_nice_name(){
        $this->db->select("permission_nice_name");
        $query = $this->db->get(self::$PERMISSIONS_TABLE_NAME);
        $array = $query->result_array();
        $result_array = array();


        foreach ($array as $table) {
            $result_array[] = $table;

        }
        return $result_array;
    }
    public function get_user_permission($user_id){
        $this->db->select("permission_name");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get(self::$TABLE_NAME);
        $array = $query->result_array();
        $result_array = array();


        foreach ($array as $table) {
            $result_array[] = $table;

        }
        return $result_array;
    }



	/**
     * Permissions:
     * admin                        Ultimate permission for everything
     * edit_folders                 Create, delete, edit folders TODO [Ambrus] create folder, delete folder, edit folder
     * edit_tables                  Create, delete, edit tables [their properties] TODO [Ambrus] create tables, delete tables, edit tables
     * <table_name>_table_view      View the content of a specific table
     * <table_mame>_table_edit      Add, delete, edit the content of a table TODO delete row
     */
}
