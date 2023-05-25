<?php
//	print_r($_POST);
	foreach ($_POST as $key => $value){
		//echo "$key: $value<br>";
		if (empty($value)){
			echo "<script>history.back();</script>";
			exit();
		}
	}

	require_once "./connect.php";
	$sql = "INSERT INTO `users` (`city_id`, `firstName`, `lastName`, `birthday`) VALUES ('$_POST[city_id]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[birthday]');";
	$conn->query($sql);

	//echo $conn->affected_rows; //1-ok, 0-

if ($conn->affected_rows ==0){
	header("location: ../5_db_table_delete_add_update.php?addUser=0");
}else{
	header("location: ../5_db_table_delete_add_update.php?addUser=1");
}
