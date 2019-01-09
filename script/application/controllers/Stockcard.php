<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockcard extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('stockcard_model');
            $this->load->model('warehouse_model');
    }

	public function index()
	{
		if($this->session->userdata('role')==''){
			redirect(base_url('login'),'refresh');
		}

		$data['title'] = ucfirst('Stock');
		$data['page'] = 'stock';

		$data['data_list_warehouse'] = $this->warehouse_model->get_all_list()->result();

		$this->load->view('template/header', $data);

		$this->load->view('stockcard/index');
	}

	public function get_stockcard_per_warehouse($value='')
	{
		$this->stockcard_model->get_stockcard_per_warehouse();
	}
}
