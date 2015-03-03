<?php

   // Import the constants file. This imports DATABASEADDRESS, DATABASEUSER, DATABASEPASS, and DATABASENAME
   require('constants.php');

   parse_str($_SERVER['QUERY_STRING'], $queryStringArray);


   $database = mysqli_connect(DATABASEADDRESS,DATABASEUSER,DATABASEPASS);

   if (mysqli_connect_errno())
   {
      //database_down();
   }
     
   @ $database->select_db(DATABASENAME) or database_down();
   
   foreach($queryStringArray as $question_id => $response) {
      //echo "Key=" . $question_id . ", Value=" . $response;
      //echo "<br>";
      if($question_id != "") 
      {
         $query = "INSERT INTO response (question_id, response, response_date) VALUES (?, ?, NOW());";
         $statement = $database->prepare($query);
         $statement->bind_param("ss", $question_id, $response);
         $statement->execute();
      }
   }

   mysqli_close($database);

   echo "Successfully stored responses."
?>