<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 21:16
 */

class Database_model extends CI_Model
{

	public static $TABLE_NAME = "tables";
    public static  $FOLDER_TABLE_NAME = "folders";
	public function __construct()
	{
		self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;
		self::$FOLDER_TABLE_NAME = $this->config->item("table_prefix") . self::$FOLDER_TABLE_NAME;

	}

	public function get_table_names()
	{
		$this->db->select("table_name");
		$query = $this->db->get(self::$TABLE_NAME);
		$table_names = array();
		foreach ($query->result() as $row) {
			$table_names[] = $row->table_name;
		}
		return $table_names;
	}

	public function get_tables()
	{
		$query = $this->db->get(self::$TABLE_NAME);
		return $query->result_array();
	}
    public function get_folders()
    {
        $query = $this->db->get(self::$FOLDER_TABLE_NAME);
        return $query->result_array();
    }

	public function get_table($columns, $table, $order_by, $order)
	{
		if (!in_array($table, $this->get_table_names())) die(":(");
		if (!in_array($order_by, $this->get_columns_by_table($table))) $order_by = "id";
		if (!in_array(strtoupper($order), array("ASC", "DESC"))) $order = "ASC";
		$this->db->select($columns);
		$this->db->order_by($order_by, $order);

		return $this->db->get($table)->result_array();
	}

	public function get_columns_by_table($table_name)
	{
		$fields = $this->db->list_fields($table_name);
		$column_names = array();
		foreach ($fields as $key => $field) {
			$column_names[] = $field;
		}
		return $column_names;
	}

	public function update_field($table_name, $column, $id, $value)
	{
	    if(!Validator::is_alphanumeric($table_name)){
	        throw new Exception("invalid_input");
        }
        if(!Validator::is_alphanumeric($column)){
            throw new Exception("invalid_input");
        }
        if(!Validator::is_numeric($id)) {
            throw new Exception("invalid_input");
        }

        $this->db->update($table_name, array($column=>$value), array("id" => $id));
	}

	public function create_folder($name, $parent_folder){
	    $this->db->insert(self::$FOLDER_TABLE_NAME, array("id" => "", "folder_name" => $this->get_database_type_name($name), "folder_title" => $name, "parent_folder" => $parent_folder));

    }

    public function get_database_type_name($string){

        $string = strtolower($string);
        $string = str_replace(" ", "_", $string);
	    $string = str_replace("-", "_", $string);

	    return $string;

    }

}
