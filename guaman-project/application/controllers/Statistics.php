<?php

/**
 * @property Statistics_model Statistics_model
 */
class Statistics extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Statistics_model");
    }


    public function add_statistics()
    {
        //todo view and model
    }

    public function index()
    {

        $result_array = array();
        $statistics = $this->Statistics_model->get_statistics();
        foreach ($statistics as $key => $row) {
            $id = $row['id'];
            if (has_permission($id . "_stat_view")) {
                $result_array[] = $row;
            }
        }

        if(!sizeof($result_array))js_alert("Nincsen joga egyetlen a statisztikához sem.", base_url('database/'));//todo lang

        $this->load->view("templates/header", array("title" => "Statistics")); // todo lang
        $this->load->view("templates/menu");

        $this->load->view("statistics/statistics_list_view", array("data" => $result_array));

        $this->load->view("templates/footer");

    }


    public function view($id = NULL)
    {

        if(!Validator::is_numeric($id) OR $id == NULL)js_alert("Invalid id", base_url("statistics/")); //todo lang
        if(!has_permission($id."_stat_view"))js_alert("Dont have permission", base_url("statistics/")); //todo lang

        try {
            $result_array = array();
            $result_array = $this->Statistics_model->get_statistics_by_id($id);
        } catch (Exception $e) {
            if($e->getMessage() == "statistics_not_found")js_alert("Statistics not found", base_url("statistics/")); //todo lang
        }


        $this->load->view("templates/header", array("title" => "Statistics")); // todo lang
        $this->load->view("templates/menu");

        $this->load->view("statistics/view_statistics", array("data" => $result_array));

        $this->load->view("templates/footer");
    }


    // TODO Statisctics module


}

?>
