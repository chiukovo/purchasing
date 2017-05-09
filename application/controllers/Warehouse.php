<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends CI_Controller
{

    /**
     * setting
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('WarehouseSetting_model');

        //設定layout data
        $this->layoutData = [];
    }

    /**
     * setting
     */
    public function setting()
    {
        //layout data
        $this->layoutData['content'] = $this->load->view('web/warehouse/setting', '', true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * get all setting
     */
    public function getAllSetting()
    {
		echo json_encode($this->WarehouseSetting_model->getAll());
    }

    /**
     * get all setting
     */
    public function doUpdate()
    {
        $postData = $this->input->post();

        $name = isset($postData['name']) ? $postData['name'] : [];
        $receiver = isset($postData['receiver']) ? $postData['receiver'] : [];
        $freight = isset($postData['freight']) ? $postData['freight'] : [];

        $updateData = array(
            'name' => json_encode($name),
            'receiver' => json_encode($receiver),
            'freight' => json_encode($freight),
        );

        $this->WarehouseSetting_model->updateFieldById(1, $updateData);

        echo $this->security->get_csrf_hash();
    }

    /**
     * list
     */
    public function list()
    {
        $warehouse = $this->WarehouseSetting_model->getAll();

        $data = [
            'warehouse' => json_decode($warehouse->name),
            'receiver' => json_decode($warehouse->receiver),
            'freight' => json_decode($warehouse->freight),
            'products' =>  $this->Product_model->getAll(),
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/warehouse/list', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }
}
