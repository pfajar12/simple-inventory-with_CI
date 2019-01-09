<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehousemenu extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('stock_model');
            // $this->load->helper('url_helper');
    }

	public function index()
	{
		if($this->session->userdata('warehouse_id')!=1){
			if($this->session->userdata('warehouse_id')==0){
				redirect(base_url('home'),'refresh');
			}
			else{
				redirect(base_url('stock'),'refresh');
			}
		}

		$data['title'] = ucfirst('Home');
		$data['page'] = 'warehousemenu';

		$warehouse_id_logged_in = $this->session->userdata('warehouse_id');
		$data['stock_total'] = $this->stock_model->get_stock_by_id($warehouse_id_logged_in);

		$this->load->view('template/header', $data);
		$this->load->view('warehouse/index');
	}

}
