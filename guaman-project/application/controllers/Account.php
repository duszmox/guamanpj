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
    function login($url = "")
    {

        $username = $this->input->post("username");
        $password = $this->input->post("password");



        if (!$username || !$password) {
            // Load login form

            $this->load->view("templates/header", array(lang("login_title")));
            $this->load->view("account/login-form", array("url" => $url));
            $this->load->view("templates/footer");
        } else {

            // Login user
            if (!Validator::is_alphanumeric($username) || !Validator::is_alphanumeric($password)) {
                js_alert(lang("enter_valid_data_message"), base_url("account/login"));
            }
            if ($this->Account_model->login_user($username, Validator::encrypt($password))) {
                $this->Account_model->login_log($username);
                $normal_url = str_replace("--", "/", $this->input->post("url"));
                $url_post = ($normal_url != "")?$normal_url:base_url("account/profile");
                js_alert(lang("successful_login_message"), $url_post);
            } else {
                js_alert(lang("wrong_login_message"), base_url("account/login/").$this->input->post("url"));
            }
        }


    }


    /**
     * Register page
     */
    function register()
    {
        if (!$this->config->item("allow_registration") && (!has_permission("admin"))) redirect(base_url("account/login"));

        if ($this->input->post("username") &&
            ($this->input->post("password") &&
                $this->input->post("email"))) {
            if (Validator::is_alphanumeric($this->input->post("username")) &&
                Validator::is_alphanumeric($this->input->post("password")) &&
                Validator::is_valid_email($this->input->post("email")) &&
                Validator::is_alphanumeric($this->input->post("nice_username"))

            ) {

                try {
                    $this->Account_model->register_user(
                        $this->input->post("username"),
                        $this->input->post("password"),
                        $this->input->post("email"),
                        $this->input->post("nice_username")
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
            "nice_username" => Account_model::$nice_username,
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
        $this->load->view("account/my_menu", array("page_active" => "settings"));

        $this->load->view("account/my_settings");

        $this->load->view("templates/footer");
    }

    /**
     *  Log out
     */
    function logout()
    {
        require_status(Statuses::$LOGGED_IN);
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

    function admin()
    {

        require_permission("admin");
        $username = $this->input->post("username");
        $user_id = $this->Account_model->get_id_by_username($username);



        $this->load->view("templates/header", array("title" => lang("admin_title")));

        $this->load->view("templates/menu");
        $users = $this->Account_model->get_users("username");
        $users_admin = array();
        $users_not_admin = array();
        foreach($users as $key => $value){
            if($this->Permissions_model->has_permission($this->Account_model->get_id_by_username($value['username']), "admin")){
                $users_admin[] = $value['username'];
            }else{
                $users_not_admin[] = $value['username'];
            }
        }
        $this->load->view("account/my_menu", array("page_active" => "admin"));
        $permissions_names = $this->Permissions_model->get_permissions_nice_name();

        $this->load->view("account/my_admin", array("permissions_name" => $permissions_names));

        $this->load->view("templates/footer");
    }

    function give_permissions()
    {
        require_permission("admin");
        $this->load->view("templates/header", array("title" => lang("give_permissions_title")));

        $this->load->view("templates/menu");
        $this->load->view("account/give_permissions", array("users" => $this->Account_model->get_users("username, id, nice_username")));
        $this->load->view("templates/footer");
    }

    /**
     * @param int $user_id
     * @throws Exception
     */
    function get_permissions($user_id = null){
        require_permission("admin");

        if(!Validator::is_numeric($user_id)) json_error(lang("invalid_user_id_label"));
        $permissions = $this->Permissions_model->get_permissions();

        foreach ($permissions as $key => $permission){
            $permissions[$key]["has_permission"] = $this->Permissions_model->has_permission($user_id, $permission["permission_name"]);
        }

        json_output($permissions);
    }

    /**
     * Adds or removes the specific permissions
     */
    function save_permissions($user_id = null){
        require_permission("admin");

        if(!Validator::is_numeric($user_id)) json_error(lang("invalid_user_id"));

        $permission_names = $this->Permissions_model->get_permission_names();

        $in_permissions = $this->input->post("permissions");

        foreach ($in_permissions as $in_permission){
            if(!in_array($in_permission["name"], $permission_names)) json_error(lang("invalid_permission_name"));
        }


        try {
            $this->Permissions_model->remove_permissions($user_id);
        } catch (Exception $e) {
            json_error($e->getMessage());
        }

        foreach ($in_permissions as $in_permission){
            if($in_permission["value"] === "on") {
                try {
                    $this->Permissions_model->add_permission($user_id, $in_permission["name"]);
                } catch (Exception $e) {
                    json_error($e->getMessage());
                }
            }
        }
    }
    function delete_user($userid){
        require_status(Statuses::$LOGGED_IN);
        $this->Account_model->delete_user($userid);
        redirect(base_url("account/admin"));
    }
    function feedback(){
        require_status(Statuses::$LOGGED_IN);
        require_permission("admin");
        $this->load->view("templates/header");

        $this->load->model("Database_model");

        $this->load->view("templates/menu");
        $data = $this->Database_model->get_table("*", "guaman_feedback", "id", "DESC");
        $this->load->view("account/feedback", array("data" => $data));
        $this->load->view("templates/footer");
    }


}
