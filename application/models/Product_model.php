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
	 * noReapeat
	 */
	public function noReapeat()
	{
		$products = $this->db->order_by('created_at', 'desc')
			->where('warehouse !=', '')
			->get(self::DB_NAME)->result_array();

		$result = array();

		if (empty($products)) {
			return array();
		}

		foreach ($products as $product) {
			if ($product['standard'] != '') {
				$names[] = $product['name'] . '(' . $product['standard'] . ')';
			} else {
				$names[] = $product['name'];
			}
		}
		//取得全部庫存
		$names = array_unique($names);

		foreach ($names as $name) {
			$amount = array();
			$has = false;
			$warehouse = array();
			$allAmount = 0;

			foreach ($products as $product) {
				if ($product['standard'] != '') {
					$productName = $product['name'] . '(' . $product['standard'] . ')';
				} else {
					$productName = $product['name'];
				}

				if ($name == $productName) {
					if ($product['amount'] > 0) {
						$result[$name] = array(
							'name' => $name,
							'realName' => $product['name'],
							'standard' => $product['standard'],
							'weight' => $product['weight'],
						);
						$has = true;

						if ( ! isset($amount[$product['warehouse']])) {
							$amount[$product['warehouse']] = 0;
						}

						$amount[$product['warehouse']] += $product['amount'];

						$warehouse[] = $product['warehouse'];
						$allAmount += $product['amount'];
					}

				}
			}

			if ( ! empty($result) && $has) {
				$result[$name]['amount'] = $amount;
				$result[$name]['allAmount'] = $allAmount;
				$result[$name]['warehouse'] = array_unique($warehouse);
			}
		}

		return array_values($result);
	}

	/**
	 * get all
	 */
	public function searchByName($search)
	{
		if ($search == '') {
			return $this->db->order_by('created_at', 'desc')->get(self::DB_NAME)->result_array();
		} else {
			return $this->db->order_by('created_at', 'desc')
			->like('name', $search, 'both')
			->get(self::DB_NAME)
			->result_array();
		}

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
	 * get all
	 */
	public function getByDateRange($start, $end, $type)
	{
		$result = array();

		//check not empty
		if (empty($start) || empty($end)) {
			$first = new DateTime('first day of this month');
    		$start = $first->format('Y-m-d');

			$last = new DateTime('last day of this month');
    		$end = $last->format('Y-m-d');
		}

		$get = $this->db->order_by('created_at', 'desc');

		if ($type != '') {
			$get->where('warehouse', $type);
		}

		return $get->where('created_at >=', $start . ' 00:00:00')
			->where('created_at <=', $end . ' 23:59:59')
			->get(self::DB_NAME)
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

	/**
	 * 庫存用
	 */
	public function forWarehouseInUse($products)
	{
		$result = array();

		if (empty($products)) {
			return array(
				'productsName' => array(),
				'products' => array(),
			);
		}
		foreach ($products as $product) {
			$names[] = $product['name'];
		}

		$names = array_unique($names);

		foreach ($names as $name) {
			$amount = 0;
			foreach ($products as $product) {
				if ($name == $product['name']) {
					$result[$name]['detail'][] = $product;

					$result[$name]['standard'] = $product['standard'];
					$result[$name]['weight'] = $product['weight'];
					$amount = $amount + $product['amount'];
				}
			}

			$result[$name]['amount'] = $amount;
		}

		return array(
			'productsName' => $names,
			'products' => $result,
		);
	}
}