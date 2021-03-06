<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include '../database/db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	function add_menu()
	{
		extract($_POST);
		$data = "name='$name' ";
		$data .= ", price='$price' ";
		$data .= ", source='$source' ";
		$data .= ", description='$description' ";

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO menu set " . $data);
		} else {
			$save = $this->db->query("UPDATE menu set " . $data . "WHERE id=" . $id);
		}

		if ($save)
			return 1;
	}
	function book_menu()
	{
		extract($_POST);
		$data = "party_name='$name' ";
		$data .= ", contact='$contact' ";
		$data .= ", cnic='$cnic' ";
		$data .= ", delivery_date='$delivery_date' ";
		$data .= ", customer_address='$customer_address' ";
		$data .= ", delivery_address='$delivery_address' ";
		$data .= ", sum='$sum' ";
		$data .= ", discount='$discount' ";
		$data .= ", grandTotal='$grandTotal' ";



		$i = 1;
		while ($i == 1) {
			$order_id = mt_rand(999, 9999);
			$chk  = $this->db->query("SELECT * FROM order_details where order_id ='.$order_id.'")->num_rows;
			if ($chk <= 0) {
				$i = 0;
			}
		}

		$data .= ", order_id='$order_id'";

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO order_details set " . $data);
			for ($count = 0; $count < count($menu_id); $count++) {
				$booked = "";
				$booked .= "menu_id='$menu_id[$count]'";
				$booked .= ", order_id='$order_id'";
				$booked .= ", meal_id='$meal_id[$count]'";
				$booked .= ", making_qty='$making_qty[$count]'";
				$booked .= ", meal_qty ='$meal_qty[$count]'";
				$booked .= ", total='$total[$count]'";
				$booked .= ", provided='$provided[$count]'";
				$save = $this->db->query("INSERT INTO booked_items set " . $booked);
				// $vendor_id = $this->db->query("SELECT vendor_id FROM vendor where meal_id ='.$order_id.'");
				// $purchase_meal = "meal_id='$meal_id[$count]'";
				if($save){

					$kitchen_list = "item='$meal_id[$count]' ";
					$kitchen_list .= ", quantity='$making_qty[$count]' ";
					$order_id = mysqli_fetch_assoc(mysqli_query( $this->db, "SELECT id FROM booked_items ORDER BY id DESC LIMIT 1"))['id'];
					$kitchen_list .= ", order_id='$order_id' ";
					$kitchen_list .= ", onDate='$delivery_date' ";		

				$save1 = $this->db->query("INSERT INTO kitchen_list set " . $kitchen_list);

				}



			}

		} else {
			$save = $this->db->query("UPDATE order_details set " . $data . "WHERE id=" . $id);
		}


		if ($save)
			return 1;
		// return $kitchen_list;
	}
	function add_meal()
	{
		extract($_POST);
		$data = "name='$name' ";
		$data .= ", price='$mael_price' ";


		if (empty($id)) {
			$save = $this->db->query("INSERT INTO meal set " . $data);
		} else {
			$save = $this->db->query("UPDATE meal set " . $data . "WHERE id=" . $id);
		}



		if ($save)
			return 1;
	}
	function add_vendor()
	{
		extract($_POST);
		$data = "name='$name' ";
		$data .= ", contact='$contact' ";
		$data .= ", cnic='$cnic' ";
		// $data .= ", item_id='$item' ";
		$data .= ", address='$address' ";
		$data .= ", remarks='$remarks' ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO vendor set " . $data);
			$data_item = "meal_id='$item' ";
			$data_item .= ", vendor_id='1' ";
			$save = $this->db->query("INSERT INTO vendor_details set " . $data_item);
		} else {
			$save = $this->db->query("UPDATE vendor set " . $data . "WHERE id=" . $id);
		}
		if ($save)
			return 1;
	}
	function add_payment()
	{
		extract($_POST);
		$data = "order_id='$payment_party' ";
		$data .= ", type='$type' ";
		$data .= ", amount='$paid_amount' ";


		if (empty($id)) {
			$save = $this->db->query("INSERT INTO payments set " . $data);
		} 
		// else {
		// 	$save = $this->db->query("UPDATE payments set " . $data . "WHERE id=" . $id);
		// }



		if ($save)
			return 1;
	}

	function del_meal()
	{
		extract($_GET);
		$save = $this->db->query("DELETE FROM meal WHERE id=" . $id);



		if ($save)
			return 1;
	}
}
