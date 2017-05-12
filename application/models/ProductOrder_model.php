<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductOrder_model extends CI_Model {

	const DB_NAME = 'product_order';

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_model');
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
	 * get by filters
	 */
	public function getByFilters($filters)
	{
		return $this->db->order_by('created_at', 'desc')
			->get_where(self::DB_NAME, $filters)
			->result_array();
	}

	/**
	 * create
	 */
	public function create($insertData)
	{
		//扣掉庫存
		$insertData['productInfo'] = json_decode($insertData['productInfo'], true);
		$insertData['productCount'] = json_decode($insertData['productCount'], true);

		if ( ! empty($insertData['productInfo'])) {
			foreach ($insertData['productInfo'] as $key => $product) {
				$thisAmount = $insertData['productCount'][$key];
				$realName = $product['realName'];
				$search = array(
					'name' => $realName,
					'standard' => $product['standard'],
				);
				$getWareProduct = $this->Product_model->getByFilters($search);

				$updateWare = array();
				foreach ($getWareProduct as $wareInfo) {
					if ($wareInfo['amount'] > 0) {
						if (($wareInfo['amount'] - $thisAmount) > 0) {

						} else {

						}
					}
				}
			}
		}

		$this->db->insert(self::DB_NAME, $insertData);
	}
}