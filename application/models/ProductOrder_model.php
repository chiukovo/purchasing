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
			$value['productInfo'] = json_decode($value['productInfo'], true);
			$result[] = $value;
		}

		return $result;
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
					'warehouse' => $product['warehouse'],
				);

				if ($thisAmount > $product['amount']) {
					return $product['amount'] . '已無庫存 !';
				}

				$getWareProduct = $this->Product_model->getByFilters($search);

				foreach ($getWareProduct as $info) {
					if ($info['amount'] > 0) {
						if ($info['amount'] >= $thisAmount) {
							$thisAmount = $info['amount'] - $thisAmount;
							$updateData = array(
								'amount' => $thisAmount
							);

							$this->Product_model->updateFieldById($info['id'], $updateData);
						} else {
							$thisAmount = $thisAmount - $info['amount'];
							$updateData = array(
								'amount' => 0
							);

							$this->Product_model->updateFieldById($info['id'], $updateData);
						}
					}
				}
				$insertData['productInfo'][$key]['amount'] = $insertData['productCount'][$key];
			}
		}
		
		unset($insertData['productCount']);
		$insertData['productInfo'] = json_encode($insertData['productInfo']);
		
		$this->db->insert(self::DB_NAME, $insertData);
	}

	/**
	 * delete By Id
	 */
	public function deleteById($id)
	{
		$targetProduct = $this->getByFilters(['id' => $id]);
		
		$product = json_decode($targetProduct[0]['productInfo'], true);

		foreach ($product as $info) {
			$search = array(
				'name' => $info['realName'],
				'standard' => $info['standard'],
				'warehouse' => $info['warehouse'],
			);

			$getWareProduct = $this->Product_model->getByFilters($search);

			$targetWareProduct = $getWareProduct[0];

			//加回去
			$udpateWare = array(
				'amount' => $targetWareProduct['amount'] + $info['amount']
			);

			$this->Product_model->updateFieldById($targetWareProduct['id'], $udpateWare);
		}

		$this->db->delete(self::DB_NAME, array('id' => $id));
	}
}