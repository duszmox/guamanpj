<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 21:16
 * @property Account_model Account_model
 */

class Database_model extends CI_Model
{

    public static $TABLE_NAME = "tables";
    public static $FOLDER_TABLE_NAME = "folders";
    public static $TABLE_LOG = "login_log";
    public static $COLUMNS_TABLE_NAME = "table_columns";

    public function __construct()
    {
        parent::__construct();

        self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;
        self::$FOLDER_TABLE_NAME = $this->config->item("table_prefix") . self::$FOLDER_TABLE_NAME;
        self::$COLUMNS_TABLE_NAME = $this->config->item("table_prefix") . self::$COLUMNS_TABLE_NAME;
        self::$TABLE_LOG = $this->config->item("table_prefix") . self::$TABLE_LOG;
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

    private function apply_filters($filters)
    {
        foreach ($filters as $filter) {
            switch ($filter["type"]) {
                case "checkbox":
                    if (!$filter["checkedOptions"] == 0) {
                        $this->db->where_in($filter["column"], $filter["checkedOptions"]);
                    }

                    break;
            }
        }
        /*if ($filters != null && is_array($filters)) {
            foreach ($filters as $filter) {
                if (!isset($filter["column_name"])) continue;
                if (!isset($filter["relation"])) continue;
                if (!isset($filter["value"])) continue;


                if (!in_array($filter["column_name"], $table_columns)) continue;
                if (!in_array($filter["relation"], array("=", ">", "<", "<=", ">=", "LIKE"))) continue;
                if (trim($filter["value"]) == "") continue;

                switch ($filter["relation"]) {
                    case "=":
                        $this->db->where($filter["column_name"], $filter["value"]);
                        break;
                    case ">":
                        $this->db->where($filter["column_name"] . ">", $filter["value"]);
                        break;
                    case "<":
                        $this->db->where($filter["column_name"] . "<", $filter["value"]);
                        break;
                    case "<=":
                        $this->db->where($filter["column_name"] . "<=", $filter["value"]);
                        break;
                    case ">=":
                        $this->db->where($filter["column_name"] . ">=", $filter["value"]);
                        break;
                    case "LIKE":
                        $this->db->like($filter["column_name"], $filter["value"]);
                        break;

                }
            }

        }*/
    }

    public function get_table($columns, $table, $order_by, $order, $filters = null)
    {

        $table_columns = $this->get_columns_by_table($table);
        if (!in_array($table, $this->get_table_names())) die("Not valid table name");
        if (!in_array($order_by, $table_columns)) $order_by = "id";
        if (!in_array(strtoupper($order), array("ASC", "DESC"))) $order = "ASC";

        $this->db->select($columns);

        if ($filters !== null) {
            $this->apply_filters($filters);
        }

        $this->db->order_by($order_by, $order);

        $resultArray = $this->db->get($table)->result_array();

        $this->load->helper("custom_db_helper");
        return custom_db_actions($table, $resultArray, $this->get_columns_by_table($table), $columns);

    }

    public function isEditableTable($table_name)
    {
        return $this->db->get_where(self::$TABLE_NAME, array("table_name" => $table_name, "editable" => 1))->num_rows() >= 1;
    }

    public function getNonEditableTables()
    {
        $result_array = $this->db->get_where(self::$TABLE_NAME, array("editable" => 0))->result_array();
        $nonEditableTables = array();
        foreach ($result_array as $row) {
            $nonEditableTables[] = $row["table_name"];
        }
        return $nonEditableTables;
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

    /**
     * @param $table_id
     * @param $column_name
     * @throws Exception
     */
    public function get_column($table_id, $column_name)
    {
        $result = $this->db->get_where(self::$COLUMNS_TABLE_NAME, array("table_id" => $table_id, "column_name" => $column_name), 1)->first_row();
        if ($result == null) {
            throw new Exception("Column not found: " . $column_name);
        }
        return $result;
    }

    public function get_col_types($table_id, $column_names)
    {
        $types = array();

        foreach ($column_names as $column_name) {
            $result_array = $this->db->get_where(self::$COLUMNS_TABLE_NAME, array("table_id" => $table_id, "column_name" => $column_name), 1)->result_array();
            //


            if (!isset($result_array[0]["type"])) {
                echo "Nincsen neve : " . $column_name . ". \n";
            } else {
                $types[] = $result_array[0]["type"];
            }
        }
        return $types;
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

    public function has_column_in_table($column, $table)
    {
        $columns_of_table = self::get_columns_by_table($table);
        if (in_array($column, $columns_of_table)) {
            return true;
        } else {
            return false;
        }

    }

    public function get_type_of_column($col)
    {

        $this->db->select('type');
        $query = $this->db->get_where(self::$COLUMNS_TABLE_NAME, array("column_name" => $col), 1);
        $arr = $query->result_array();
        return $arr[0]["type"];
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
        if (!in_array($table_name, $this->get_table_names())) throw new Exception("Invalid table name");
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

    /**
     * @param $from_table
     * @param $to_table
     * @param $from_id
     * @throws Exception table_not_found_exception, id_not_found_exception, incompatible_tables_exception
     */
    public function move($from_table, $to_table, $from_id)
    {
        $table_names = $this->get_table_names();
        if (!in_array($from_table, $table_names)) throw new Exception("table_not_found_exception");
        if (!in_array($to_table, $table_names)) throw new Exception("table_not_found_exception");

        $query = $this->db->get_where($from_table, array("id" => $from_id));
        if ($db = $query->num_rows() != 1) throw new Exception("id_not_found_exception");

        if (!$this->compatible_tables($from_table, $to_table)) throw new Exception("incompatible_tables_exception");

        $data_array = $query->result_array();
        $data_array = $data_array[0];

        $data_array["id"] = "";

        $this->db->insert($to_table, $data_array);
        if ($this->db->affected_rows() == 1) {
            $this->db->delete($from_table, array("id" => $from_id), 1);
            return;
        }
        throw new Exception("db_error");
    }

    /**
     * Returns true if the 2 tables are compatible (all columns in from_table are also in to_table)
     * @param $from_table
     * @param $to_table
     * @return bool
     */
    public function compatible_tables($from_table, $to_table)
    {
        $from_table_cols = $this->get_columns_by_table($from_table);
        $to_table_cols = $this->get_columns_by_table($to_table);


        foreach ($from_table_cols as $from_table_col) {
            if (!in_array($from_table_col, $to_table_cols)) {
                return false;
            }
        }
        return true;
    }


    public function get_table_objects()
    {
        return $this->db->get(self::$TABLE_NAME)->result_array();
    }

    /**
     * Gets the available compatible tables for the current user
     * @param $from_table
     * @return array
     * @throws Exception table_not_found_exception
     */
    public function get_compatible_tables($from_table)
    {

        $is_in_table = false;
        $tables = $this->get_table_objects();
        foreach ($tables as $table) {
            if ($table["table_name"] == $from_table) {
                $is_in_table = true;
                break;
            }
        }
        if (!$is_in_table) throw new Exception("table_not_found_exception");

        $compatible_tables = array();
        foreach ($tables as $table) {
            if (has_permission($table["table_name"] . "_table_edit") && $table["editable"] == 1 && $this->compatible_tables($from_table, $table["table_name"])) {
                $compatible_tables[] = $table;
            }
        }
        return $compatible_tables;

    }

    public function get_id_by_table_name($table_name)
    {
        $this->db->select("id");
        $result = $this->db->get_where(self::$TABLE_NAME, array("table_name" => $table_name))->result_array();
        if (sizeof($result) > 0) {
            return $result[0]['id'];
        };
        return "false";

    }

    public function update_field_log($table_name, $column, $id, $value)
    {
        $this->load->model("Account_model");
        return $this->db->insert(self::$TABLE_LOG, array("username" => Account_model::$username, "date" => date('m/d/Y h:i:s a', time()), "type" => "update_field", "info" => "tabel_name : " . $table_name . ", column : " . $column . " , id : " . $id . " , value : " . $value));
    }

    public function get_table_name_by_id($id)
    {
        $this->db->select("table_name");
        $result = $this->db->get_where(self::$TABLE_NAME, array("id" => $id))->result_array();
        if (sizeof($result) > 0) {
            return $result[0]['table_name'];
        };
        return "false";

    }

    public function get_table_title($table_name)
    {
        if (!in_array($table_name, $this->get_table_names())) throw new Exception("table_not_found_exception");

        $this->db->select("table_title");
        $query = $this->db->get_where(self::$TABLE_NAME, array("table_name" => $table_name), 1);
        return $query->first_row()->table_title;
    }


    public function change()
    {
        $this->db->select("*");
        $query = $this->db->get("guaman_table_columns")->result_array();
        foreach ($query as $key => $value) {
            if (strpos($value['column_name'], 'datum') || $value['column_name'] == "datum") {
                $this->db->update("guaman_table_columns", array("type" => "date"), array("column_name" => $value['column_name']));
                true;
            }
            if ((strpos($value['nice_column_name'], 'ár')) || (strpos($value['nice_column_name'], 'Ár')) || ((strpos($value['nice_column_name'], 'Nettó')) || (strpos($value['nice_column_name'], 'Bruttó')))) {
                if (!strpos($value['nice_column_name'], 'Város')) {
                    if (!strpos($value['column_name'], 'nap')) {
                        if (!strpos($value['column_name'], 'ros')) {
                            if (!strpos($value['column_name'], 'tar')) {
                                if ($value['column_name'] == "futar") continue;
                                if ($value['column_name'] == "tarolas_helyszine") continue;
                                if ($value['column_name'] == "tarolasi_helyszine") continue;
                                if ($value['column_name'] == "tarhely") continue;
                                echo $value['nice_column_name'] . " : " . $value['column_name'] . " -> " . $value['type'];
                                $this->db->update("guaman_table_columns", array("type" => "money"), array("column_name" => $value['column_name']));
                                echo "<br>";
                            }
                        }
                    }
                }
            }

        }

    }

    public function addRowsToDatabaseManual()
    {
        //termék id
        $char_termekid = strtoupper(substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 1));
        $number_termekid = rand(10, 99);
        echo "Termék ID : " . $char_termekid . $number_termekid . "<br>";
        echo "<hr>";

        //bekerülési dátum
        $timestamp = mt_rand(1, time());
        $randomDate = date("d M Y", $timestamp);
        echo "Bekerülési Dátum : " . $randomDate . " \n<br>";
        echo "<hr>";

        //platform
        $array_pf_platform = array("fa","ha","partner");
        $platform = array_rand($array_pf_platform);
        echo "Platform :".$array_pf_platform[$platform] . "\n <br><hr>";

        $array_of_termek = array("iPhone 6S","iPhone 7S", "iPhone 8", "Rolex", "iPad Pro", "Krypto hangszóró", "Apple füllhallgató");
        $array_of_type = array("Telefon","Telefon","Telefon","Órák, kiegészítők","Tablet","Gadget","Gadget");
        $termek_and_type = array_rand($array_of_termek);
        echo "Termék :".$array_of_termek[$termek_and_type]."\n<br><hr>";
        echo "Type :".$array_of_type[$termek_and_type]."\n<br><hr>";



    }
}
