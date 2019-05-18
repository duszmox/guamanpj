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


    public function index()
    {
        require_status(Statuses::$LOGGED_IN);

        $this->load->view("templates/header", array("title" => lang("statistics_title")));
        $this->load->view("templates/menu");

        $this->load->view("statistics/statistics_list_view");

        $this->load->view("templates/footer");

    }

    public function get_statistics_list()
    {
        require_status(Statuses::$LOGGED_IN);

        $statistics = $this->Statistics_model->get_statistics();

        // Check permissions:
        $result_array = array();
        foreach ($statistics as $key => $row) {
            if (has_permission($row['id'] . "_stat_view")) {
                try {
                    $row["type_name"] = $this->Statistics_model->get_nice_type_name($row["statistics_type"]);
                } catch (Exception $e) {
                }
                $result_array[] = $row;
            }
        }

        if (sizeof($result_array) == 0) {
            json_error(lang("statistics_no_permission"));
        }

        json_output($result_array);

    }

    public function view($id = NULL)
    {
        require_status(Statuses::$LOGGED_IN);

        if ($id == NULL || !Validator::is_numeric($id)) js_alert(lang("invalid_id_message"), base_url("statistics/"));
        if (!has_permission($id . "_stat_view")) js_alert(lang("not_having_permission_message"), base_url("statistics/"));

        try {
            $result_array = $this->Statistics_model->get_statistics_by_id($id);
        } catch (Exception $e) {
            if ($e->getMessage() == "statistics_not_found") js_alert(lang("statistics_not_found_message"), base_url("statistics/"));
        }


        $this->load->view("templates/header", array("title" => lang("statistics_title")));
        $this->load->view("templates/menu");

        $this->load->view("statistics/view_statistics", array("statistics" => $result_array));

        $this->load->view("templates/footer");
    }

    public function add()
    {
        require_status(Statuses::$LOGGED_IN);
        require_permission("admin");

        if ($this->input->post("submit") == null) {
            $this->load->view("templates/header", array("title" => lang("statistics_title")));
            $this->load->view("templates/menu");

            $this->load->view("statistics/add_statistics");

            $this->load->view("templates/footer");
        } else {
            // Check input fields
            $requiered_fields = array("statistics_name", "statistics_type", "selected_columns", "source_table", "order_by", "order", "statistics_config");
            foreach ($requiered_fields as $field) {
                if ($field == null) {
                    js_alert("A " . $field . " megadása kötelező.", "back");
                }
            }

            $statistics_name = $this->input->post("statistics_name");
            $statistics_type = $this->input->post("statistics_type");
            $source_table = $this->input->post("source_table");
            $selected_columns = $this->input->post("selected_columns");
            $order = $this->input->post("order");
            $order_by = $this->input->post("order_by");
            $statistics_config = $this->input->post("statistics_config");


            try {
                $this->Statistics_model->add_statistics($statistics_name, $statistics_type, $source_table, $selected_columns, $order, $order_by, $statistics_config);
            } catch (Exception $e) {
                js_alert("Unexpected error: \\n" . $e->getMessage(), base_url("statistics/"));
            }
            // Success
            js_alert(lang('succesful_add_statistics'), base_url("statistics/"));

        }


    }

    public function remove($id)
    {
        require_permission("edit_stats");
        $this->Statistics_model->remove($id);
    }

    public function get_source_table($stat_id = null)
    {
        $this->load->model("Database_model");

        if ($stat_id == null || !Validator::is_numeric($stat_id)) json_error("Invalid source table name!"); // TODO LANG
        require_permission($stat_id . "_stat_view", "json");

        try {
            $statistics = $this->Statistics_model->get_statistics_by_id($stat_id);
        } catch (Exception $e) {
            json_error($e->getMessage());
        }


        $cols = explode(",", $statistics["selected_columns"]);

        $table = $this->Database_model->get_table($cols, $this->Database_model->get_table_name_by_id($statistics["source_table"]), "id", "ASC");


        $columns = array();

        foreach ($cols as $col) {
            $col = trim($col);
            if($col === "") continue;
            try {
                $columns[$col] = $this->Database_model->get_column(trim($statistics["source_table"]), $col);
            } catch (Exception $e) {
                json_error($e->getMessage());
            }
        }

        $result = array("columns" => $columns, "table" => $table);
        json_output($result);
    }
}