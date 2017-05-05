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
}
