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
        $paramData = $this->input->get();

        $type = isset($paramData['type']) ? $paramData['type'] : '';

        if ( isset($paramData['start']) && isset($paramData['end'])) {
            $start = $paramData['start'];
            $end = $paramData['end'];
        } else {
            $first = new DateTime('first day of this month');
            $start = $first->format('Y-m-d');

            $last = new DateTime('last day of this month');
            $end = $last->format('Y-m-d');
        }

        $warehouse = $this->WarehouseSetting_model->getAll();

        $data = [
            'warehouse' => json_decode($warehouse->name),
            'type' => $type,
            'receiver' => json_decode($warehouse->receiver),
            'freight' => json_decode($warehouse->freight),
            'products' =>  $this->Product_model->getByDateRange($start, $end, $type),
            'start' => $start,
            'end' => $end,
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/warehouse/list', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }

    /**
     * list
     */
    public function in()
    {
        $paramData = $this->input->get();

        $search = isset($paramData['search']) ? $paramData['search'] : '';

        $products = $this->Product_model->searchByName($search);

        $products = $this->Product_model->forWarehouseInUse($products);

        $data = [
            'products' => $products['products'],
            'productsName' => $products['productsName'],
            'search' => $search
        ];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/warehouse/in', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }
}
