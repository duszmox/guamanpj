<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 21:15
 * @property Database_model Database_model
 */

class Database extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("Database_model");
	}

	function index()
	{
		require_rank(Ranks::$ADMIN);

		$this->load->view("templates/header");
		$this->load->view("templates/menu");
		$table_array = ($this->Database_model->get_tables());
		$folder_array = ($this->Database_model->get_folders());
		$this->load->view("database/table_view", array("table_array" => $table_array, "folder_array" => $folder_array));

		$this->load->view("templates/footer");
	}

    function create(){
	    require_rank(Ranks::$ADMIN);

        $this->load->view("templates/header");
        $this->load->view("templates/menu");
        $folder_array = ($this->Database_model->get_folders());
        $this->load->view("database/create_folder_view", array("folder_array" => $folder_array));
        $this->load->view("database/create_table_view");
        $this->load->view("templates/footer");
    }

	function get_table($table_name, $order_by = "id", $order = "ASC")
	{
		require_rank(Ranks::$ADMIN);

		$rows = $this->Database_model->get_table("*", $table_name, $order_by, $order);
		$output = array();
		$cols = $this->Database_model->get_columns_by_table($table_name);
		$header_row = array();
		foreach ($cols as $key => $col){
			$header_row[$col] = $col;
		}

		$output[]= $header_row;
		foreach ($rows as $key => $row) {
			$output[] = $row;
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($output));
	}

	function get_column_names($table_name)
	{
		require_rank(Ranks::$ADMIN);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($this->Database_model->get_columns_by_table($table_name)));
	}
    function insert_row($table_name){
        require_rank(Ranks::$ADMIN);
        $data = array();
        $this->db->insert($table_name, $data);
        redirect("database");
    }
	function update_field(){
		require_rank(Ranks::$ADMIN);
		$table_name = $this->input->post("table_name");
		$column = $this->input->post("column");
		$id = $this->input->post("id");
		$value = $this->input->post("value");
		print_r($table_name . "; " . $column . "; " . $id . "; " . $value);

		try{
			$this->Database_model->update_field($table_name, $column, $id, $value);
		}
		catch (Exception $exception){
			switch ($exception->getMessage()){
				case "invalid_input":
					die("invalid_input");
					break;
			}
		}
	}
}
