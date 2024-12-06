<!-- cancelreserve.php is a page that allows the user to cancel a book reservation.
The layout is similair to reserve.php as it does not contain a header, navigation bar or footer.
It is a blank page which displays the ISBN and Book Title of the book the user wants to cancel the reservation of. 
It also displays a "Cancel reservation" button that will run the php code to cancel the reservation if pressed  by user.-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cancel Reservation</title>
</head>
<body>
  <?php


    //starting session so that webpage has access to session variables like $_SESSION["account"]
    session_start();

    //using !isset() to ensure that user is logged in to display cancelreserve.php
    //$_SESSION["account"] is only created if the user is logged in, if isset is false, the user is not logged in
    if (!(isset($_SESSION["account"]))) 
    {
      //if the user is not logged in and view_userbooks.php is trying to be accessed, they will be redirected to login page
      header("Location: ../php/login.php"); 
    }
    else
    {
      /*Else, Connecting to database libDB */
      require_once "../database.php";
    }
    
    

    //Making sure that the "Cancel Reservation" button was pressed and the book ISBN/id was succesfully passed as an href parameter in the view_userbook.php
    //Passing the book ISBN through the <link> tag  is important to know which row should be deteled from "reservations" table as each row is uniquely identified by the ISBN
    if (isset($_POST['delete']) && isset($_POST['id']))
    {
        //placing the book ISBN of the book being deleted from "reservations" table into php variable '$id'.
        $id = $conn -> real_escape_string ($_POST['id']);
        
        //creating a new variable containing 'N. The "reserved" column of the "books" table for this particular book will also have to be updated to display not reserved
        //so that another user is allowed to reserve the book
        $r = 'N';

        //deleting the corresponding book from "reservations" table 
        $sql = "DELETE FROM reservations WHERE ISBN = '$id'";

        //echoeing sql statament into webpage
        echo "<pre>\n$sql\n</pre>\n";
        $conn->query($sql);
        echo "<br>Deleting reservation..";

        //updating "books" table so that specific book with isbn $id has N in reserved and can be reserved by another user
        $sql = "UPDATE books SET Reserved = '$r' WHERE ISBN = '$id' ";
        echo "<pre>\n$sql\n</pre>\n";
        $conn->query($sql);

        //once the book reservation is succesfully cancelled, the system will display a "Continue.." link
        //which will connect the user to homepage.php
        echo 'Succesfully cancelled reservation - <a href = "../php/homepage.php">Continue..</a>';
        return;
    }

    //the below code contains an SQL SELECT statement to retrieve the book title and ISBN of the given book id
    //this will then be used when creating the form later on
    $id = $conn ->real_escape_string($_GET['id']);
    echo "<br>The id of book is $id";
    $sql = "SELECT ISBN, BookTitle FROM books WHERE ISBN = '$id'";
    $result = $conn ->query($sql);
    $row = $result ->fetch_assoc();

    //creating a html form that displays the message "Cancelling reservation " of the book title that matches the ISBN passed by view_userbooks.php
    //Button "Cancel Reservation" is also displayed to confirm that the user wants to cancel reservation
    //The user can also go back to homepage.php using the displayed link "Go back to homepage"
    echo "<p>Confirm: Cancelling reservation ". htmlentities($row["BookTitle"]) . "</p>\n";
    echo ('<form method = "post"><input type="hidden" ');
    echo ('name = "id" value="'.htmlentities($row["ISBN"]).'">'."\n");
    echo ('<input type = "submit" value="Cancel Reservation" name="delete">');
    echo ('<a href ="../php/homepage.php">Go to homepage</a>');
    echo ("\n</form>\n");
  
   //closing connection to db
    $conn->close();


  ?>


  
</body>
</html>>