<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseOrder_model extends CI_Model {

	const DB_NAME = 'purchase_order';

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
		$result = array();
		$all = $this->db->order_by('created_at', 'desc')->get(self::DB_NAME)->result_array();

		foreach ($all as $value) {
			$product = $this->Product_model->getByFilters(['code' => $value['code']]);
			$value['product'] = $product;
			$result[] = $value;
		}

		return $result;
	}

	/**
	 * get all
	 */
	public function getByDateRange($start, $end)
	{
		$result = array();

		//check not empty
		if (empty($start) || empty($end)) {
			$first = new DateTime('first day of this month');
    		$start = $first->format('Y-m-d');

			$last = new DateTime('last day of this month');
    		$end = $last->format('Y-m-d');
		}

		$get = $this->db->order_by('created_at', 'desc')
			->where('date >=', $start)
			->where('date <=', $end)
			->get(self::DB_NAME)
			->result_array();

		foreach ($get as $value) {
			$product = $this->Product_model->getByFilters(['code' => $value['code']]);
			$value['product'] = $product;
			$result[] = $value;
		}

		return $result;
	}

	/**
	 * create
	 *
	 * @return bool true on success, false on failure
	 */
	public function create($productOrder, $insertIds, $orderCode)
	{
		$insert = array(
			'date' => isset($productOrder['date']) ? $productOrder['date'] : '',
			'code' => $orderCode,
			'idCard' => isset($productOrder['idCard']) ? $productOrder['idCard'] : '',
			'rate' => isset($productOrder['rate']) ? $productOrder['rate'] : 0,
			'total_cost_us' => isset($productOrder['total_cost_us']) ? $productOrder['total_cost_us'] : 0,
			'total_cost_nt' => isset($productOrder['total_cost_nt']) ? $productOrder['total_cost_nt'] : 0,
			'productId' => $insertIds,
			'created_at' => date('Y-m-d h:i:s'),
			'updated_at' => date('Y-m-d h:i:s'),
		);

		$this->db->insert(self::DB_NAME, $insert);
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