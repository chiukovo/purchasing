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

	public function updateNewProductAmount($productInfo, $productCount)
	{
		if ( ! empty($productInfo)) {
			foreach ($productInfo as $key => $product) {
				$thisAmount = $productCount[$key];
				$realName = $product['realName'];
				$search = array(
					'name' => $realName,
					'standard' => $product['standard'],
					'warehouse' => $product['warehouse'],
				);

				if ($thisAmount > $product['amount']) {
					return $product['realName'] . '已無庫存 !';
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
			}
		}
	}

	/**
	 * create
	 */
	public function create($insertData)
	{
		//扣掉庫存
		$insertData['productInfo'] = json_decode($insertData['productInfo'], true);
		$insertData['productCount'] = json_decode($insertData['productCount'], true);

		$updateAmount = $this->updateNewProductAmount($insertData['productInfo'], $insertData['productCount']);

		if ( !empty($updateAmount)) {
			return $updateAmount;
		}

		if ( ! empty($insertData['productInfo'])) {
			foreach ($insertData['productInfo'] as $key => $product) {
				$insertData['productInfo'][$key]['amount'] = $insertData['productCount'][$key];
			}
		}
		
		unset($insertData['productCount']);
		$insertData['productInfo'] = json_encode($insertData['productInfo']);
		
		$this->db->insert(self::DB_NAME, $insertData);
	}

	/**
	 * update
	 */
	public function orderEditUpdate($updateData, $id)
	{
		$updateData['productInfo'] = json_decode($updateData['productInfo'], true);
		$updateData['productCount'] = json_decode($updateData['productCount'], true);

		$sourceData = $this->getByFilters(array('id' => $id));

		$sourceProductInfo = json_decode($sourceData[0]['productInfo'], true);

		//檢查刪除商品的情況
		foreach ($sourceProductInfo as $before) {
			$isDelete = true;
			$realName = $before['realName'];
			$search = array(
				'name' => $realName,
				'standard' => $before['standard'],
				'warehouse' => $before['warehouse'],
			);

			$getWareProduct = $this->Product_model->getByFilters($search)[0];

			if ( ! empty($updateData['productInfo']) ) {
				foreach ($updateData['productInfo'] as $key => $now) {
					$nowAmount = $updateData['productCount'][$key];
					
					//計算是多還是少
					if ($now['name'] == $before['name']) {
						$isDelete = false;

						if ($before['amount'] > $nowAmount) {
							$thisAmount = $before['amount'] - $nowAmount;
							$toUpdateAmount = array(
								'amount' => $thisAmount
							);

							$this->Product_model->updateFieldById($getWareProduct['id'], $toUpdateAmount);

						} else if ($before['amount'] < $nowAmount) {
							$thisAmount = $nowAmount - $before['amount'];
							$toUpdateAmount = array(
								'amount' => $thisAmount
							);
							
							$this->Product_model->updateFieldById($getWareProduct['id'], $toUpdateAmount);
						}
					}
				}
			} else {
				$isDelete = true;
			}

			if ($isDelete) {
				$updateAmount = $before['amount'] + $getWareProduct['amount'];
				$toUpdateAmount = array(
					'amount' => $updateAmount
				);

				$this->Product_model->updateFieldById($getWareProduct['id'], $toUpdateAmount);
			}
		}

		//check new add product
		if ( ! empty($updateData['productInfo'])) {
			$newAdd = array();
			$newCount = array();

			foreach ($updateData['productInfo'] as $key => $now) {
				$isNew = true;

				foreach ($sourceProductInfo as $before) {
					if ($now['name'] == $before['name']) {
						$isNew = false;
					}
				}

				if ($isNew) {
					$newAdd[] = $now;
					$newCount[] = $updateData['productCount'][$key];
				}

				$updateData['productInfo'][$key]['amount'] = $updateData['productCount'][$key];
			}

			$this->updateNewProductAmount($newAdd, $newCount);
		}

		unset($updateData['productCount']);
		$updateData['productInfo'] = json_encode($updateData['productInfo']);

		$this->updateFieldById($id, $updateData);
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