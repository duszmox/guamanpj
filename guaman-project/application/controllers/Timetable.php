<?php

/**
 * Created by PhpStorm.
 * User: horva
 * Date: 5/7/2019
 * Time: 10:31 PM
 * @property Timetable_model Timetable_model
 */

class Timetable extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("Timetable_model");

        $this->load->model("Account_model");
        require_status(Statuses::$LOGGED_IN);
    }

    /**
     * @param int $user_id
     */
    public function index($user_id = 0)
    {
        require_status(Statuses::$LOGGED_IN);
        if ($user_id == 0) {
            //todo csak akkor ha van a HR modulból rá engedélye / főnöke

            $user_id = $this->Account_model::$user_id;
        }
        $this->load->view("templates/header", array("page_title" => lang("timetable_label")));
        $this->load->view("templates/menu");
        $events_array = $this->Timetable_model->get_events_by_user($user_id);
        $empty = false;
        if (empty($events_array)) {
            $events_array = array(array());
            $empty = true;
        }
        if (!$empty) {

            foreach ($events_array as $key => $value) {
                $var = $this->Timetable_model->get_event_title_by_id($value['event_id']);

                $events_array[$key]['event_title'] = $var[0]['event_title'];

                continue;
            }
        }
        $this->load->view("timetable/timetable", array("events_array" => $events_array));


        $this->load->view("templates/footer");
    }

    public function manage_event_add()
    {
        require_status(Statuses::$LOGGED_IN);

        $event_types = $this->Timetable_model->get_timetable_event_types();
        $event_places = $this->Timetable_model->get_timetable_event_places();


        $this->load->view("templates/header", array('page_title' => "Manage Event"));
        $this->load->view("templates/menu");

        $this->load->view("timetable/manage_event_add", array("event_types" => $event_types, "event_places" => $event_places));
        $this->load->view("templates/footer");
    }

    /**
     * @param string $event
     */
    public function manage_event_edit($event = "")
    {
        require_status(Statuses::$LOGGED_IN);
        $data = array();
        if ($event == "") {
            js_alert("No event picked", base_url("timetable/"));
        } else {
            $data = $this->Timetable_model->get_event($event);
            if (empty($data)) {
                js_alert("Invalid event id", base_url("timetable/"));
            }
        }
        $event_types = $this->Timetable_model->get_timetable_event_types();
        $event_places = $this->Timetable_model->get_timetable_event_places();
        try {
            $actual_event_type = $this->Timetable_model->get_nice_name_by_id($data[0]['event_type']);
        }catch(Exception $e){
            if ($e->getMessage() == "invalid_id") js_alert(lang('not-found-table-with-id'), base_url("timetable/manage_event_edit"));
        }

        $this->load->view("templates/header", array('page_title' => "Manage Event"));
        $this->load->view("templates/menu");

        $this->load->view("timetable/manage_event_edit", array("data" => $data[0], "event_types" => $event_types, "event_places" => $event_places, "actual_event_type" => $actual_event_type));
        $this->load->view("templates/footer");
    }

    public function manage_event_upload_add()
    {
        require_status(Statuses::$LOGGED_IN);
        $required_inputs = array("event_title", "event_place", "all_day", "event_type", "event_start", "event_end", "event_comment");

        foreach ($required_inputs as $field) {
            if (is_null($field)) {
                js_alert(lang('big-article') . $field . lang('fill-the-field'), "back");
            }
        }
        $event_title = $this->input->post("event_title");
        $event_place = $this->input->post("event_place");
        $all_day = $this->input->post("all_day");
        $event_type = $this->input->post("event_type");
        $event_start = $this->input->post("event_start");
        $event_end = $this->input->post("event_end");
        $event_comment = $this->input->post("event_comment");

        try {
            $bool_query = $this->Timetable_model->add_event($event_title, $event_place, $all_day, $event_start, $event_end, $event_comment, $event_type);
        } catch (Exception $e) {
            if ($e->getMessage() == "invalid_event_end") js_alert(lang('wrong-event-end-value'), base_url("timetable/"));
            if ($e->getMessage() == "invalid_event_type") js_alert(lang('wrong-event-type-value'), base_url("timetable/"));
        }
        if ($bool_query) {
            js_alert(lang('add-finished'), base_url("timetable/"));
        }
    }


    public function manage_event_upload_edit()
    {
        require_status(Statuses::$LOGGED_IN);
        $required_inputs = array("event_id", "event_title", "event_place", "all_day", "event_type", "event_start", "event_end", "event_comment");

        foreach ($required_inputs as $field) {
            if (is_null($field)) {
                js_alert(lang('big-article') . $field . lang('fill-the-field'), "back");
            }
        }
        $event_id = $this->input->post("event_id");
        $event_title = $this->input->post("event_title");
        $event_place = $this->input->post("event_place");
        $all_day = $this->input->post("all_day");
        $event_type = $this->input->post("event_type");
        $event_start = $this->input->post("event_start");
        $event_end = $this->input->post("event_end");
        $event_comment = $this->input->post("event_comment");

        try {
            $event_id = $this->Timetable_model->get_event_type_id_by_event_title($this->Timetable_model->get_event_type_event_title_by_id($event_id));
            $bool_query = $this->Timetable_model->edit_event($event_id, $event_title, $event_place, $all_day, $event_start, $event_end, $event_comment, $event_type);
        } catch (Exception $e) {
            if ($e->getMessage() == "invalid_event_end") js_alert(lang('wrong-event-end-value'), base_url("timetable/"));
            if ($e->getMessage() == "invalid_event_type") js_alert(lang('wrong-event-type-value'), base_url("timetable/"));
        }
        if ($bool_query) {
            js_alert(lang('edit-finished'), base_url("timetable/"));
        }
    }


    public function manage_participants($event = "")
    {
        require_status(Statuses::$LOGGED_IN);
    }


}