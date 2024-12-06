<!--PHP to connect to database, this will be included in the rest of php files using require_once()-->
<?php 
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "libDB";

      //Creating connection to libDB
      $conn = new mysqli ($servername, $username, $password, $dbname);

      //Checking conection and displaying message if failure to do so 
      if ($conn -> connect_error)
      {
         die("Connection failed: " . $conn->connect_error);
         echo "Connection error";
      }
      //echo "<br>";
      //echo "Connected succesfully";
?>
