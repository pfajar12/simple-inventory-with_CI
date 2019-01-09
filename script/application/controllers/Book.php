<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {
	
	public function __construct()
    {
            parent::__construct();
            $this->load->model('book_model');
            $this->load->model('category_model');
            $this->load->model('publisher_model');
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

		$data['title'] = ucfirst('book');
		$data['page'] = 'book';

		$data['data_list'] = $this->book_model->get_data_list()->result();
		$data['data_count'] = $this->book_model->get_data_list()->num_rows();

		$data['data_list_nonactive'] = $this->book_model->get_data_list_nonactive()->result();
		$data['data_count_nonactive'] = $this->book_model->get_data_list_nonactive()->num_rows();

		$data['category'] = $this->category_model->get_data_list()->result();

		$data['publisher'] = $this->publisher_model->get_data_list()->result();

		$this->load->view('template/header', $data);
		$this->load->view('book/index');
	}

	public function get_data($value='')
	{
		$this->book_model->get_data();
	}

	public function get_data_nonactive($value='')
	{
		$this->book_model->get_data_nonactive();
	}

	public function check_exist($value='')
	{
		$this->book_model->check_exist_data();
	}

	public function check_exist_foredit($value='')
	{
		$this->book_model->check_exist_data_foredit();
	}

	public function create($value='')
	{
		$this->book_model->create_new_data();
	}

	public function edit($id='')
	{
		if($this->session->userdata('role')!=1){
			if($this->session->userdata('warehouse_id')==1){
				redirect(base_url('warehousemenu'),'refresh');
			}
			else{
				redirect(base_url('stock'),'refresh');
			}
		}

		$data['title'] = ucfirst('book');
		$data['page'] = 'book';

		$data['data'] = $this->book_model->get_by_id($id)->row();

		$data['data_count'] = $this->book_model->get_by_id($id)->num_rows();

		$data['category'] = $this->category_model->get_data_list()->result();

		$data['publisher'] = $this->publisher_model->get_data_list()->result();

		$this->load->view('template/header', $data);
		$this->load->view('book/edit', $data);
	}

	public function update($value='')
	{
		$this->book_model->update_data();
	}

	public function delete($value='')
	{
		$this->book_model->delete_data();
	}

	public function restore($id='')
	{
		$this->book_model->restore_data();
	}
}
