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
	 * get by filters
	 */
	public function getByFilters($filters)
	{
		return $this->db->order_by('created_at', 'desc')
			->get_where(self::DB_NAME, $filters)
			->result_array();
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
	public function create($product, $code)
	{
		$insertId = [];

		foreach ($product as $info) {
			$insert = array(
				'name' => isset($info['name']) ? $info['name'] : '',
				'code' => $code,
				'weight' => isset($info['weight']) ? $info['weight'] : '',
				'amount' => isset($info['amount']) ? $info['amount'] : '',
				'money_us' => isset($info['money_us']) ? $info['money_us'] : '',
				'money_nt' => isset($info['money_nt']) ? $info['money_nt'] : '',
				'remark' => isset($info['remark']) ? $info['remark'] : '',
				'standard' => isset($info['standard']) ? $info['standard'] : '',
				'tracking_code' => isset($info['tracking_code']) ? $info['tracking_code'] : '',
				'warehouse' => isset($info['warehouse']) ? $info['warehouse'] : '',
				'freight' => isset($info['freight']) ? $info['freight'] : '',
				'receiver' => isset($info['receiver']) ? $info['receiver'] : '',
				'created_at' => date('Y-m-d h:i:s'),
				'updated_at' => date('Y-m-d h:i:s'),
			);

			if ($insert['name'] != '') {
				$this->db->insert(self::DB_NAME, $insert);
				$insertId[] = $this->db->insert_id();
			}
		}

		return json_encode($insertId);
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

	/**
	 * delete By code
	 */
	public function deleteByCode($code)
	{
		$this->db->delete(self::DB_NAME, array('code' => $code));
	}
}