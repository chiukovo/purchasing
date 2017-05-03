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
	public function create($productOrder, $insertIds)
	{
		$insert = array(
			'date' => isset($productOrder['date']) ? $productOrder['date'] : '',
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