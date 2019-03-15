<?php
/**
 * Created by PhpStorm.
 * User: Fazekas RoboTeam
 * Date: 3/15/2019
 * Time: 2:37 PM
 */

class Module
{
	public $name;
	public $slug;
	public $subpages = array();

	public function add_page(Page $page){
		$this->subpages[]=$page;
	}

	public function __construct()
	{

	}


}

class Page{
	public $title;
	public $slug;
	public $min_rank;
}
