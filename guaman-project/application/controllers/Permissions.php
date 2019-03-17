<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/17/2019
 * Time: 8:16 PM
 */

class Permissions extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		require_permission("admin");
	}

	function index()
	{
		redirect("permissions/manage_permissions");
	}

	function manage_permissions()
	{

	}

	function remove_permission()
	{
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
		$user_id = $this->input->post("user_id");
		$permission_name = $this->input->post("permission_name");
		try {
			$this->Permissions_model->add_permission($user_id, $permission_name);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}
