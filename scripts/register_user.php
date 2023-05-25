<?php
function sanitizeInput($input){
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlentities(stripslashes(trim($input)));
		return $input;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		session_start();
		$requiredFields = ["firstName", "lastName", "email", "confirm_email", "pass", "confirm_pass", "birthday", "city_id"];

		$errors = [];
		foreach ($requiredFields as $value){//$key => $value
			if (empty($_POST[$value])){
				$errors[] = "Pole <b>$value</b> jest wymagane";
			}
		}

		if ($_POST["email"] != $_POST["confirm_email"]){
		$errors[] = "Adresy email muszą być identyczne";}

		if ($_POST["additional_email"] != $_POST["additional_confirm_email"]){
		$errors[] = "Dodatkowe adresy email muszą być identyczne";}

		if ($_POST["pass"] != $_POST["confirm_pass"]){
		$errors[] = "Hasła muszą być identyczne";}

		if (!isset($_POST["terms"])){
		$errors[] = "Zatwierdź regulamin";}

		if (!empty($errors)){
		foreach ($errors as $error){
			echo $error."<br>";
		}
		exit();
	}

//		foreach ($_POST as $key => $value){
//			//echo $_POST[$value]." ==> ";
//			${$key} = sanitizeInput($value);
//			//echo $firstName."<br>";
//		}
//		//echo $firstName;

		$city_id = sanitizeInput($_POST["city_id"]);
		$email = sanitizeInput($_POST["email"]);
		$additional_email = sanitizeInput($_POST["additional_email"]);
		$firstName = sanitizeInput($_POST["firstName"]);
		$lastName = sanitizeInput($_POST["lastName"]);
		$birthday = sanitizeInput($_POST["birthday"]);
		$pass = $_POST["pass"]; // hash the password later
		$password = password_hash($pass, PASSWORD_ARGON2ID);


		require_once "./connect.php";
		$stmt = $conn->prepare("INSERT INTO `users` (`city_id`, `email`, `additional_email`, `firstName`, `lastName`, `birthday`, `password`) VALUES (?, ?, ?, ?, ?, ?, ?)");

		$stmt->bind_param("issssss", $city_id, $email, $additional_email, $firstName, $lastName, $birthday, $password);

		
		$stmt->execute();

		$stmt->close();
		$conn->close();
// Redirect to a success page or perform other actions
header("location: ../pages/view/index.php");
exit();
	}else{
		header("location: ../pages/view/register.php");
	}