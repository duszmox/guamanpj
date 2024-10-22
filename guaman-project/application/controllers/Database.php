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

        $nonEditableTables = $this->Database_model->getNonEditableTables();

        $this->load->view("database/table_view", array("table_array" => $table_array, "folder_array" => $folder_array, "nonEditableTables" => $nonEditableTables));

        $this->load->view("templates/footer");
    }


    function create_folder()
    {
        require_status(Statuses::$LOGGED_IN);
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
        require_status(Statuses::$LOGGED_IN);
        require_permission("edit_tables");

        if ($this->input->post("submit") /* + ... */) {
            js_alert("Working on it...", base_url());

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
        require_status(Statuses::$LOGGED_IN);

        if ($this->input->post("filters")) {
            $filters = $this->input->post("filters");

            if (!is_array($filters)) {
                $filters = null;
            }
        } else {
            $filters = null;
        }

        $rows = $this->Database_model->get_table("*", $table_name, $order_by, $order, $filters);
        $output = array();


        $column_objects = $this->Database_model->get_column_objects($table_name);

        $header_row = array();
        foreach ($column_objects as $key => $column_object) {
            $header_row[$column_object["column_name"]] = array(
                "nice_name" => $column_object["nice_column_name"],
                "type" => $column_object["type"],
                "name" => $column_object["column_name"],
                "custom_data" => $column_object["custom_data"]
            );

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
        require_status(Statuses::$LOGGED_IN);
        require_permission($table_name . "_table_view");

        $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($this->Database_model->get_columns_by_table($table_name)));
    }

    function insert_new_row($table_name)
    {
        require_status(Statuses::$LOGGED_IN);
        require_permission($table_name . "_table_edit");
        try {
            $this->Database_model->insert($table_name, array("id" => ""));
            echo "success";
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    function get_filters($table_name)
    {
        require_status(Statuses::$LOGGED_IN);
        $result = array();
        switch ($table_name) {
            case "guaman_sales":
                $result = array(
                    array(
                        "name" => "beszerzes_forrasa",
                        "niceName" => "Beszerzés forrása",
                        "type" => "checkbox",
                        "column" => "type",
                        "customData" => array(
                            "optionSource" => "enum",
                            "sourceEnum" => "beszerzes_forrasa"
                        )
                    )
                );
                break;

            case "guaman_disztribucio":
                $result = array(

                    array(
                        "name" => "type",
                        "niceName" => "Típus",
                        "type" => "checkbox",
                        "column" => "type",
                        "customData" => array(
                            "options" => array(
                                array(
                                    "name" => "partner",
                                    "niceName" => "Partner"
                                ),
                                array(
                                    "name" => "hasznalt",
                                    "niceName" => "Használt"
                                ),
                                array(
                                    "name" => "kiegeszito",
                                    "niceName" => "Kiegészítő"
                                ),
                                array(
                                    "name" => "",
                                    "niceName" => "Nincs megadva" // TODO lang
                                )

                            )
                        )
                    )
                );
                break;
            case "guaman_login_log":
                $result = array(

                    array(
                        "name" => "type",
                        "niceName" => "Típus",
                        "type" => "checkbox",
                        "column" => "type",
                        "customData" => array(
                            "options" => array(
                                array(
                                    "name" => "login",
                                    "niceName" => "Login"
                                ),
                                array(
                                    "name" => "update_field",
                                    "niceName" => "Update Field"
                                ),
                            )
                        )
                    )
                );
                break;

        }
        json_output($this->Database_model->get_filters($table_name));
    }

    function update_field()
    {
        require_status(Statuses::$LOGGED_IN);
        $table_name = $this->input->post("table_name");

        require_permission($table_name . "_table_edit");
        if (!$this->Database_model->isEditableTable($table_name)) {
            json_error(lang('cant-change-field'));
        }
        $column = $this->input->post("column");
        $id = $this->input->post("id");
        $value = $this->input->post("value");

        try {
            $this->Database_model->update_field($table_name, $column, $id, $value);
            $this->Database_model->update_field_log($table_name, $column, $id, $value);
        } catch (Exception $exception) {
            json_error($exception->getMessage());
        }
        json_output("success");
    }

    public function backup()
    {
        require_status(Statuses::$LOGGED_IN);
        require_permission("download_backup");

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
     * @param $from_id
     */
    public function move_row()
    {
        require_status(Statuses::$LOGGED_IN);

        $from_table = $this->input->post("fromTable");
        $to_table = $this->input->post("toTable");
        $rowId = $this->input->post("rowId");

        require_permission($from_table . "_table_edit", "json");
        require_permission($to_table . "_table_edit", "json");

        if (!Validator::is_numeric($rowId)) json_error(lang('invalid_id_message'));

        try {
            $this->Database_model->move($from_table, $to_table, $rowId);
        } catch (Exception $exception) {
            switch ($exception->getMessage()) {
                case "incompatible_tables_exception":
                    json_error("Inkompatibilis táblák"); // TODO kicserélni langra
                    break;
                case "id_not_found_exception":
                    json_error("Nincs ilyen azonosítójú sor"); // TODO kicserélni langra
                    break;
                case "table_not_found_exception":
                    json_error("A tábla nem található."); // TODO kicserélni langra
                    break;
                case "db_error":
                    json_error("Adatbázis hiba."); // TODO lang
                    break;
                default:
                    json_error($exception->getMessage());
            }
        }
        json_output("success");
    }





    // Most nem ezt használjuk, hanem lekérjük szépen php-val

    /**
     * gets compatible nice names (API)
     * @param $from_table
     * @throws Exception
     */
    public function get_compatible_tables($from_table)
    {
        require_status(Statuses::$LOGGED_IN);
        require_permission($from_table . "_table_view");
        json_output($this->Database_model->get_compatible_tables($from_table));
    }

    public function change()
    {
        require_permission("admin");
        $this->Database_model->addRowsToDatabaseManual();
    }

    public function get_enum($enum_name)
    {
        // TODO permissions
        require_status(Statuses::$LOGGED_IN);
        try {
            json_output($this->Database_model->get_enum($enum_name));
        } catch (Exception $e) {
            json_error($e->getMessage());
        }
    }

    public function get_enums()
    {
        // TODO permissions
        require_status(Statuses::$LOGGED_IN);
        try {
            json_output($this->Database_model->get_enums());
        } catch (Exception $e) {
            json_error($e->getMessage());
        }
    }

    public function save_filter($id)
    {
        // TODO require edit filters permissions
        require_status(Statuses::$LOGGED_IN);
        $filter = array(
            "id" => $id,
            "nice_name" => $this->input->post("nice_name"),
            "type" => $this->input->post("type"),
            "column" => $this->input->post("column"),
            "custom_data" => json_encode($this->input->post("custom_data"))
        );
        //print_r($filter);

        try {
            $this->Database_model->update_filter($filter);
        } catch (Exception $e) {
            json_error($e->getMessage());
        }
        json_output("success");
    }

    public function save_new_filter()
    {
        require_status(Statuses::$LOGGED_IN);
        $this->load->helper("string_helper");

        // TODO permission
        $filter = array(
            "nice_name" => $this->input->post("nice_name"),
            "name" => $this->slugit($this->input->post("nice_name") ."-" . random_string('alnum', 5) ),
            "type" => $this->input->post("type"),
            "column" => $this->input->post("column"),
            "custom_data" => json_encode($this->input->post("custom_data")),
            "table_id" => $this->Database_model->get_table_id($this->input->post("table_name"))
        );
        try {
            $this->Database_model->add_filter($filter);
        } catch (Exception $e) {
            json_error($e->getMessage());
        }
        json_output("success");
    }

    private function slugit($str, $replace = array(), $delimiter = '-')
    {
        require_status(Statuses::$LOGGED_IN);
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        return $clean;
    }

}
