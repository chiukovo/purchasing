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