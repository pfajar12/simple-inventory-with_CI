<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('book_model');
    }

	public function index()
	{
		if($this->session->userdata('role')=='' || $this->session->userdata('warehouse_id<2')){
			redirect(base_url('login'),'refresh');
		}

		$data['title'] = ucfirst('pos');
		$data['page'] = 'pos';

		$data['data_list'] = $this->book_model->get_book_per_warehouse()->result();

		$this->load->view('template/header', $data);
		$this->load->view('pos/index');
	}

	public function get_book_per_warehouse($value='')
	{
		$this->book_model->get_book_per_warehouse();
	}

	public function get_stock_available($value='')
	{
		$this->book_model->get_stock_available();
	}
}
