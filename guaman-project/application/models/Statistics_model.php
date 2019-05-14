<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 4/24/2019
 * Time: 9:51 PM
 * @property Database_model Database_model
 */

class Statistics_model extends CI_Model
{

    public static $TABLE_NAME = "statistics";
    public static $TYPES_TABLE_NAME = "statistics_types";

    public function __construct()
    {
        parent::__construct();
        self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;
        self::$TYPES_TABLE_NAME = $this->config->item("table_prefix") . self::$TYPES_TABLE_NAME;
    }

    public function get_statistics()
    {
        $this->db->select("id");
        $this->db->select("statistics_name");

        return $this->db->get(self::$TABLE_NAME)->result_array();
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function get_statistics_by_id($id)
    {
        $result = $this->db->get_where(self::$TABLE_NAME, array("id" => $id), 1)->result_array();


        if (!sizeof($result)) {
            throw new Exception("statistics_not_found");
        }
        else {
            return $result[0];
        }

    }

    /**
     * @param $statistics_name
     * @param $statistics_type
     * @param $source_table
     * @param $selected_columns
     * @param $order
     * @param $order_by
     * @param $statistics_config
     * @throws Exception
     */
    public function add_statistics($statistics_name, $statistics_type, $source_table, $selected_columns, $order, $order_by, $statistics_config){

        $query_statistics_type = $this->db->get(self::$TYPES_TABLE_NAME)->result_array();

        /*if(!in_array($statistics_type, $query_statistics_type)){
            throw new Exception("wrong_statistics_type");
        }*/

        $this->load->model("Database_model");

        $query_source_table = $this->Database_model->get_tables();

        $query_source_table_id = array();
        foreach($query_source_table as $key => $value){

            $query_source_table_id[] = $value['id'];
        }
        if(!in_array($source_table, $query_source_table_id)){
            throw new Exception("wrong_source_table");
        }
        $query_table_columns = $this->Database_model->get_columns_by_table($this->Database_model->get_table_name_by_id($source_table));

        $selected_columns_array = explode(",", $selected_columns);
        foreach($selected_columns_array as $key => $value){
            if(!in_array($value, $query_table_columns)){
                throw new Exception("wrong_selected_columns");
            }
        }
        if($order != "ASC" && $order != "DESC"){
            throw new Exception("wrong_order");
        }
        if(!in_array($order_by, $query_table_columns)){
            throw new Exception("wrong_order_by");
        }



        $this->db->insert(self::$TABLE_NAME, array("statistics_name" => $statistics_name, "statistics_type" => $statistics_type, "source_table" => $source_table, "selected_columns" => $selected_columns,
            "order" => $order, "order_by" => $order_by, "statistics_config" => $statistics_config));
        return true;

    }


}