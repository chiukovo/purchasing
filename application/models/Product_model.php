<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	const DB_NAME = 'product';

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
		return $this->db->order_by('created_at', 'desc')->get(self::DB_NAME)->result_array();
	}

	/**
	 * get online producu
	 */
	public function getOnline()
	{
		return $this->db->order_by('created_at', 'desc')
			->get_where(self::DB_NAME, array('status' => 1))
			->result_array();
	}

	/**
	 * create
	 *
	 * @return bool true on success, false on failure
	 */
	public function create($product)
	{
		foreach ($product as $info) {
			$info['created_at'] = date('Y-m-d h:i:s');
			$this->db->insert(self::DB_NAME, $info);
		}
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

	/**
	 * delete By Id
	 * @return bool true on success, false on failure
	 */
	public function deleteById($id)
	{
		return $this->db->delete(self::DB_NAME, array('id' => $id));
	}
}