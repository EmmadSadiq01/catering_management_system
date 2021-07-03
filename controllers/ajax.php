<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == "add_menu"){
	$save = $crud->add_menu();
	if($save)
		echo $save;
}
if($action == "book_menu"){
	$save = $crud->book_menu();
	if($save)
		echo $save;
}
if($action == "add_meal"){
	$save = $crud->add_meal();
	if($save)
		echo $save;
}
if($action == "add_payment"){
	$save = $crud->add_payment();
	if($save)
		echo $save;
}
if($action == "del_meal"){
	$save = $crud->del_meal();
	if($save)
		echo $save;
}