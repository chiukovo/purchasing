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

        //設定layout data
        $this->layoutData = [];
    }

    /**
     * 商品key in
     */
    public function keyIn()
    {
        $data = [];

        //layout data
        $this->layoutData['content'] = $this->load->view('web/product/keyIn', $data, true);
        $this->load->view('web/layout/app', $this->layoutData);
    }
}
