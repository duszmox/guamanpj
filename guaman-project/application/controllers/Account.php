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

        if (!$username || !$password) {
            // Load login form
            $this->load->view("templates/header", array(lang("login_title")));
            $this->load->view("account/login-form");
            $this->load->view("templates/footer");
        } else {
            // Login user
            if (!Validator::is_alphanumeric($username) || !Validator::is_alphanumeric($password)) {
                js_alert(lang("enter_valid_data_message") . base_url("account/login"));
            }
            if ($this->Account_model->login_user($username, Validator::encrypt($password))) {
                js_alert(lang("successful_login_message"), base_url("language/hungarian"));
            } else {
                js_alert(lang("wrong_login_message"), base_url("account/login"));
            }
        }


    }

    /**
     * Register page
     */
    function register()
    {
        if (!$this->config->item("allow_registration")) redirect(base_url("account/login"));

        if ($this->input->post("username") &&
            ($this->input->post("password") &&
                $this->input->post("email"))) {
            if (Validator::is_alphanumeric($this->input->post("username")) &&
                Validator::is_alphanumeric($this->input->post("password")) &&
                Validator::is_valid_email($this->input->post("email"))) {

                try {
                    $this->Account_model->register_user(
                        $this->input->post("username"),
                        $this->input->post("password"),
                        $this->input->post("email")
                    );
                } catch (Exception $exception) {
                    switch ($exception->getMessage()) {
                        case "unavailable_username":
                            js_alert(lang("used_username_message"), base_url("account/register"));
                            break;
                        case "unavailable_email":
                            js_alert(lang("used_email_message"), base_url("account/register"));
                            break;

                    }
                }
                js_alert(lang("successful_registration_message"), base_url("account/login"));
            }
        } else {
            // Load register form
            $this->load->view("templates/header", array("title" => lang("registration_title")));
            $this->load->view("account/register-form");
            $this->load->view("templates/footer");
        }


    }

    /*
     * Change password
     */
    function change_password()
    {
        require_status(Statuses::$LOGGED_IN);
        if ($this->input->post("current_password") && ($this->input->post("new_password") && $this->input->post("new_password_again"))) {
            if ($this->Account_model->get_user_field("password_hash", Account_model::$user_id) !== Validator::encrypt($this->input->post("current_password"))) {
                //print_r($_POST);
                js_alert(lang("invalid_current_password"), base_url("account/change_password"));
                die;
            } else if ($this->input->post("new_password") !== $this->input->post("new_password_again")) {
                js_alert(lang("again_password_not_matching"), base_url("account/change_password"));
                die;
            } else if (!Validator::is_alphanumeric($this->input->post("new_password"))) {
                js_alert(lang("invalid_new_password"));
                die;
            } else {
                $this->Account_model->set_user_field("password_hash", Account_model::$user_id, Validator::encrypt($this->input->post("new_password")));
                js_alert(lang("successful_password_changing"), base_url("account/login"));
            }
        } else {
            require_status(Statuses::$LOGGED_IN);
            $this->load->view("templates/header", array("title" => lang("change_password_title")));
            $this->load->view("templates/menu");
            $this->load->view("account/change_password_view");
            $this->load->view("templates/footer");
        }
    }

    /*
     * Profile page
     */
    function profile()
    {
        require_status(Statuses::$LOGGED_IN);
        $this->load->view("templates/header", array("title" => lang("my_profile_title")));
        $this->load->view("templates/menu");

        $this->load->view("account/my_menu", array("page_active" => "profile"));
        $this->load->view("account/my_profile", array(
            "username" => Account_model::$username,
            "user_id" => Account_model::$user_id,
            "rank" => Account_model::$rank,
            "email" => $this->Account_model->get_user_field("email", Account_model::$user_id),
            "phone_number" => $this->Account_model->get_user_field("phone_number", Account_model::$user_id),
            "is_phone_number_public" => $this->Account_model->get_user_field("is_phone_number_public", Account_model::$user_id)
        ));

        $this->load->view("templates/footer");

    }

    /**
     *  Settings page
     */
    function settings()
    {
        require_status(Statuses::$LOGGED_IN);
        $this->load->view("templates/header", array("title" => lang("settings_title")));

        $this->load->view("templates/menu");
        //todo András átadni neki az összes profile nevet
        $this->load->view("account/my_menu", array("page_active" => "settings"));

        $this->load->view("account/my_settings");

        $this->load->view("templates/footer");
    }

    /**
     *  Log out
     */
    function logout()
    {
        $this->Account_model->log_out();
            js_alert(lang("logout_message"), base_url("account/login"));
    }

    /**
     * GET Users
     */
    function get_users()
    {
        require_status(Statuses::$LOGGED_IN);

        $output = $this->Account_model->get_users(array("id", "username"));
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));

    }

    function admin(){

        require_permission("admin");


        $this->load->view("templates/header", array("title" => lang("admin_title")));

        $this->load->view("templates/menu");
        $users = $this->Account_model->get_users("username");
        $this->load->view("account/my_menu", array("page_active" => "admin", "users" => $users));

        $this->load->view("account/my_admin");

        $this->load->view("templates/footer");
    }
}
