<?php

   // Import the constants file. This imports DATABASEADDRESS, DATABASEUSER, DATABASEPASS, and DATABASENAME
   require('constants.php');

   $question_counter = 1;
   $database = mysqli_connect(DATABASEADDRESS,DATABASEUSER,DATABASEPASS);      

   if (mysqli_connect_errno())      
   {      
      database_down();      
   }      
      
   @ $database->select_db(DATABASENAME) or database_down();      
    
   $query = "SELECT DISTINCT q.question_id, q.question, q.input_type, q.placeholder_text
               FROM question q
                    LEFT OUTER JOIN addt_info_of_question a ON (q.question_id = a.question_id)
              ORDER BY q.question_id;";
  
   $statement = $database->prepare($query);     
   $statement->bind_result($question_id, $question, $input_type, $placeholder_text);   
  
   $statement->execute();  

   while ($statement->fetch())  
   {  
      if ($input_type == "text")
      {
         echo "<li>
                  <label class='fs-field-label fs-anim-upper' for='q".$question_counter."'>".$question."</label>
                  <input class='fs-anim-lower' id='q".$question_counter."' name='".$question_id."' placeholder='".$placeholder_text."' type='text' value='1' required/>
               </li>";
         $question_counter++;
      }
      else if ($input_type == "number")
      {
         echo "<li>
                  <label class='fs-field-label fs-anim-upper' for='q".$question_counter."'>".$question."</label>
                  <input class='fs-mark fs-anim-lower' id='q".$question_counter."' name='".$question_id."' type='number' placeholder='".$placeholder_text."' step='1' min='0' max='10' value='1' required/>
               </li>";
         $question_counter++;
      }
      // All radio options used here are assumed to be values 'yes' or 'no'
      else if ($input_type == "radio")
      {
         echo "<li data-input-trigger>
                  <label class='fs-field-label fs-anim-upper' value='4' for='q".$question_counter."'>".$question."</label>
                  <div class='fs-radio-group fs-radio-custom clearfix fs-anim-lower'>
                     <span>
                        <input id='q".$question_counter."a' name='".$question_id."' type='radio' value='yes'/>
                        <label for='q".$question_counter."a' class='icon-computer'>Yes</label>
                     </span>
                     <span>
                        <input id='q".$question_counter."b' name='".$question_id."' type='radio' value='no'/>
                        <label for='q".$question_counter."b' class='icon-paper'>No</label>
                     </span>
                  </div>
               </li>";
         $question_counter++;
      }
      else if ($input_type == "range")
      {
         echo "<li>
                     <label class='fs-field-label fs-anim-upper' value='5' for='q5'>How would you describe College Life?</label>
                     <div class='fs-anim-lower'>
                        <table>
                        <tr>
                              <td><span>Very confusing</span></td>
                              <td><input class='fs-anim-lower' id='q5a' name='5' type='range' min='0' max='100' /></td>
                              <td><span>Very user-friendly</span></td>
                           </tr>
                           <tr>
                              <td><span>Looks ugly</span></td>
                              <td><input class='fs-anim-lower' id='q5b' name='5' type='range' min='0' max='100' /></td>
                              <td><span>Looks great!</span></td>
                           </tr>
                        </table>
                     </div>
                  </li>";
      }
   }
   mysqli_close($database);
?>