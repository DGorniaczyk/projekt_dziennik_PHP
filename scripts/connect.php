<?php
//session_start()
// Establish database connection
$hostname = "localhost";
$username = "root";//ogarnac pobieranie danych usr i pass, nastepnie sprawdzenie
$password = "";
$dbname = "projekt_dziennik";

$conn = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user credentials
$user = $_POST['name']; // Assuming username is submitted via a POST request //<-- error!!!!
$password = $_POST['password']; // Assuming password is submitted via a POST request

// Sanitize and validate user input (e.g., using prepared statements)

//////////////////////////////////////////////////////////////////////////////////////////
// Query the database																	//
//$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'"; //
//$result = $conn->query($sql);															//
//																						//
//if ($result->num_rows == 1) {															//
//    // User is authenticated															//
//    $row = $result->fetch_assoc();													//
//    $privileges = $row['privileges'];													//
//																						//
//    // Store privileges in session or cookie											//
//    $_SESSION['privileges'] = $privileges;											//
//																						//
//    // Redirect the user to a specific page based on their privileges					//
//    if ($privileges == 'admin') {														//
//        header("Location: admin.php");												//
//        exit();																		//
//    } elseif ($privileges == 'user') {												//
//        header("Location: user.php");													//
//        exit();																		//
//    } else {																			//
//        header("Location: guest.php");												//
//        exit();																		//
//    }																					//
//////////////////////////////////////////////////////////////////////////////////////////
////////////////
$sql = "SELECT * FROM uczen, nauczyciel, admin WHERE uczen.email = ?";//add to email username
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);//added username, del email?
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $storedHash = $row['password'];
    $privileges = $row['privileges'];

    // Verify the password
    if (password_verify($password, $storedHash)) {
        // Password is correct
        // Store privileges in session or cookie
        $_SESSION['privileges'] = $privileges;

        // Redirect the user based on privileges
        if ($privileges == 'admin') {
            header("Location: ./administrator/register.php");
            exit();
        } elseif ($privileges == 'nauczyciel') {
            header("Location: ./nauczyciel/index.php");
            exit();
        } else {
            header("Location: ./user/index.php");
            exit();
        }
/////////////////
} else {
    // Invalid credentials
    echo "Invalid email or password.";
}}

// Close the database connection
$conn->close();
?>
