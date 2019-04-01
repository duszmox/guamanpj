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
		$this->load->helper("permission_helper");
		$query = $this->db->get(self::$TABLE_NAME);
		$array = $query->result_array();
		$result_array = array();


		foreach ($array as $table) {
			if (has_permission($table["table_name"] . "_table_view")) {
				$result_array[] = $table;
			}
		}
		return $result_array;
	}

	/**
	 * @return array
	 */
	public function get_folders()
	{
		$query = $this->db->get(self::$FOLDER_TABLE_NAME);
		$array = $query->result_array();

		$result_array = array();


		$tables = $this->get_table_names();

		foreach ($array as $key1 => $folder) {
			foreach ($tables as $key2 => $table) {
				if (has_permission($table . "_table_view") && $this->is_parent_folder($folder["id"], $table)) {
					$result_array[] = $folder;
					break;
				}
			}

		}
		return $result_array;
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

	public function get_nice_column_names_by_table($table_name)
	{
		$columns = $this->get_columns_by_table($table_name);
		$nice_column_names = array();
		foreach ($columns as $key => $column_name) {
			$nice_column_names[] = $this->get_nice_column_name($this->get_table_id($table_name), $column_name);
		}
		return $nice_column_names;
	}

	public function get_table_id($table_name)
	{
		$this->db->select("id");
		$query = $this->db->get_where(self::$TABLE_NAME, array("table_name" => $table_name), 1);
		$arr = $query->result_array();
		return $arr[0]["id"];
	}

	public function update_field($table_name, $column, $id, $value)
	{
		if (!Validator::is_alphanumeric($table_name)) {
			throw new Exception("invalid_input table_name");
		}
		if (!Validator::is_alphanumeric_or_percentage($column)) {
			throw new Exception("invalid_input column");
		}
		if (!Validator::is_numeric($id)) {
			throw new Exception("invalid_input id");
		}

		$this->db->update($table_name, array($column => $value), array("id" => $id));
	}

	public function create_folder($name, $parent_folder)
	{
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


	public function insert($table_name, $data)
	{
	    if(!in_array($table_name, $this->get_table_names())) throw new Exception("Invalid table name");
		$this->db->insert($table_name, $data);
	}

	public function is_parent_folder($folder, $table)
	{
		$folders = $this->get_child_folder_ids($folder);
		$folders[] = $folder;

		foreach ($folders as $folder) {
			$this->db->select("id");
			$query = $this->db->get_where(self::$TABLE_NAME, array("parent_folder" => $folder, "table_name" => $table));
			if ($query->num_rows() >= 1) {
				return TRUE;
			}
		}
		return FALSE;

	}

	public function get_child_folder_ids($folder)
	{
		$this->db->select("id");

		$query = $this->db->get_where(self::$FOLDER_TABLE_NAME,

			array("parent_folder" => $folder)


		);


		$child_folders = $query->result_array();

		$result_array = array();
		foreach ($child_folders as $key => $child_folder) {
			$result_array[] = $child_folder["id"];
			$temp = $this->get_child_folder_ids($child_folder["id"]);
			foreach ($temp as $key => $item) {
				$result_array[] = $item;
			}
		}
		return $result_array;
	}

    public function move($from_table, $to_table, $from_id)
    {
        $query = $this->db->get_where($from_table, array("id" => $from_id));
        if ($db = $query->num_rows() != 1) throw new Exception("id_not_found_exception");


        // TODO check if the 2 tables are compatible (check column names) throw new Exception("not_compatible_tables_exception") [Andrisnak/Amrusnak] tömbösszehasonlítás algoritmus;

        // TODO insert data -> delete row, if the insertion was successful [Andrinak / Ambrusnak]
    }


}
