<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 2019.03.14.
 * Time: 16:43
 */

class Account_model extends CI_Model
{
    public static $TABLE_NAME = "users";
    public static $TABLE_LOG_LOGIN_NAME = "login_log";
    public static $username = "";
    public static $nice_username = "";
    public static $user_id = 0;
    public static $logged_in = FALSE;
    public static $rank = -1; // [logged out: -1; logged in: 0; admin: 1] (--> Rank helper)

    public function __construct()
    {

        parent::__construct();

        self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;
        self::$TABLE_LOG_LOGIN_NAME = $this->config->item("table_prefix") . self::$TABLE_LOG_LOGIN_NAME;


        $this->session->sess_expiration = $this->config->item("session_time");// expires in 4 hours

        $username = $this->session->userdata('username');
        $password_hash = $this->session->userdata('password_hash');
        $this->login($username, $password_hash);

    }


    function login($username, $password_hash, $print_error = FALSE)
    {
        $this->db->select("");
        $this->db->where("username", $username);
        $this->db->where("password_hash", $password_hash);
        $this->db->limit(1);
        $query = $this->db->get(self::$TABLE_NAME);
        $row = $query->row();
        if ($row) {
            self::$user_id = $row->id;
            self::$username = $username;
            self::$nice_username = ($query->result_array())[0]['nice_username'];
            self::$logged_in = TRUE;
            self::$rank = $this->get_user_field("rank", self::$user_id);
            return TRUE;
        } else {
            if ($print_error) {
                die("Login error");
            }
            return FALSE;
        }
    }

    function login_user($username, $password_hash)
    {
        if (self::login($username, $password_hash)) {
            $this->session->set_userdata("username", $username);
            $this->session->set_userdata("password_hash", $password_hash);
            self::$logged_in = TRUE;

            self::$rank = $this->get_user_field("rank", self::$user_id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function log_out()
    {
        self::$logged_in = FALSE;
        $this->session->set_userdata("username", "");
        $this->session->set_userdata("password_hash", "");
    }

    function get_username_by_id($id)
    {
        $this->db->select("username");
        $this->db->where("id", $id);
        $this->db->limit(1);
        $row = $this->db->get(self::$TABLE_NAME)->row();
        if ($row != NULL) {
            return $row->username;
        } else {
            return NULL;
        }
    }

    function get_id_by_username($username)
    {
        $this->db->select("id");
        $this->db->where("username", $username);
        $this->db->limit(1);
        $row = $this->db->get(self::$TABLE_NAME)->row();
        if ($row != NULL) {
            return $row->id;
        } else {
            return NULL;
        }
    }

    function login_log($username)
    {
        $this->db->insert(self::$TABLE_LOG_LOGIN_NAME, array('id'=>NULL, "username" => $username, "date" => date('m/d/Y h:i:s a', time())));

    }

    function is_available_username($username)
    {
        $this->db->select("id");
        $this->db->where("username", $username);
        $query = $this->db->get(self::$TABLE_NAME);
        return $query->num_rows() == 0;
    }

    function register_user($username, $password, $email, $nice_username)
    {

        if (!$this->is_available_username($username)) {
            throw new Exception("unavailable_username");
        } else if (!$this->is_available_email($email)) {
            throw new Exception("unavailable_email");
        } else {
            $this->db->insert(self::$TABLE_NAME, array(
                "username" => $username,
                "password_hash" => Validator::encrypt($password),
                "email" => $email,
                "nice_username" => $nice_username
            ));
            return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
        }

    }

    public function get_user_field($col, $user_id)
    {
        $this->db->select($col);
        $this->db->where("id", $user_id);
        $query = $this->db->get(self::$TABLE_NAME);
        return $query->row()->$col;
    }

    public function set_user_field($col, $user_id, $value)
    {
        $this->db->where("id", $user_id);
        $this->db->update(self::$TABLE_NAME, array($col => $value));
    }

    public function increase_field($field, $user_id, $delta)
    {
        $this->set_user_field($field, $user_id, $this->get_user_field($field, $user_id) + $delta);
    }

    public function decrease_field($field, $user_id, $delta)
    {
        $this->set_user_field($field, $user_id, $this->get_user_field($field, $user_id) - $delta);
    }

    public function is_available_email($email)
    {
        $this->db->select("id");
        $this->db->where("email", $email);
        $query = $this->db->get(self::$TABLE_NAME);
        return $query->num_rows() == 0;
    }

    public function get_users($fields)
    {


        $this->db->select($fields);
        $query = $this->db->get(self::$TABLE_NAME);
        return $query->result_array();
    }
    public function delete_user($userid){
        $this->db->where("id", $userid);
        $this->db->delete(self::$TABLE_NAME);
    }




}

