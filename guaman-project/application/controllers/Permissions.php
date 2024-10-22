<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/17/2019
 * Time: 8:16 PM
 */

class Permissions extends CI_Controller
{

    function index()
    {
        redirect("permissions/manage_permissions");
    }



    function remove_permission()
    {
        require_permission("admin");

        $user_id = $this->input->post("user_id");
        $permission_name = $this->input->post("permission_name");
        try {
            $this->Permissions_model->remove_permission($user_id, $permission_name);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    function add_permission()
    {
        require_permission("admin");

        $user_id = $this->input->post("user_id");
        $permission_name = $this->input->post("permission_name");
        try {
            $this->Permissions_model->add_permission($user_id, $permission_name);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Has permission
     * for ajax requests
     */
    function has_permission()
    {
        require_status(Statuses::$LOGGED_IN);

        echo has_permission($this->input->post("permission_name")) ? "true" : "false";
    }
}
