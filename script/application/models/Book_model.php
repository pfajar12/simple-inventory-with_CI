<?php
class Book_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_total_book($value='')
    {
    	$query = $this->db->get('book');
    	return $query->num_rows();
    }

    public function get_data_list($value='')
    {
    	$query = $this->db->query("SELECT a.id, a.book_code, a.name AS book_name, a.price, b.name AS category_name, c.name AS publisher_name, a.category AS category_id, a.publisher AS publisher_id FROM book a JOIN category b ON a.category=b.id JOIN publisher c ON a.publisher=c.id WHERE a.status = 1 ORDER BY a.id DESC");
    	return $query;
    }

    public function get_data_list_nonactive($value='')
    {
        $query = $this->db->query("SELECT a.id, a.book_code, a.name AS book_name, a.price, b.name AS category_name, c.name AS publisher_name, a.category AS category_id, a.publisher AS publisher_id FROM book a JOIN category b ON a.category=b.id JOIN publisher c ON a.publisher=c.id WHERE a.status = 0 ORDER BY a.id DESC");
        return $query;
    }

    public function check_exist_data($value='')
    {
    	$bookcode = htmlspecialchars($this->input->post('bookcode'));

    	$query = $this->db->query("SELECT id FROM book WHERE book_code='$bookcode'")->num_rows();

    	if($query<1){
    		echo 'not exist';
    	}
    	else{
    		echo 'exist';
    	}
    }

    public function check_exist_data_foredit($value='')
    {
    	$bookcode = htmlspecialchars($this->input->post('bookcode'));
    	$id = htmlspecialchars($this->input->post('id'));

    	$bookcodeFromDb = $this->db->query("SELECT book_code FROM book WHERE id='$id'")->row();

    	$query = $this->db->query("SELECT id FROM book WHERE book_code='$bookcode' AND book_code!='$bookcodeFromDb->book_code'")->num_rows();

    	if($query<1){
    		echo 'not exist';
    	}
    	else{
    		echo 'exist';
    	}
    }

    public function create_new_data($value='')
    {
    	$bookcode = htmlspecialchars($this->input->post('bookcode'));
    	$category = htmlspecialchars($this->input->post('category'));
    	$bookname = htmlspecialchars($this->input->post('bookname'));
    	$publisher = htmlspecialchars($this->input->post('publisher'));
    	$price = htmlspecialchars($this->input->post('price'));
    	
    	$query = $this->db->query("INSERT INTO book(book_code, category, name, publisher,price) VALUES('$bookcode', '$category', '$bookname', '$publisher', $price)");
    	if($query){
    		echo  'success';
    	}
    	else{
    		echo 'fail';
    	}
    }

    public function get_data($value='')
    {
    	$query = $this->db->query("SELECT a.id, a.book_code, a.name AS book_name, a.price, b.name AS category_name, c.name AS publisher_name FROM book a JOIN category b ON a.category=b.id JOIN publisher c ON a.publisher=c.id WHERE a.status = 1 ORDER BY a.id DESC")->result();
    	echo '{"items":'. json_encode($query).'}';

    }

    public function get_data_nonactive($value='')
    {
        $query = $this->db->query("SELECT a.id, a.book_code, a.name AS book_name, a.price, b.name AS category_name, c.name AS publisher_name FROM book a JOIN category b ON a.category=b.id JOIN publisher c ON a.publisher=c.id WHERE a.status = 0 ORDER BY a.id DESC")->result();
        echo '{"items":'. json_encode($query).'}';

    }

    public function get_by_id($id)
    {
    	$query = $this->db->query("SELECT a.id, a.book_code, a.name AS book_name, a.price, b.name AS category_name, c.name AS publisher_name, a.category, a.publisher FROM book a JOIN category b ON a.category=b.id JOIN publisher c ON a.publisher=c.id WHERE a.id='$id'");
    	return $query;
    }

    public function update_data($value='')
    {
    	$bookcode = htmlspecialchars($this->input->post('bookcode'));
    	$category = htmlspecialchars($this->input->post('category'));
    	$bookname = htmlspecialchars($this->input->post('bookname'));
    	$publisher = htmlspecialchars($this->input->post('publisher'));
    	$price = htmlspecialchars($this->input->post('price'));
    	$id = htmlspecialchars($this->input->post('id'));

    	$query = $this->db->query("UPDATE book SET book_code='$bookcode', category='$category', name='$bookname', publisher='$publisher', price='$price' WHERE id='$id'");
    	
    	if($query){
    		echo 'success';
    	}
    }

    public function delete_data($value='')
    {
    	$id = htmlspecialchars($this->input->post('id'));
    	$query = $this->db->query("UPDATE book SET status=0 WHERE id='$id'");

    	if($query){
    		echo 'success';
    	}
    }

    public function restore_data($value='')
    {
        $id = htmlspecialchars($this->input->post('id'));
        $query = $this->db->query("UPDATE book SET status=1 WHERE id='$id'");
        
        if($query){
            echo 'success';
        }
    }

    public function get_book_per_warehouse($value='')
    {
        $warehouse = $this->session->userdata('warehouse_id');
        $query = $this->db->query("SELECT a.id, a.book_code, a.name FROM book a JOIN stock b ON b.book_id=a.id WHERE b.warehouse_id = '$warehouse'");
        return $query;
    }

    public function get_stock_available($value='')
    {
        $warehouse = $this->session->userdata('warehouse_id');
        $book = htmlspecialchars($this->input->post('book'));

        $query = $this->db->query("SELECT qty FROM stock WHERE warehouse_id='$warehouse' AND book_id='$book'")->row();
        echo $query->qty;
    }
}