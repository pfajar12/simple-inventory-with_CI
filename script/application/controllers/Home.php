<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('admin_model');
            $this->load->model('book_model');
            $this->load->model('category_model');
            $this->load->model('publisher_model');
            $this->load->model('salestransaction_model');
            $this->load->model('stock_model');
            $this->load->model('stockcard_model');
            $this->load->model('warehouse_model');
    }

	public function index()
	{
		if($this->session->userdata('role')!=1){
			if($this->session->userdata('warehouse_id')==1){
				redirect(base_url('inventory'),'refresh');
			}
			else if($this->session->userdata('warehouse_id')==''){
				redirect(base_url('login'),'refresh');
			}
			else{
				redirect(base_url('stock'),'refresh');
			}
		}

		$data['title'] = ucfirst('Home');
		$data['page'] = 'home';

		$data['total_admin'] = $this->admin_model->get_total_admin();
		$data['total_book'] = $this->book_model->get_total_book();
		$data['total_category'] = $this->category_model->get_total_category();
		$data['total_publisher'] = $this->publisher_model->get_total_publisher();
		$data['total_salestransaction'] = $this->salestransaction_model->get_total_salestransaction();
		$data['total_stock'] = $this->stock_model->get_total_stock();
		$data['total_stockcard'] = $this->stockcard_model->get_total_stockcard();
		$data['total_warehouse'] = $this->warehouse_model->get_total_warehouse();

		$this->load->view('template/header', $data);
		$this->load->view('index');
	}

}
