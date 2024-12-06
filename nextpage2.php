<!-- nextpage2.php is used to display the rest of the rows using the parameters passed through the link in search2.php
These parameters are the count variable, that will determine from which postion to output the rest of the book rows, 
I am also using the $categoryID value and the $total value which represents the total number of rows returned by sql statement in search2.php-->
<?php
  
  //starting session so that webpage has access to session variables like $_SESSION["account"]
  session_start();  

  //using !isset() to ensure that user is logged in to display nextpage.php
  //$_SESSION["account"] is only created if the user is logged in, if isset is false, the user is not logged in
  if (!(isset($_SESSION["account"]))) 
  {

    //if the user is not logged in and homepage.php is trying to be accessed, they will be redirected to login page
    header("Location: ../php/login.php"); 
  }
  else
  {
    /*Else, Connecting to database libDB */
    require_once "../database.php";
 
  }
?>

<!DOCTYPE html>
<html lang = "en">
<head>

    <style>
  
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home Page</title>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
   <header>
   <div id = "welcometext">
          <?php
            echo "Logged in as ";
            echo $_SESSION["account"] ;
          ?>   
    </div> 
    <nav class = "navbar navbar-expand-lg navbar-dark bg-dark">
        <div class = "navbar-brand">
           <a class = "nav-item nav-link active" href="../php/view_userbooks.php">My Reserved Books</a>
           <a class = "nav-item nav-link active" href="../php/homepage.php">Homepage</a>
           <a class = "nav-item nav-link active" href="../php/logout.php">Logout</a>
        </div>
    </nav>

    <div>
        <h1>Welcome to the library homepage!</h1> 
    </div>
   </header>


   <br>
   

        <?php

             //acquring the count value which was passed as a parameter inside the <link> tag in search2.php
           //it serves as the position from each the next 5 rows are displayed, it will be used in the select statement
            $count = $_GET['count'];
           
             //creating a new count variable $nc. In this case $nc is the $count value subtracted by 5. This will give us the position of the first row
             //to display the previous 5 rows.
            $nc = $count - 5;
           
            
        
            //The isset() statement is once again used to make sure that a book category value was chosen from the 
            //drop down meny first before running the rest of the code.
             //This ensures that the rest of the code is not run the first time the page is run
            if (isset($_GET['categoryID']))
            {
                $id = $_GET['categoryID'];
                $total = $_GET['total'];
                
                //creating a new variable called $newcount (which is $count added 5)
                //so that as $count increases by 1 everytime a new row is outputted, once it reaches $newcount 
               //it can exit loop by  placing "$result->num_rows = 0;" and display next link;
                $newcount  = $count + 5;


                //this sql statement will return the book rows containing the category id inserted by user
                //this statement contains LIMIT 5 OFFET $count
                //LIMIT 5 ensures that only 5 rows are returned
                //OFFSET $count is used to check from what poition the query will return the next 5 rows from
                //$count value is the position of the last row displayed, so that the same rows are not displayed more than once
                $sql = "SELECT ISBN, BookTitle, Author, Edition, Year,Reserved FROM books WHERE Category = '$id' LIMIT 5 OFFSET $count ";
                $result = $conn->query($sql);

                
                //displaying the previous page link and passing decreased $count value ($new) so that the user has access to the previous 5 rows
                if ($nc >= 0)
                {
                  echo "<br>";
                  $new = $nc;
                  echo "<a href='../php/nextpage2.php?count=".htmlentities($new)."&categoryID=".htmlentities($id)."&total=".htmlentities($total)."'>Previous Page</a>";
                }
            

                if($result->num_rows > 0 )
                {
                    echo "<table border ='1'>";
                    while($row = $result->fetch_assoc())
                    {
                        $nc -= 1 ;
                        $count += 1;
                            echo "<tr><td>";
                            echo ($row["BookTitle"]);
                            echo "</td><td>";
                            echo ($row["Author"]);
                            echo "</td><td>";
                            echo ($row["Edition"]);
                            echo "</td><td>";
                            echo ($row["Year"]);
                            echo "</td><td>";
                            echo ($row["Reserved"]);
                            if($row["Reserved"] == "N")
                            {
                                echo "</td><td>";
                                //echo ('<a href = "confirmdel.php?id='.htmlentities($row["ProductID"]).'">Delete</a>');
                                echo ('<a href = "../php/reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve Book</a>');
                                //echo "<a href=\"../php/reserve.php\">Reserve Book</a>";
                            }
                            else
                            {
                                echo "</td><td>";
                                echo "Already Reserved";
                            }
                            echo "</tr>\n";

                         //Once 5 rows have been displayed, we will be displaying the footer and next link.
                         //In this case, the "next link" will redirect the user to this same page (nextpage.php), however it will pass
                         //the updated value of count (as 5 more rows were outputted).
                         //So that once the user presses the link, the sql statement will run the offset element with count added 5.
                         //to display the next five rows from the updated postion
    
                        if ($count == $newcount)
                        { 
                            
                            
                            echo "<br>";


                            //the count value will only be displayed as long as the count is not equal to the total number of rows outputted by sql statement from search2.php
                           //so that once count reaches the total number, next page link wont be displayed leading the user to an empty page with no rows
                            if ($count != $total)
                            {
                              echo "<a href='../php/nextpage2.php?count=".htmlentities($count)."&categoryID=".htmlentities($id)."&total=".htmlentities($total)."'>Next Page</a>";
                            }
                            
                            echo "<br>";
                            echo "<br>";
                            echo "<a href='../php/homepage.php'>Go back to homepage</a>";
                            echo "</table>\n";
                            #code for footer
                            echo "<footer>";
                            echo "<div class=\"contact\" id=\"contact\">";
                              echo "<div class=\"bg-dark\">";
                            echo "<div class=\"container\">";
                              echo "<div class=\"row\">";
                                echo "<div class=\"col-lg-8 col-lg-offset-2 text-center\">";
                                  echo "<h1>To Get In Touch!</h1>";
                                  echo "<hr class=\"primary\"></hr>";
                                echo "<p class=\"my-font\">If you have any queries or concerns, you can contact us through email or by call. Thank you!</p>";
                                echo "</div>";

                                echo "<div class=\"padded\">";
                                  echo "<div class=\"col-lg-8 col-lg-offset-2 text-center\">";
                                  echo "<i class=\"fas fa-phone\"></i>";
                                  echo "<p>99999999</p>";
                                  echo "</div>";

                                  echo "<div class=\"col-lg-4 text-center\">";
                                    echo "<i class=\"fa fa-envelope-o fa-3x sr-contact\"></i>";
                                    echo "<p><a href=\"mailto:your-email@your-domain.com\">library@gmail.com</a></p>";
                                  echo "</div>";
                                  echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            echo "</div>";
                              echo "<p>©2024 Created by Maria Granados</p>";
                            echo "</footer>";
                              
                            $result->num_rows = 0;
                        }
                    } 
                    echo "</table>\n";
                }

  
            }


            
            //closiing connection to db
            $conn->close();
        ?>

    </section>

    

  
    
  <!-- HTML footer code-->
  <footer>
  <div class="contact" id="contact">
    <div class="bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 text-center">
        <h1>To Get In Touch!</h1>
        <hr class="primary"></hr>
      <p class="my-font">If you have any queries or concerns, you can contact
        us through email or by call. Thank you!</p>
      </div>

      <div class="padded">
       <div class="col-lg-8 col-lg-offset-2 text-center">
       <i class="fas fa-phone"></i>
       <p>99999999</p>
       </div>

       <div class="col-lg-4 text-center">
         <i class="fa fa-envelope-o fa-3x sr-contact"></i>
         <p><a href="mailto:your-email@your-domain.com">library@gmail.com</a></p>
       </div>
       </div>
      </div>
      </div>
   </div>
  </div>
    <p>©2024 Created by Maria Granados</p>
  </footer>

</body>
</html>