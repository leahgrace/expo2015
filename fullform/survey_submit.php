<?php
   // Import the constants file. This imports DATABASEADDRESS, DATABASEUSER, DATABASEPASS, and DATABASENAME
   requires("constants.php");
   
   $database = mysqli_connect(DATABASEADDRESS,DATABASEUSER,DATABASEPASS);

   if (mysqli_connect_errno())
   {
      //database_down();
   }
     
   @ $database->select_db(DATABASENAME) or database_down();
   
   $query = "INSERT INTO table_name (column1, column2, column3) VALUES (?, ?, ?);";
   $statement = $database->prepare($query);
   $statement->bind_param("sss", $_GET['1'], $_GET['2'], $_GET['3']);
   $statement->execute();  

   mysqli_close($database);
?>