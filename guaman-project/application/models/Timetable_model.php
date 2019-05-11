<?php
/**
 * Created by PhpStorm.
 * User: horva
 * Date: 5/7/2019
 * Time: 10:31 PM
 * @property Account_model Account_model
 */


class Timetable_model extends CI_Model
{

    public static $TABLE_NAME = "timetable_list";
    public static $PARTICIPANTS_TABLE_NAME = "timetable_participants";
    public static $INVITES_TABLE_NAME = "timetable_invites";
    public static $EVENT_TYPE_TABLE_NAME = "timetable_event_type";

    /**
     * Timetable_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        self::$TABLE_NAME = $this->config->item('table_prefix') . self::$TABLE_NAME;
        self::$PARTICIPANTS_TABLE_NAME = $this->config->item('table_prefix') . self::$PARTICIPANTS_TABLE_NAME;
        self::$INVITES_TABLE_NAME = $this->config->item('table_prefix') . self::$INVITES_TABLE_NAME;
        self::$EVENT_TYPE_TABLE_NAME = $this->config->item('table_prefix') . self::$EVENT_TYPE_TABLE_NAME;
    }

    /**
     * @return array
     */
    public function get_timetable_event_types()
    {
        $event_types = array();
        $this->db->select("*");
        $result_array = $this->db->get(self::$EVENT_TYPE_TABLE_NAME)->result_array();
        /*foreach($result_array as $key => $value){
            foreach($value as $key2 => $value2){
                if(!in_array($value2, $event_types)){
                    $event_types[] = $value2;
                }}
        }*/
        return $result_array;
    }

    /**
     * @param $nice_name
     * @return mixed
     */
    public function get_id_by_nice_name($nice_name)
    {
        $this->db->select("id");
        $this->db->limit(1);
        $result = $this->db->get_where(self::$EVENT_TYPE_TABLE_NAME, array("nice_name" => $nice_name))->result_array();
        return $result[0]['id'];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get_nice_name_by_id($id)
    {
        $this->db->select("nice_name");
        $this->db->limit(1);
        $result = $this->db->get_where(self::$EVENT_TYPE_TABLE_NAME, array("id" => $id))->result_array();
        return $result[0]['nice_name'];
    }


    /**
     * @return array
     */
    public function get_timetable_event_places()
    {
        $event_places = array();
        $this->db->select("event_place");
        $result_array = $this->db->get(self::$TABLE_NAME)->result_array();
        foreach ($result_array as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if (!in_array($value2, $event_places)) {
                    $event_places[] = $value2;
                }
            }
        }
        return $event_places;
    }

    public function has_permission($user)
    {
        //Get has_permission from HR
        $this->load->model("HR_model");
        return $this->HR_model->has_permission($user);
    }

    /**
     * @param $id
     * @param $event_title
     * @param $event_place
     * @param $all_day
     * @param $event_start
     * @param $event_end
     * @param $event_comment
     * @param $event_type
     * @return bool
     */
    public function edit_event($id, $event_title, $event_place, $all_day, $event_start, $event_end, $event_comment, $event_type)
    {

        //todo test what we can


        $this->db->set('event_title', $event_title);
        $this->db->set('event_place', $event_place);
        $this->db->set('all_day', $all_day);
        $this->db->set('event_start', $event_start);
        $this->db->set('event_end', $event_end);
        $this->db->set('event_comment', $event_comment);
        $this->db->set('event_type', $event_type);

        $this->db->where('id', $id);
        $this->db->update(self::$TABLE_NAME);
        return true;

    }

    /**
     * @param $event
     * @param $user
     * @return bool
     */
    public function remove_user_from_event($event, $user)
    {
        //todo exception isUserId exists,
        $this->load->model("Database_model");
        $users = $this->Account_model->get_users("id");
        if (!in_array($user, $users)) {
            throw new Exception("invalid_user_id");
        }
        $this->db->where('user_id', $user);

        $this->db->where('event_id', $event);
        $this->db->delete(self::$TABLE_NAME);
        return true;
    }

    public function get_events_by_user($user)
    {
        return $this->db->get_where(self::$PARTICIPANTS_TABLE_NAME, array("user_id" => $user))->result_array();
    }

    public function add_event($event_title, $event_place, $all_day, $event_start, $event_end, $event_comment, $event_type)
    {

        //todo test what we can


        $this->db->set('event_title', $event_title);
        $this->db->set('event_place', $event_place);
        $this->db->set('all_day', $all_day);
        $this->db->set('event_start', $event_start);
        $this->db->set('event_end', $event_end);
        $this->db->set('event_comment', $event_comment);
        $this->db->set('event_type', $event_type);
        $this->db->insert(self::$TABLE_NAME);
        return true;
    }

    public function get_max_id()
    {
        $max_id = 0;
        $result_array = $this->db->get(self::$TABLE_NAME)->result_array();
        foreach ($result_array as $key => $value) {
            if ($value['id'] > $max_id) $max_id = $value['id'];
        }
        return $max_id;
    }

    /**
     * @param $user_array
     * @param $event
     */
    public function add_invite($user_array, $event)
    {
        foreach ($user_array as $key => $value) {
            $this->db->where("user_id", $value);
            $this->db->where("event_id", $event);
            $this->db->insert(self::$INVITES_TABLE_NAME);
        }
    }

    /**
     * @param $user_array
     * @param $event
     */
    public function remove_invite($user_array, $event)
    {
        foreach ($user_array as $key => $value) {
            $data = array(
                'user_id' => $value,
                'event_id' => $event
            );
            $this->db->insert(self::$INVITES_TABLE_NAME, $data);
        }
    }

    /**
     * @param $event
     * @return bool
     * @throws Exception
     */
    public function is_event_exists($event)
    {

        $result_array = $this->db->get_where(self::$TABLE_NAME, array("id", $event))->result_array();
        if (empty($result_array)) {
            return false;
        } elseif (!empty($result_array)) {
            return true;
        } else {
            throw new Exception($this->db->_error_message());
        }
    }

    /**
     * @param $event
     * @param $user
     * @return bool
     * @throws Exception
     */
    public function is_participant_exists($event, $user)
    {

        $result_array = $this->db->get_where(self::$PARTICIPANTS_TABLE_NAME, array("user_id" => $user, "event_id" => $event));
        if (empty($result_array)) {
            return false;
        } elseif (!empty($result_array)) {
            return true;
        } else {
            throw new Exception($this->db->_error_message());
        }
    }

    /**
     * @param $event
     * @param $user
     * @return bool
     * @throws Exception
     */
    public function is_invite_exists($event, $user)
    {
        $result_array = $this->db->get_where(self::$INVITES_TABLE_NAME, array("user_id" => $user, "event_id" => $event));
        if (empty($result_array)) {
            return false;
        } elseif (!empty($result_array)) {
            return true;
        } else {
            throw new Exception($this->db->_error_message());
        }
    }

    /**
     * @param $event_id
     * @return array
     */
    public function get_event_title_by_id($event_id)
    {
        $this->db->select("event_title");
        $this->db->limit(1);
        return $this->db->get_where(self::$TABLE_NAME, array("id" => $event_id))->result_array();
    }

    /**
     * @param $event_id
     * @return array
     */
    public function get_event($event_id)
    {
        return $this->db->get_where(self::$TABLE_NAME, array("id" => $event_id))->result_array();

    }


}