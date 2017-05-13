<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller
{

    /**
     * setting
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('ProductOrder_model');
        $this->load->model('PurchaseOrder_model');
        $this->load->model('WarehouseSetting_model');

        //設定layout data
        $this->layoutData = [];
    }

    /**
     * 商品key in
     */
    public function index()
    {
        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/index', '', true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * 進貨單列表
     */
    public function list()
    {
        $paramData = $this->input->get();

        if ( isset($paramData['start']) && isset($paramData['end'])) {
            $start = $paramData['start'];
            $end = $paramData['end'];
        } else {
            $first = new DateTime('first day of this month');
            $start = $first->format('Y-m-d');

            $last = new DateTime('last day of this month');
            $end = $last->format('Y-m-d');
        }

        $data = [
            'product' =>  $this->PurchaseOrder_model->getByDateRange($start, $end),
            'start' => $start,
            'end' => $end
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/list', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * 商品key in
     */
    public function keyIn()
    {
        $warehouse = $this->WarehouseSetting_model->getAll();

        $data = [
            'warehouse' => json_decode($warehouse->name),
            'receiver' => json_decode($warehouse->receiver),
            'freight' => json_decode($warehouse->freight),
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/keyIn', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * 商品key in
     */
    public function productEdit()
    {
        $paramData = $this->input->get();
        $warehouse = $this->WarehouseSetting_model->getAll();

        if ( ! isset($paramData['code']) || empty($paramData['code'])) {
            redirect('/product/list');
        }

        $data = [
            'warehouse' => json_decode($warehouse->name),
            'receiver' => json_decode($warehouse->receiver),
            'freight' => json_decode($warehouse->freight),
            'code' => $paramData['code'],
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/productEdit', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * get by code
     */
    public function getProductByCode()
    {
        $paramData = $this->input->get();

        echo json_encode($this->PurchaseOrder_model->getByCode($paramData['code']));
    }

    /**
     * 商品key in
     */
    public function productEditUpdate()
    {
        $listProduct = $this->input->post('listProduct');
        $productOrder = $this->input->post('productOrder');


        if ( ! empty($listProduct) && ! empty($productOrder)) {
            $this->Product_model->deleteByCode($productOrder['code']);
            $insertIds = $this->Product_model->create($listProduct, $productOrder['code']);

            $id = $productOrder['id'];
            $productOrder['productId'] = $insertIds;
            $productOrder['updated_at'] = date('Y-m-d h:i:s');
            unset($productOrder['id']);

            $this->PurchaseOrder_model->updateFieldById($id, $productOrder);
        }
    }

    /**
     * 商品key in
     */
    public function editUpdate()
    {
        $listProduct = $this->input->post('listProduct');
        $productOrder = $this->input->post('productOrder');


        if ( ! empty($listProduct) && ! empty($productOrder)) {
            $this->Product_model->deleteByCode($productOrder['code']);
            $insertIds = $this->Product_model->create($listProduct, $productOrder['code']);

            $id = $productOrder['id'];
            $productOrder['productId'] = $insertIds;
            $productOrder['updated_at'] = date('Y-m-d h:i:s');
            unset($productOrder['id']);

            $this->PurchaseOrder_model->updateFieldById($id, $productOrder);
        }
    }

    /**
     * 商品key in
     */
    public function deleteByCode()
    {
        $code = $this->input->post('code');

        $this->Product_model->deleteByCode($code);

        $this->PurchaseOrder_model->deleteByCode($code);
    }

    /**
     * 商品訂單
     */
    public function order()
    {
        $data = [
            'product' =>  $this->Product_model->getAll(),
            'orderNum' => date('YmdHis') . rand(10, 99),
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/order', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * 商品訂單
     */
    public function orderUpdate()
    {
        $insertData = $this->input->post('insertData');
        $insertData['created_at'] = date('Y-m-d h:i:s');

        echo $this->ProductOrder_model->create($insertData);
    }

    /**
     * 商品key in
     */
    public function getAllProduct()
    {
        echo json_encode($this->Product_model->getAll());
    }

    /**
     * 取出不重複商品
     */
    public function getProductNotRepeat()
    {
        echo json_encode($this->Product_model->noReapeat());
    }

    /**
     * 商品key in
     */
    public function keyInUpdate()
    {
        $listProduct = $this->input->post('listProduct');
        $productOrder = $this->input->post('productOrder');

        if ( ! empty($listProduct)) {
            //code for order
            $orderCode = date('YmdHis') . rand(10, 99);

            $insertIds = $this->Product_model->create($listProduct, $orderCode);

            $this->PurchaseOrder_model->create($productOrder, $insertIds, $orderCode);
        }
    }

    /**
     * 商品key in
     */
    public function updateWarehouse()
    {
        $postData = $this->input->post();

        $id = $postData['id'];

        $updateData = array(
            $postData['type'] => $postData['value']
        );

        $this->Product_model->updateFieldById($id, $updateData);

        //new csrf
        echo $this->security->get_csrf_hash();
    }

    /**
     * 商品key in
     */
    public function deleteById()
    {
        $id = $this->input->post('id');

        $this->Product_model->deleteById($id);

        //new csrf
        echo $this->security->get_csrf_hash();
    }
}
