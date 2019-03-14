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
    public static $username = "";
    public static $user_id = 0;
    public static $logged_in = false;
    public static $rank = -1; // [logged out: -1; logged in: 0; admin: 1] (--> Rank helper)

    public function __construct()
    {
        self::$TABLE_NAME = $this->config->item("table_prefix") . self::$TABLE_NAME;


        $username = $this->session->userdata('username');
        $password_hash = $this->session->userdata('password_hash');
        $this->login($username, $password_hash);

    }


    function login($username, $password_hash, $print_error = false)
    {
        $this->db->select("id");
        $this->db->where("username", $username);
        $this->db->where("password_hash", $password_hash);
        $this->db->limit(1);
        $query = $this->db->get(self::$TABLE_NAME);
        $row = $query->row();
        if ($row) {
            self::$user_id = $row->id;
            self::$username = $username;
            self::$logged_in = true;
            self::$rank = $this->get_user_field("rank", self::$user_id);
            return true;
        } else {
            if ($print_error) {
                die("Login error");
            }
            return false;
        }
    }

    function login_user($username, $password_hash)
    {
        if (self::login($username, $password_hash)) {
            $this->session->set_userdata("username", $username);
            $this->session->set_userdata("password_hash", $password_hash);
            self::$logged_in = true;

            self::$rank = $this->get_user_field("rank", self::$user_id);
            return true;
        } else {
            return false;
        }
    }

    function log_out()
    {
        self::$logged_in = false;
        $this->session->set_userdata("username", "");
        $this->session->set_userdata("password_hash", "");
    }

    function get_username_by_id($id)
    {
        $this->db->select("username");
        $this->db->where("id", $id);
        $this->db->limit(1);
        $row = $this->db->get(self::$TABLE_NAME)->row();
        if ($row != null) {
            return $row->username;
        } else {
            return null;
        }
    }

    function is_available_username($username)
    {
        $this->db->select("id");
        $this->db->where("username", $username);
        $query = $this->db->get(self::$TABLE_NAME);
        return $query->num_rows() == 0;
    }

    function register_user($username, $password, $email)
    {
        if (!$this->is_available_username($username)) {
            throw new Exception("unavailable_username");
        } else if (!$this->is_available_email($email)) {
            throw new Exception("unavailable_email");
        } else {
            $this->db->insert(self::$TABLE_NAME, array(
                "username" => $username,
                "password_hash" => Validator::encrypt($password),
                "email" => $email
            ));
            return ($this->db->affected_rows() == 1) ? true : false;
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
        return true;
        // TODO check available email address
    }


}

