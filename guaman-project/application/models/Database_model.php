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
	public static $FOLDER_TABLE_NAME = "folders";
	public static $COLUMNS_TABLE_NAME = "table_columns";

	public function __construct()
	{
		parent::__construct();

		self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;
		self::$FOLDER_TABLE_NAME = $this->config->item("table_prefix") . self::$FOLDER_TABLE_NAME;
		self::$COLUMNS_TABLE_NAME = $this->config->item("table_prefix") . self::$COLUMNS_TABLE_NAME;
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

		$resultArray = $this->db->get($table)->result_array();

		$this->load->helper("custom_db_helper");
		return custom_db_actions($table, $resultArray, $this->get_columns_by_table($table));
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
		if (!Validator::is_alphanumeric($table_name)) {
			throw new Exception("invalid_input table_name");
		}
		if (!Validator::is_alphanumeric($column)) {
			throw new Exception("invalid_input column");
		}
		if (!Validator::is_numeric($id)) {
			throw new Exception("invalid_input id");
		}

		$this->db->update($table_name, array($column => $value), array("id" => $id));
	}

	public function create_folder($name, $parent_folder)
	{
		//todo feltölteni az adatot a permissions táblába is column-ként.
		$this->db->insert(self::$FOLDER_TABLE_NAME, array("id" => "", "folder_name" => $this->get_database_type_name($name), "folder_title" => $name, "parent_folder" => $parent_folder));

	}

	public function create_table()
	{
		//todo permissions táblához is hozzá kell adni, emellett táblaként létre kell hozni, és a tables-be is fel kell tölteni.
	}

	public function get_database_type_name($string)
	{

		$string = strtolower($string);
		$string = str_replace("&nbsp;", "_", $string);
		$string = str_replace("-", "_", $string);
		$string = str_replace("á", "a", $string);
		$string = str_replace("é", "e", $string);
		$string = str_replace("ó", "o", $string);
		$string = str_replace("ő", "o", $string);
		$string = str_replace("ö", "o", $string);
		$string = str_replace("ú", "u", $string);
		$string = str_replace("ű", "u", $string);
		$string = str_replace("ü", "u", $string);
		$string = str_replace("i", "í", $string);

		return $string;

	}

	public function get_nice_column_name($table_id, $column_name)
	{
		$this->db->select("nice_column_name");
		$this->db->where(array('table_id' => $table_id, "column_name" => $column_name));
		$arr = $this->db->get(self::$COLUMNS_TABLE_NAME)->result_array();
		if (sizeof($arr) >= 1) {
			return $arr[0]["nice_column_name"];
		}
		return "";
	}


	public function insert_new_line($table_name){
        $data = array();
        $this->db->insert($table_name, $data);
    }


}
