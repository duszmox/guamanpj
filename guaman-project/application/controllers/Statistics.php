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


        if (!sizeof($result_array)) js_alert(lang("statistics_no_permission"), base_url('database/'));

        $this->load->view("templates/header", array("title" => lang("statistics_title")));
        $this->load->view("templates/menu");

        $this->load->view("statistics/statistics_list_view", array("data" => $result_array));

        $this->load->view("templates/footer");

    }


    public function view($id = NULL)
    {
        require_status(Statuses::$LOGGED_IN);

        if (!Validator::is_numeric($id) OR $id == NULL) js_alert(lang("invalid_id_message"), base_url("statistics/"));
        if (!has_permission($id . "_stat_view")) js_alert(lang("not_having_permission_message"), base_url("statistics/"));

        try {
            $result_array = array();
            $result_array = $this->Statistics_model->get_statistics_by_id($id);
        } catch (Exception $e) {
            if ($e->getMessage() == "statistics_not_found") js_alert(lang("statistics_not_found_message"), base_url("statistics/"));
        }


        $this->load->view("templates/header", array("title" => lang("statistics_title")));
        $this->load->view("templates/menu");

        $this->load->view("statistics/view_statistics", array("data" => $result_array));

        $this->load->view("templates/footer");
    }

    public function add()
    {
        require_status(Statuses::$LOGGED_IN);
        require_permission("admin");
        if (NULL !== $this->input->post("statistics_name") && (NULL !== $this->input->post("statistics_type"))) {
            if (NULL !== $this->input->post("selected_columns") && NULL !== $this->input->post("source_table")) {
                if (NULL !== $this->input->post("order_by") && NULL !== $this->input->post("order")) {
                    if (NULL !== $this->input->post("statistics_config")) {


                        $statistics_name = $this->input->post("statistics_name");
                        $statistics_type = $this->input->post("statistics_type");
                        $source_table = $this->input->post("source_table");
                        $selected_columns = $this->input->post("selected_columns");
                        $order = $this->input->post("order");
                        $order_by = $this->input->post("order_by");
                        $statistics_config = $this->input->post("statistics_config");

                        try {
                            $result_bool = false;
                            $result_bool = $this->Statistics_model->add_statistics($statistics_name, $statistics_type, $source_table, $selected_columns, $order, $order_by, $statistics_config);
                        } catch (Exception $e) {
                            if ($e->getMessage() == "wrong_statistics_type") js_alert(lang("statistics_type_not_found"), base_url("statistics/"));
                            if ($e->getMessage() == "wrong_source_table") js_alert(lang("statistics_source_table_missing"), base_url("statistics/"));
                            if ($e->getMessage() == "wrong_selected_columns") js_alert(lang("statistics_select_columns_missing"), base_url("statistics/"));
                            if ($e->getMessage() == "wrong_order") js_alert(lang("statistics_order_missing"), base_url("statistics/"));
                            if ($e->getMessage() == "wrong_order_by") js_alert(lang("statistics_order_by_missing"), base_url("statistics/"));
                        }
                        if($result_bool)js_alert(lang('succesful_add_statistics'), base_url("statistics/"));
                    }
                }
            }
        } else {
            $this->load->view("templates/header", array("title" => lang("statistics_title")));
            $this->load->view("templates/menu");

            $this->load->view("statistics/add_statistics");

            $this->load->view("templates/footer");

        }
    }


    // TODO Statisctics module


}


