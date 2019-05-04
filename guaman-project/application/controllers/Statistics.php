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
        require_status(Statuses::$LOGGED_IN);

        $result_array = array();
        $statistics = $this->Statistics_model->get_statistics();
        foreach ($statistics as $key => $row) {
            $id = $row['id'];
            if (has_permission($id . "_stat_view")) {
                $result_array[] = $row;
            }
        }


        if (!sizeof($result_array)) js_alert("Nincsen joga egyetlen statisztikához sem.", base_url('database/'));//todo lang

        $this->load->view("templates/header", array("title" => "Statistics")); // todo lang
        $this->load->view("templates/menu");

        $this->load->view("statistics/statistics_list_view", array("data" => $result_array));

        $this->load->view("templates/footer");

    }


    public function view($id = NULL)
    {
        require_status(Statuses::$LOGGED_IN);

        if (!Validator::is_numeric($id) OR $id == NULL) js_alert("Invalid id", base_url("statistics/")); //todo lang
        if (!has_permission($id . "_stat_view")) js_alert("Dont have permission", base_url("statistics/")); //todo lang

        try {
            $result_array = array();
            $result_array = $this->Statistics_model->get_statistics_by_id($id);
        } catch (Exception $e) {
            if ($e->getMessage() == "statistics_not_found") js_alert("Statistics not found", base_url("statistics/")); //todo lang
        }


        $this->load->view("templates/header", array("title" => "Statistics")); // todo lang
        $this->load->view("templates/menu");

        $this->load->view("statistics/view_statistics", array("data" => $result_array));

        $this->load->view("templates/footer");
    }

    public function add()
    {
        //todo get post datas from form
        require_permission("admin");
        if (((NULL !== $this->input->post("statistics_name") && NULL !== $this->input->post("statistics_type") &&
                (NULL !== $this->input->post("selected_columns") && NULL !== $this->input->post("source_table"))) &&
            (NULL !== $this->input->post("order_by") && NULL !== $this->input->post("order")) &&
            NULL !== $this->input->post("statistics_config")
        )) {
            $statistics_name = "";
            $statistics_type = "";
            $source_table = "";
            $selected_columns = "";
            $order = "";
            $order_by = "";
            $statistics_config = "";

            try {
                $result_array = array();
                $result_array = $this->Statistics_model->add_statistics($statistics_name, $statistics_type, $source_table, $selected_columns, $order, $order_by, $statistics_config);
            } catch (Exception $e) {
                if ($e->getMessage() == "wrong_statistics_type") js_alert("Statistics type not found", base_url("statistics/")); //todo lang
                if ($e->getMessage() == "wrong_source_table") js_alert("Statistics Source table not found", base_url("statistics/")); //todo lang
                if ($e->getMessage() == "wrong_selected_columns") js_alert("Statistics Selected Columns not found", base_url("statistics/")); //todo lang
                if ($e->getMessage() == "wrong_order") js_alert("Statistics Order not found", base_url("statistics/")); //todo lang
                if ($e->getMessage() == "wrong_order_by") js_alert("Statistics Order By not found", base_url("statistics/")); //todo lang
            }
        } else {
            $this->load->view("templates/header", array("title" => "Statistics")); // todo lang
            $this->load->view("templates/menu");

            $this->load->view("statistics/add_statistics");

            $this->load->view("templates/footer");

        }
    }


    // TODO Statisctics module


}

