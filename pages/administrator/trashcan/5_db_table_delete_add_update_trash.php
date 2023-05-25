<?php
  session_start();
?>
<!doctype html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="./css/table.css">
	<title>Użytkownicy</title>
</head>
<body>
<h4>Użytkownicy</h4>
<?php
if (isset($_GET["userIdDelete"])){
	if ($_GET["userIdDelete"] == 0){
		echo "<h4>Nie udało się usunąć rekordu!</h4>";
	}else{
		echo "<h4>Usunięto rekord id = $_GET[userIdDelete]</h4>";
	}
}

if (isset($_GET["addUser"])){
  if ($_GET["addUser"] == 0){
    echo "<h4>Nie udało się dodać użytkownika!</h4>";
  }else{
    echo "<h4>Dodano nowego użytkownika</h4>";
  }
}

if (isset($_GET["updateUser"])){
	if ($_GET["updateUser"] == 0){
		echo "<h4>Nie udało się zaktualizować użytkownika!</h4>";
	}else{
		echo "<h4>Zaktualizowano użytkownika</h4>";
	}
  unset($_SESSION["userUpdateId"]);
}
?>

<table>
	<tr>
		<th>ID<th>
		<th>Imię</th>
		<th>Nazwisko</th>
		<th>e-mail</th>
		<th>Password</th>
		
	</tr>

	<?php// zmiany!!!
	require_once "./scripts/connect.php";
	$sql = "SELECT u.student_ID, u.class_ID, u.name, u.surname, c.city, s.state FROM `users` u JOIN `cities` c ON `u`.`city_id`=`c`.`id` JOIN `states` s ON `c`.`state_id`=`s`.`id`;";
	$result = $conn->query($sql);
	//echo $result->num_rows;

	if ($result->num_rows == 0){
		echo "<tr><td colspan='100%'>Brak rekordów do wyświetlenia</td></tr>";
	}else{
		while($user = $result->fetch_assoc()){
			echo <<< TABLEUSERS
      <tr>
		<td>$user[student_ID]</td>
		<td>$user[class_ID]</td>
        <td>$user[name]</td>
        <td>$user[surname]</td>
        <td>$user[e-mail]</td>
        <td>$user[password]</td>
        <td><a href="./scripts/delete_user.php?userDeleteId=$user[student_ID]">Usuń</a></td>
        <td><a href="./5_db_table_delete_add_update.php?userUpdateId=$user[student_ID]">Edytuj</a></td>
      </tr>
TABLEUSERS;
		}
	}
	echo "</table><hr>";

 //formularz dodawania użytkownika
  if (isset($_GET["showFormAddUser"])){
    echo "<h4>Dodawanie użytkownika</h4>";
    echo <<< ADDUSERFORM
      <form action="./scripts/addUser.php" method="POST">
        <input type="text" name="name" placeholder="Podaj imię"><br><br>
        <input type="text" name="surname" placeholder="Podaj nazwisko"><br><br>
        <input type="date" name="birthday"> Data urodzenia <br><br>
        <select name="city_id">
<!--        <input type="number" name="city_id" placeholder="Podaj id miasta"><br><br>-->
ADDUSERFORM;
      //miasto
      $sql = "SELECT id, city FROM cities;";
      $result = $conn->query($sql);
      while ($city = $result->fetch_assoc()){
        echo "<option value='$city[id]'>$city[city]</option>";
      }
	  echo <<< ADDUSERFORM
        </select><br><br>
        <input type="submit" value="Dodaj użytkownika">
      </form>
ADDUSERFORM;
  }else{
    echo '<a href="./5_db_table_delete_add_update.php?showFormAddUser=1">Dodaj użytkownika</a>';
  }

	//formularz aktualizacji użytkownika
	if (isset($_GET["userUpdateId"])){
    $_SESSION["userUpdateId"] = $_GET["userUpdateId"];
		echo "<h4>Aktualizacja użytkownika</h4>";
    $sql = "SELECT * FROM users WHERE users.`id`='$_GET[userUpdateId]'";
    $result = $conn->query($sql);
    $updateUser = $result->fetch_assoc();
    //echo $updateUser["name"];
		echo <<< UPDATEUSERFORM
      <form action="./scripts/updateUser.php" method="POST">
        <input type="text" name="name" value="$updateUser[name]"><br><br>
        <input type="text" name="surname" value="$updateUser[surname]"><br><br>
        <input type="date" name="birthday" value="$updateUser[birthday]"> Data urodzenia <br><br>
        <select name="city_id">
<!--        <input type="number" name="city_id" placeholder="Podaj id miasta"><br><br>-->
UPDATEUSERFORM;
		//miasto
		$sql = "SELECT id, city FROM cities;";
		$result = $conn->query($sql);
		while ($city = $result->fetch_assoc())
    {
	    if ($city["id"] == $updateUser["city_id"]){
        echo "<option value='$city[id]' selected>$city[city]</option>";
      }else{
		    echo "<option value='$city[id]'>$city[city]</option>";
      }
		}
		echo <<< UPDATEUSERFORM
        </select><br><br>
        <input type="submit" value="Aktualizuj użytkownika">
      </form>
UPDATEUSERFORM;
	}


	$conn->close();
	?>

</body>
</html>