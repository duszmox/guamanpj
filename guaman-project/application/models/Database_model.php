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

    public function __construct()
    {
        self::$TABLE_NAME = $this->config->item("table_prefix").self::$TABLE_NAME;

    }

    public function get_table_names(){
        $this->db->select("table_name");
        $query = $this->db->get(self::$TABLE_NAME);
        $table_names = array();
        foreach($query->result() as $row){
            $table_names[] = $row->table_name;
        }
        return $table_names;
    }
    public function get_tables(){
        $query = $this->db->get(self::$TABLE_NAME);
        return $query->result_array();
    }
    public function get_table($columns = "*",$table,$by_table,$order){
        $this->db->select($columns);
        $this->db->order_by($by_table,$order);
        return $this->db->get($table);
    }
    public function create_table(){
        
    }
    public function create_folder(){
        //todo folder create
    }
}
