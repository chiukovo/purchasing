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
}