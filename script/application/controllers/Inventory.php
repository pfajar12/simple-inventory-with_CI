<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('stock_model');
            $this->load->model('book_model');
    }

	public function index()
	{
		if($this->session->userdata('role')==''){
			redirect(base_url('login'),'refresh');
		}
		else{
			if($this->session->userdata('role')==1){
				redirect(base_url('home'),'refresh');
			}
			else if($this->session->userdata('warehouse_id')!=1){
				redirect(base_url('stock'),'refresh');
			}
		}

		$data['title'] = ucfirst('inventory');
		$data['page'] = 'inventory';

		$data['data'] = $this->stock_model->get_data_list()->result();
		$data['data_count'] = $this->stock_model->get_data_list()->num_rows();

		$data['book'] = $this->book_model->get_data_list()->result();

		$this->load->view('template/header', $data);
		$this->load->view('inventory/index');
	}

	public function get_data($value='')
	{
		$this->stock_model->get_data();
	}

	public function check_exist($value='')
	{
		$this->stock_model->check_exist_data();
	}
	
}
