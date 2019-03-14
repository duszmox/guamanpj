<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 21:15
 * @property Database_model Database_model
 */

class Database extends CI_Controller
{
    function __construct()
    {

        parent::__construct();
        $this->load->model("Database_model");
        require_rank(Ranks::$ADMIN);
    }

    function index(){
        $this->load->view("templates/header");
        $this->load->view("templates/menu");
        $table_array = ($this->Database_model->get_tables());
        $this->load->view("database/table_view", array("table_array" => $table_array));
        $this->load->view("templates/footer");

    }
}
