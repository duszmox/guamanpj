<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 4/24/2019
 * Time: 9:51 PM
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


}