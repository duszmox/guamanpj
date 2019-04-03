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
        require_status(Statuses::$LOGGED_IN);

        $this->load->view("templates/header", array(lang("login_title")));
        $this->load->view("templates/menu");
        $table_array = ($this->Database_model->get_tables());


        $folder_array = ($this->Database_model->get_folders());


        $this->load->view("database/table_view", array("table_array" => $table_array, "folder_array" => $folder_array));

        $this->load->view("templates/footer");
    }

    function create_folder()
    {
        require_permission("edit_folders");

        $this->load->view("templates/header");
        $this->load->view("templates/menu");
        $folder_array = ($this->Database_model->get_folders());
        $this->load->view("database/create_folder_view", array("folder_array" => $folder_array));

        $this->load->view("templates/footer");

        if ($this->input->post("submit") == "OK") {
            echo "<script>alert(\"Doesnt work yet\");</script>";
        }
    }
    function create_table()
    {
        require_permission("edit_tables");

        if ($this->input->post("submit") /* + ... */) {
            js_alert("Working on it...", base_url());
            // TODO Create table
        } else {
            $this->load->view("templates/header");
            $this->load->view("templates/menu");
            $this->load->view("database/create_table_view");

            $this->load->view("templates/footer");
        }


    }

    function get_table($table_name, $order_by = "id", $order = "ASC")
    {
        require_permission($table_name . "_table_view");

        $rows = $this->Database_model->get_table("*", $table_name, $order_by, $order);
        $output = array();

        $cols = $this->Database_model->get_columns_by_table($table_name);
        $col_nice_names = $this->Database_model->get_nice_column_names_by_table($table_name);

        $header_row = array();
        foreach ($cols as $key => $col) {
            $header_row[$col] = $col_nice_names[$key];
        }
        $output[] = $header_row;

        foreach ($rows as $key => $row) {
            $output[] = $row;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    function get_column_names($table_name)
    {
        require_permission($table_name . "_table_view");

        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($this->Database_model->get_columns_by_table($table_name)));
    }

    function insert_new_row($table_name)
    {
        require_permission($table_name . "_table_edit");

        try {
            $this->Database_model->insert($table_name, array("id" => ""));
            echo "success";
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    function update_field()
    {
        $table_name = $this->input->post("table_name");

        require_permission($table_name . "_table_edit");

        $column = $this->input->post("column");
        $id = $this->input->post("id");
        $value = $this->input->post("value");
        print_r($table_name . "; " . $column . "; " . $id . "; " . $value);

        try {
            $this->Database_model->update_field($table_name, $column, $id, $value);
        } catch (Exception $exception) {
            die($exception->getMessage());
        }
    }

    function get_nice_column_name($table_id, $column_name)
    {
        require_permission($this->Database_model->get_table_name($table_id) . "_table_view");
        echo $this->Database_model->get_nice_column_name($table_id, $column_name);
    }



    public function backup()
    {
        require_permission("download_backup");
        // TODO backupot megcsinálni!!! Ez most csak lementi a usernek

        $this->load->dbutil();

        $prefs = array(
            'format' => 'zip',
            'filename' => 'my_db_backup.sql'
        );


        $backup = $this->dbutil->backup($prefs);

        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = '/www/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);

        $this->load->helper('download');
        force_download($db_name, $backup);
    }



    /**
     * Form for move row
     * @param $from_table
     * @param $row
     */
    public function move_row($from_table, $from_id){
        require_permission($from_table . "_table_edit");

        // TODO befejezni form kiíratása, compatible_tables már nice_namemel átadása neki

        if($this->input->post("to_table")){
            require_permission($from_table . "_table_edit");
            require_permission($this->input->post("to_table") . "_table_edit");

            if(!Validator::is_numeric($from_id)) js_alert(lang('invalid_id_message'));


            try {
                if($this->Database_model->move($from_table, $this->input->post("to_table"), $from_id)){
                    js_alert_close_tab(lang('successful_move_row_message'));
                }
                else{
                    js_alert_close_tab(lang('failed_move_row_message'));
                }
            }
            catch (Exception $exception){
                    switch ($exception->getMessage()){
                        case "incompatible_tables_exception":
                            json_error("incompatible_tables_exception");
                            break;
                        case "id_not_found_exception":
                            json_error("id_not_found_exception");
                            break;
                        case "table_not_found_exception":
                            json_error("table_not_found_exception");
                            break;
                    }
                }
        }
        else{
            require_permission($from_table . "_table_edit");

            if(!Validator::is_numeric($from_id)) js_alert(lang('invalid_id_message'));
            try {
                $compatible_tables_ = $this->Database_model->get_compatible_tables($from_table);
                $compatible_tables = array();
                foreach ($compatible_tables_ as $table_name){
                    $compatible_tables[$table_name] = $this->Database_model->get_table_title($table_name);
                }
            } catch (Exception $e) {
                switch ($e->getMessage()){
                    case "table_not_found_exception":
                        js_alert(lang('table_not_found_message'));
                        break;
                }
                die();
            }

            // load views and pass data
            $this->load->view("templates/header");
            $this->load->view("templates/menu");

            try {
                $this->load->view("database/move_row", array("compatible_tables" => $compatible_tables, "id" => $from_id, "from_table_title" => $this->Database_model->get_table_title($from_table)));
            } catch (Exception $e) {
                switch ($e->getMessage()){
                    case "table_not_found_exception":
                        js_alert(lang("table_not_found_message"));
                        break;
                }
                die();
            }

            $this->load->view("templates/footer");


        }
    }


    // Most nem ezt használjuk, hanem lekérjük szépen php-val

    /**
     * gets compatible nice names (API)
     * @param $from_table
     * @throws Exception
     */
    public function get_compatible_tables($from_table){
        require_permission($from_table."_table_view");
        json_output($this->Database_model->get_compatible_tables($from_table, Account_model::$user_id));
    }

}
