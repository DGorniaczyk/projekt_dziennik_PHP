<!DOCTYPE html>
<html>
<head>
  <title>School Gradebook</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h1>School Gradebook</h1>

  <?php
    // Define user role (admin, teacher, student)
    $userRole = "admin"; // Replace this with actual user role fetched from authentication

    // Fetch gradebook data from backend or database
    $grades = [
      [
        "subject" => "Math",
        "grades" => [
          ["John Doe", [["85", "2023-06-10"], ["90", "2023-06-03"]]],
          ["Jane Smith", [["92", "2023-06-12"], ["88", "2023-06-05"]]],
          ["Michael Johnson", [["78", "2023-06-11"], ["81", "2023-06-04"]]],
        ]
      ],
      [
        "subject" => "Science",
        "grades" => [
          ["John Doe", [["75", "2023-06-10"], ["80", "2023-06-03"]]],
          ["Jane Smith", [["90", "2023-06-12"], ["85", "2023-06-05"]]],
          ["Michael Johnson", [["82", "2023-06-11"], ["78", "2023-06-04"]]],
        ]
      ],
      // Add more subjects and grades here
    ];

    // Display content based on user role
    if ($userRole === "admin") {
      echo "<h2>Gradebook</h2>";

      foreach ($grades as $subject) {
        echo "<h3>" . $subject['subject'] . "</h3>";

        echo "<table>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Grade</th>";
        echo "<th>Previous Grade</th>";
        echo "<th>Date</th>";
        echo "<th>Action</th>";
        echo "</tr>";

        foreach ($subject['grades'] as $grade) {
          echo "<tr>";
          echo "<td>" . $grade[0] . "</td>";
          echo "<td>" . end($grade[1])[0] . "</td>";
          echo "<td>";
          if (count($grade[1]) > 1) {
            $previousGrade = prev($grade[1]);
            echo $previousGrade[0];
          }
          echo "</td>";
          echo "<td>";
          if (count($grade[1]) > 1) {
            $previousGrade = prev($grade[1]);
            echo $previousGrade[1];
          }
          echo "</td>";
          echo "<td><a href='edit_grade.php?name=" . urlencode($grade[0]) . "'>Edit</a> | <a href='delete_grade.php?name=" . urlencode($grade[0]) . "'>Delete</a></td>";
          echo "</tr>";
        }

        echo "</table>";
      }

      echo "<h2>Add Grade</h2>";
      echo "<form method='POST' action='add_grade.php'>";
      echo "<label for='subject'>Subject:</label>";
      echo "<input type='text' id='subject' name='subject' required>";
      echo "<br><br>";
      echo "<label for='name'>Name:</label>";
      echo "<input type='text' id='name' name='name' required>";
      echo "<br><br>";
      echo "<label for='grade'>Grade:</label>";
      echo "<input type='number' id='grade' name='grade' min='0' max='100' required>";
      echo "<br><br>";
      echo "<input type='submit' value='Add Grade'>";
      echo "</form>";

      echo "<h2>Manage Users</h2>";
      echo "<ul>";
      echo "<li><a href='add_user.php'>Add User</a></li>";
      echo "<li><a href='edit_user.php'>Edit User</a></li>";
      echo "<li><a href='delete_user.php'>Delete User</a></li>";
      echo "</ul>";
    }

    if ($userRole === "teacher") {
      echo "<h2>Gradebook</h2>";

      foreach ($grades as $subject) {
        echo "<h3>" . $subject['subject'] . "</h3>";

        echo "<table>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Grade</th>";
        echo "<th>Previous Grade</th>";
        echo "<th>Date</th>";
        echo "<th>Action</th>";
        echo "</tr>";

        foreach ($subject['grades'] as $grade) {
          echo "<tr>";
          echo "<td>" . $grade[0] . "</td>";
          echo "<td>" . end($grade[1])[0] . "</td>";
          echo "<td>";
          if (count($grade[1]) > 1) {
            $previousGrade = prev($grade[1]);
            echo $previousGrade[0];
          }
          echo "</td>";
          echo "<td>";
          if (count($grade[1]) > 1) {
            $previousGrade = prev($grade[1]);
            echo $previousGrade[1];
          }
          echo "</td>";
          echo "<td><a href='edit_grade.php?name=" . urlencode($grade[0]) . "'>Edit</a> | <a href='delete_grade.php?name=" . urlencode($grade[0]) . "'>Delete</a></td>";
          echo "</tr>";
        }

        echo "</table>";
      }

      echo "<h2>Add Grade</h2>";
      echo "<form method='POST' action='add_grade.php'>";
      echo "<label for='subject'>Subject:</label>";
      echo "<input type='text' id='subject' name='subject' required>";
      echo "<br><br>";
      echo "<label for='name'>Name:</label>";
      echo "<input type='text' id='name' name='name' required>";
      echo "<br><br>";
      echo "<label for='grade'>Grade:</label>";
      echo "<input type='number' id='grade' name='grade' min='0' max='100' required>";
      echo "<br><br>";
      echo "<input type='submit' value='Add Grade'>";
      echo "</form>";
    }

    if ($userRole === "student") {
      echo "<h2>Gradebook</h2>";

      foreach ($grades as $subject) {
        echo "<h3>" . $subject['subject'] . "</h3>";

        echo "<table>";
        echo "<tr>";
        echo "<th>Name</th>";
        echo "<th>Grade</th>";
        echo "<th>Previous Grade</th>";
        echo "<th>Date</th>";
        echo "</tr>";

        foreach ($subject['grades'] as $grade) {
          echo "<tr>";
          echo "<td>" . $grade[0] . "</td>";
          echo "<td>" . end($grade[1])[0] . "</td>";
          echo "<td>";
          if (count($grade[1]) > 1) {
            $previousGrade = prev($grade[1]);
            echo $previousGrade[0];
          }
          echo "</td>";
          echo "<td>";
          if (count($grade[1]) > 1) {
            $previousGrade = prev($grade[1]);
            echo $previousGrade[1];
          }
          echo "</td>";
          echo "</tr>";
        }

        echo "</table>";
      }
    }
  ?>

</body>
</html>