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

        //設定layout data
        $this->layoutData = [];
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
        $allProduct = $this->input->post('product');

        $this->Product_model->create($allProduct);
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
}
