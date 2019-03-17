<?php


$config["modules"][] = new Module("Adatbázis rendszer", "database_system", array(
	new Page("Táblázatok", "view_tables", array("view_tables")),
), array("database_system_operator"));

class Module
{
	public $name;
	public $slug;
	/**
	 * @var array<Page> Sub pages
	 */
	public $sub_pages = array();
	/**
	 * @var array permissions for displaying this page
	 */
	public $require_permissions;

	/**
	 * Module constructor.
	 *
	 * @param       $name
	 * @param       $slug
	 * @param array $sub_pages
	 * @param array $require_permissions
	 */
	public function __construct($name, $slug, array $sub_pages, array $require_permissions)
	{
		$this->name = $name;
		$this->slug = $slug;
		$this->sub_pages = $sub_pages;
		$this->require_permissions = $require_permissions;
	}


	public function add_page(Page $page)
	{
		$this->sub_pages[] = $page;
	}


}

class Page
{
	public $title;
	public $slug;
	/**
	 * @var array permissions for displaying this page
	 */
	public $require_permissions;

	/**
	 * Page constructor.
	 *
	 * @param               $title
	 * @param               $slug
	 * @param array<string> $require_permissions
	 */
	public function __construct($title, $slug, array $require_permissions)
	{
		$this->title = $title;
		$this->slug = $slug;
		$this->require_permissions = $require_permissions;
	}


}
