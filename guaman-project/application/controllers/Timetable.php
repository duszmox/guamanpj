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

    }

    /**
     * @param int $user
     */
    public function index($user = "")
    {
        $this->load->model("Account_model");
        $user = $this->Account_model::$user_id;

        $this->load->view("templates/header", array("page_title" => lang("timetable_label")));
        $this->load->view("templates/menu");
        $events_array = $this->Timetable_model->get_events_by_user($user);

        foreach ($events_array as $key => $value) {
            $var = $this->Timetable_model->get_event_title_by_id($value['event_id']);

            $events_array[$key]['event_title'] = $var[0]['event_title'];

            continue;
        }

        $this->load->view("timetable/timetable", array("events_array" => $events_array));


        $this->load->view("templates/footer");
    }

    public function manage_event($event = "")
    {
        if ($event == "") {
            $data = array(array());
        } else {
            $data = $this->Timetable_model->get_event($event);
            if (empty($data)) {
                js_alert("Invalid event id", base_url("timetable/"));
            }
        }
        $this->load->view("templates/header", array('page_title' => "Manage Event"));
        $this->load->view("templates/menu");

        $this->load->view("timetable/manage_event", array("data" => $data[0]));
        $this->load->view("templates/footer");
    }

    public function manage_participants($event = "")
    {

    }


}