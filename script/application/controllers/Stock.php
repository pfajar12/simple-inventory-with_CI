<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('stock_model');
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

		if($this->session->userdata('role')==1){
			$this->load->view('stock/index-admin');
		}
		else{
			$this->load->view('stock/index');
		}
	}

	public function get_stock_per_warehouse($value='')
	{
		$this->stock_model->get_stock_per_warehouse();
	}
}
