<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WarehouseSetting_model extends CI_Model {

	const DB_NAME = 'warehouse_setting';

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * get all
	 */
	public function getAll()
	{
		return $this->db->get_where(self::DB_NAME, ['id' => 1])
			->result_array();
	}
}