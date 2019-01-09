<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribute extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('warehouse_model');
            $this->load->model('book_model');
            $this->load->model('stock_model');
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

		$data['title'] = ucfirst('Distribute Item');
		$data['page'] = 'distribute_item';

		$data['book'] = $this->book_model->get_data_list()->result();
		$data['warehouse'] = $this->warehouse_model->get_data_list()->result();

		$this->load->view('template/header', $data);
		$this->load->view('distribute/index');
	}

	public function check_qty($value='')
	{
		$this->stock_model->get_stock_by_id_warehouse();
	}

	public function books_distributing($value='')
	{
		$this->stock_model->books_distributing();
	}
}
