<!-- reserve.php is a page that will confirm user wants to reserve book 
This page does not contain the usual page layout
It is a blank page displaying the name of the book user wants to reserve and a  submit button to confirm reservation. 
Once reservation complete user goes back to homepage.php-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserve Book</title>
</head>
<body>
  <?php

    //starting session to get username
    session_start();
   

    //using !isset() to ensure that user is logged in to display reserve.php
    //$_SESSION["account"] is only created if the user is logged in, isset is false, the user is not logged in
    if (!(isset($_SESSION["account"]))) 
    {
      //if the user is not logged in and homepage.php is trying to be accessed, they will be redirected to login page
      header("Location: ../php/login.php"); 
    }
    else
    {
      /*Else, Connecting to database libDB */
      require_once "../database.php";
      echo "Hello ";
      echo $_SESSION["account"] ;

    }

    //making sure that the reserve button is clicked before running the following code
    //this is done to ensure that the code to reserve a book is not run the first time page is accessed (as the user wouldnt have had a chance to click on the button)
    if (isset($_POST['reserve']) && isset($_POST['id']))
    {
        //acquring the variables neeeded to perform the SQL INSERT statement to add the book, user and date into table "reservations" :

        //The book ISBN/id that was passed as a parameter of the href link
        $id = $conn -> real_escape_string ($_POST['id']);
        //The user's username which was stored as a session variable at the time of logging in
        $u = $_SESSION["account"] ;
        //The  date of when book was reserved
        $rd = date('Y-m-d');

        //this is a variable that will be used to update the reserved column in the table "books" so that no other user can reserve this particular book
        $r = 'Y';

        //inserting data into table "reservation"
        $sql = "INSERT INTO reservations (ISBN, Username, ReservedDate) VALUES 
              ('$id', '$u', '$rd' )";

        echo "<pre>\n$sql\n</pre>\n";
        $conn->query($sql);
        echo "<br>Reserving book..";

        //updating "books" table so that specific book with this ISBN has Y in reserved and cannot be reserved
        $sql = "UPDATE books SET Reserved = '$r' WHERE ISBN = '$id' ";
        echo "<pre>\n$sql\n</pre>\n";
        $conn->query($sql);

        //bringing user to homepage.php once book is reserved
        echo 'Succesfully reserved - <a href = "../php/homepage.php">Continue..</a>';
        return;
    }

    //confirming user wants to reserve book by diplaying the book ISBN respresented by $id and the name of book and a button that says confirm
    $id = $conn ->real_escape_string($_GET['id']);
    echo "<br>The ISBN of book is $id";
    $sql = "SELECT ISBN, BookTitle FROM books WHERE ISBN = '$id'";
    $result = $conn ->query($sql);
    $row = $result ->fetch_assoc();

    //creating a html form using echo displaying the name of the book being reserved and a button names "reserve"
    echo "<p>Confirm: Reserving ". htmlentities($row["BookTitle"]) . "</p>\n";
    echo ('<form method = "post"><input type="hidden" ');
    echo ('name = "id" value="'.htmlentities($row["ISBN"]).'">'."\n");
    echo ('<input type = "submit" value="Reserve" name="reserve">');
    echo ('<a href ="../php/homepage.php">Cancel</a>');
    echo ("\n</form>\n");
  
   //closing connection to db
    $conn->close();


  ?>


  
</body>
</html>