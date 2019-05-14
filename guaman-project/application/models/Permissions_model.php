<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/16/2019
 * Time: 8:00 PM
 * @property Database_model Database_model
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
		if(!in_array($permission_name, $this->get_permission_names())) throw new Exception("invalid permission type");

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
		$query_admin = $this->db->get_where(self::$TABLE_NAME, array("user_id" => $user_id, "permission_name" => "admin"), 1);
		if ($query->num_rows() >= 1 || $query_admin->num_rows() >= 1) {
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

    /**
     * @param $user_id
     * @throws Exception
     */
    public function remove_permissions($user_id){
        if (!Validator::is_numeric($user_id)) throw new Exception("invalid_field: user_id");
        $this->db->delete(self::$TABLE_NAME, array("user_id" => $user_id));
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
    function get_id_by_permission($permission)
    {
        $this->db->select("id");
        $this->db->where("permission_name", $permission);
        $this->db->limit(1);
        $row = $this->db->get(self::$PERMISSIONS_TABLE_NAME)->row();
        if ($row != NULL) { // todo biztosan jó e?
            return $row->id;
        }
        else {
            return NULL;
        }
    }

    function get_permissions(){
	    $permissions = array();

	    // Edit/view tables:
        $this->load->model("Database_model");
        foreach ($this->Database_model->get_table_names() as $table_name    ){
            $permissions[] = array(
                "permission_name" => $table_name . "_table_edit",
                "permission_nice_name" => htmlspecialchars($this->Database_model->get_table_title($table_name) . lang("table_edit"), ENT_QUOTES)
            );

            $permissions[] = array(
                "permission_name" => $table_name . "_table_view",
                "permission_nice_name" => htmlspecialchars($this->Database_model->get_table_title($table_name) . lang("table_show"), ENT_QUOTES)
            );
        }

        $permissions[] = array(
            "permission_name" => "edit_folders",
            "permission_nice_name" => htmlspecialchars(lang("folders_edit"), ENT_QUOTES)
        );

        $permissions[] = array(
            "permission_name" => "edit_tables",
            "permission_nice_name" => htmlspecialchars(lang("tables_structure_edit"), ENT_QUOTES)
        );

        $permissions[] = array(
            "permission_name" => "admin",
            "permission_nice_name" => htmlspecialchars(lang("admin_title"), ENT_QUOTES)
        );

        return $permissions;
    }

    /**
     * @return array
     */
    function get_permission_names (){
	    $permissions = $this->get_permissions();
	    $permission_names = array();
	    foreach ($permissions as $permission){
	        $permission_names[] = $permission["permission_name"];
        }
	    return $permission_names;
    }


	/**
     * Permissions:
     * admin                        Ultimate permission for everything
     * edit_folders                 Create, delete, edit folders
     * edit_tables                  Create, delete, edit tables [their properties]
     * <table_name>_table_view      View the content of a specific table
     * <table_mame>_table_edit      Add, delete, edit the content of a table
     */
}
