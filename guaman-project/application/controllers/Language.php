<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 19:26
 */

if ( ! defined('BASEPATH')) exit('Direct access allowed');

class Language extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        echo $this->session->userdata("site_lang") . " " . lang("hello");
    }

    function switch_lang($language = "") {
        $language = ($language != "") ? $language : "english";
        if(!in_array($language, array("hungarian", "english"))) $language = "english";
        $this->session->set_userdata('site_lang', $language);
        redirect(base_url("account/profile"));
    }
}
