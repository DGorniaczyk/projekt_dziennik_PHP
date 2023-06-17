<!DOCTYPE html>
<html>
<head>
    <title>Dziennik szkolny</title>
</head>
<body>
    <h1>Dziennik szkolny</h1>

    <?php
    // Sprawdzanie, czy formularz został wysłany
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Pobieranie danych z formularza
        $studentName = $_POST["studentName"];
        $subject = $_POST["subject"];
        $grade = $_POST["grade"];

        // Sprawdzanie, czy wszystkie pola formularza zostały wypełnione
        if (!empty($studentName) && !empty($subject) && !empty($grade)) {
            // Połączenie z bazą danych (zmień dane dostępowe do bazy danych)
            $connection = mysqli_connect("localhost", "nazwa_uzytkownika", "haslo", "nazwa_bazy_danych");

            // Sprawdzanie, czy udało się połączyć z bazą danych
            if ($connection === false) {
                die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
            }

            // Wstawianie oceny do bazy danych
            $query = "INSERT INTO oceny (student, przedmiot, ocena) VALUES ('$studentName', '$subject', '$grade')";
            $result = mysqli_query($connection, $query);

            // Sprawdzanie, czy operacja wstawiania danych się powiodła
            if ($result) {
                echo "Ocena została dodana do bazy danych.";
            } else {
                echo "Błąd podczas dodawania oceny do bazy danych: " . mysqli_error($connection);
            }

            // Zamykanie połączenia z bazą danych
            mysqli_close($connection);
        } else {
            echo "Wszystkie pola formularza muszą być wypełnione!";
        }
    }
    ?>

    <div class="addGrade">
    <h2>Dodaj ocenę</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="studentName">Imię i nazwisko ucznia:</label>
        <input type="text" name="studentName" required><br>

        <label for="subject">Przedmiot:</label>
        <input type="text" name="subject" required><br>

        <label for="grade">Ocena:</label>
        <input type="number" name="grade" min="1" max="6" required><br>

        <input type="submit" value="Dodaj ocenę">
    </form>
</div>
</body>
</html>
