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
        $this->load->model('PurchaseOrder_model');

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
     * 商品key in
     */
    public function keyIn()
    {
        $data = [
            'product' =>  $this->Product_model->getAll()
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/keyIn', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * 商品訂單
     */
    public function order()
    {
        $content = file_get_contents('https://tw.rter.info/capi.php');
        $currency = json_decode($content);

        //美金匯率
        $USA = $currency->USDTWD->Exrate;
        $USA_time = $currency->USDTWD->UTC;

        $data = [
            'product' =>  $this->Product_model->getAll(),
            'orderNum' => date('YmdHis') . rand(10, 99),
            'USA' => $USA,
            'USA_time' => $USA_time
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/order', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * 商品key in
     */
    public function getAllProduct()
    {
        echo json_encode($this->Product_model->getAll());
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

            $this->PurchaseOrder_model->create($productOrder, $insertIds);
        }
    }

    /**
     * 商品key in
     */
    public function editUpdate()
    {
        $updateProduct = $this->input->post('product');

        $id = $updateProduct['id'];

        unset($updateProduct['id'], $updateProduct['checkText'], $updateProduct['checkInput']);

        $this->Product_model->updateFieldById($id, $updateProduct);

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

    /**
     * 取得上架商品
     */
    public function getOnlineProduct()
    {
        echo json_encode($this->Product_model->getOnline());
    }
}
