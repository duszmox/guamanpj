<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 16:24
 * @property Account_model $Account_model
 */

class Account extends CI_Controller
{
    function index()
    {
        if (Account_model::$logged_in) {
            redirect("account/profile");
        } else {
            redirect("account/login");
        }
    }

    /**
     * Login page
     */
    function login()
    {

        $username = $this->input->post("username");
        $password = $this->input->post("password");

        if(!$username || !$password){
            // Load login form
            $this->load->view("templates/header", array(lang("login_title")));
            $this->load->view("account/login-form");
            $this->load->view("templates/footer");
        }
        else{
            // Login user
            if(!Validator::is_alphanumeric($username) || !Validator::is_alphanumeric($password)){
                js_alert(lang("enter_valid_data_message"). base_url("account/login"));
            }
            if($this->Account_model->login_user($username, Validator::encrypt($password))){
                js_alert(lang("successful_login_message"), base_url("account/profile"));
            }
            else{
                js_alert(lang("wrong_login_message"), base_url("account/login"));
            }
        }


    }

    /**
     * Register page
     */
    function register()
    {
        if ($this->input->post("username") &&
            ($this->input->post("password") && $this->input->post("email"))) {
            if (Validator::is_alphanumeric($this->input->post("username")) &&
                Validator::is_alphanumeric($this->input->post("password")) &&
                Validator::is_valid_email($this->input->post("email"))) {

                try{
                    $this->Account_model->register_user(
                        $this->input->post("username"),
                        $this->input->post("password"),
                        $this->input->post("email")
                    );
                }
                catch (Exception $exception){
                    switch ($exception->getMessage()){
                        case "unavailable_username":
                            js_alert("Ez a felhasználónév már foglalt!", base_url("account/register"));
                            break;
                        case "unavailable_email":
                            js_alert("Ezzel az email címmel már regosztrált valaki.", base_url("account/register"));
                            break;

                    }
                }
                js_alert("Sikeres regisztráció!", base_url("account/login"));
            }
        } else {
            // Load register form
            $this->load->view("templates/header", array("title" => "Regisztráció"));
            $this->load->view("account/register-form");
            $this->load->view("templates/footer");
        }
    }

    /**
     * Profile page
     */
    function profile(){
        require_rank(Ranks::$LOGGED_IN);
        $this->load->view("templates/header", array("title" => lang("my_profile_title")));
        $this->load->view("account/my_profile", array(
            "username" => Account_model::$username,
            "user_id" => Account_model::$user_id,
            "rank" => Account_model::$rank,
            "email" => $this->Account_model->get_user_field("email", Account_model::$user_id),
            "phone_number" => $this->Account_model->get_user_field("phone_number", Account_model::$user_id),
            "is_phone_number_public" => $this->Account_model->get_user_field("is_phone_number_public", Account_model::$user_id)
        ));
    }
    /**
     *  Log out
     */
    function logout(){
        $this->Account_model->log_out();
        js_alert(lang("logout_message"), base_url());
    }

}
