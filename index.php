<html>
<head>
   <title>Student Academic Manager</title>
   
   <style>
      body {
         display: flex; 
         flex-direction: column;
         align-items: center;
         justify-content: center;
      }
      table {
         width: 100%;
         border-collapse: collapse;
         margin-bottom: 20px;
       }
       table, th, td {
         border: 1px solid #ddd;
       }
       th, td {
         padding: 12px;
         text-align: left;
       }
       th {
         background-color: #f2f2f2;
       }
       tr {
         background-color: #f9f9f9;
       }
   </style>
</head>
  
<body>
   <h1>Student Academic Manager</h1>

   <?php
   $db = new SQLite3 ("student.db");
   $db->exec ("CREATE TABLE IF NOT EXISTS student (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT)");
   $db->exec ("CREATE TABLE IF NOT EXISTS academic_details (id INTEGER PRIMARY KEY AUTOINCREMENT, student_id INTEGER, gpa INTEGER, grad_year INTEGER, FOREIGN KEY (student_id) REFERENCES student (id))");

   if (isset ($_POST ["Add_Student"])) {
      $name = $_POST ["name"]; 
      $email = $_POST ["email"];
      $db->exec ("INSERT INTO student (name, email) VALUES ('$name', '$email')");
   }

   if (isset ($_POST ["Add_Academic_Details"])) {
      $student_id = $_POST ["student_id"];
      $gpa = $_POST ["gpa"];
      $grad_year = $_POST ["grad_year"];
      $db->exec ("INSERT INTO academic_details (student_id, gpa, grad_year) VALUES ('$student_id', '$gpa', '$grad_year')");
   }

   if (isset ($_POST ["search"])) {
      $name = $_POST ["search_name"]; 

      $result = $db->query ("SELECT student.name, student.email, academic_details.gpa, academic_details.grad_year FROM student INNER JOIN academic_details ON student.id = academic_details.student_id WHERE student.name LIKE '$name'");

      echo "<table>";
      echo "<tr>"; 
      echo "<th>Name</th>";
      echo "<th>Email</th>";
      echo "<th>GPA</th>";
      echo "<th>Grad Year</th>";
      echo "</tr>";

      while ($row = $result->fetchArray (SQLITE3_ASSOC)) {
         echo "<tr>";
         echo "<td>" . $row ['name'] . "</td>";
         echo "<td>" . $row ['email'] . "</td>";
         echo "<td>" . $row ['gpa'] . "</td>";
         echo "<td>" . $row ['grad_year'] . "</td>";
         echo "</tr>";
      }

      echo "</table>";
   }
   
   ?>

   <h2>Add New Student</h2>
   <form action = "index.php" method = "POST">
      <label>Name:</label>
      <input type = "text" name = "name">

      <label>Email:</label>
      <input type = "text" name = "email">

      <input type = "submit" value = "Add Student" name = "Add_Student">
   </form>
   
   <h2>Add Academic Details</h2>
   <form action = "index.php" method = "POST">
      <label>Student id:</label>
      <input type = "text" name = "student_id">

      <label>GPA:</label>
      <input type = "text" name = "gpa">

      <label>Grad Year:</label>
      <input type = "text" name = "grad_year">

      <input type = "submit" value = "Add Academic Details" name = "Add_Academic_Details">
   </form>

   <h2>Search for Student</h2>
   <form action = "index.php" method = "POST">
      <label>Search Name: </label>
      <input type = "text" name = "search_name">
      
      <input type = "submit" value = "Search" name = "search">
   </form>
   
   <h2>Student List</h2>
   <?php
   
   $result = $db->query ("SELECT student.name, student.email, academic_details.gpa, academic_details.grad_year FROM student INNER JOIN academic_details ON student.id = academic_details.student_id");

   echo "<table>";
   echo "<tr>"; 
   echo "<th>Name</th>";
   echo "<th>Email</th>";
   echo "<th>GPA</th>";
   echo "<th>Grad Year</th>";
   echo "</tr>";

   while ($row = $result->fetchArray (SQLITE3_ASSOC)) {
      echo "<tr>";
      echo "<td>" . $row ['name'] . "</td>";
      echo "<td>" . $row ['email'] . "</td>";
      echo "<td>" . $row ['gpa'] . "</td>";
      echo "<td>" . $row ['grad_year'] . "</td>";
      echo "</tr>";
   }
   
   echo "</table>";
   ?>

</body>
</html>
