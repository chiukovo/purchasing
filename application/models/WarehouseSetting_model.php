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
			->first_row();
	}

	/**
	 * update Password By Id
	 *
	 * @return bool true on success, false on failure
	 */
	public function updateFieldById($id, $updateData)
	{
		return $this->db->update(self::DB_NAME, $updateData, array('id' => $id));
	}
}