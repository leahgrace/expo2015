<?php
   $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = csdb.studentnet.int)(PORT = 1521)))(CONNECT_DATA=(SID=cs306)))" ;

   $conn = oci_connect('ljennings', 'LeahWagens||1234', 'CSDB.studentnet.int/CS306');
   if (!$conn) {
      echo "FAIL";
      $e = oci_error();
      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
   }
   else {

      $question_array = json_decode($_POST["json"], true);
      for ($i = 0; $i < count($question_array); $i++)
      {
         $stmt = oci_parse($conn, 'BEGIN :question_type := expoSurvey.getQuestionType(:question_id); END;');
         oci_bind_by_name($stmt, ':question_type', $question_type, 124);
         oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
         oci_execute($stmt);   

	 switch($question_type)
	 {
	    case "text":
	       if($question_array[$i]["value"] !== "")
	       {
	          $stmt = oci_parse($conn, 'BEGIN expoSurvey.insertTextResponses(:question_id, :response); END;');
                  oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
                  oci_bind_by_name($stmt, ':response', $question_array[$i]["value"]);
                  oci_execute($stmt);   
	       }
	       break;
	    case "text":
	       if($question_array[$i]["value"] !== "")
	       {
	          $stmt = oci_parse($conn, 'BEGIN expoSurvey.insertTextResponses(:question_id, :response); END;');
                  oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
                  oci_bind_by_name($stmt, ':response', $question_array[$i]["value"]);
                  oci_execute($stmt);   
	       }
	       break;
            case "number":
	       if($question_array[$i]["value"] !== "")
	       {
	          $stmt = oci_parse($conn, 'BEGIN expoSurvey.insertNumberResponses(:question_id, :response); END;');
                  oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
                  oci_bind_by_name($stmt, ':response', $question_array[$i]["value"]);
                  oci_execute($stmt);   
	       }
	       break;
	    case "radio":
	       $stmt = oci_parse($conn, 'BEGIN expoSurvey.insertRadioResponses(:question_id, :response_id); END;');
               oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
               oci_bind_by_name($stmt, ':response_id', $question_array[$i]["value"]);
               oci_execute($stmt);   
	       break;
	    case "range":
	       echo "Question id".$question_array[$i]["name"];
	       echo "Radio id".$question_array[$i]["value"];
	       echo "Response number".$question_array[$i + 1]["value"];
	       $range_value = (int)$question_array[$i]["value"];
	       $stmt = oci_parse($conn, 'BEGIN expoSurvey.insertRangeResponses(:question_id, :response_id, :range_value); END;');
               oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
               oci_bind_by_name($stmt, ':response_id', $question_array[$i + 1]["value"]);
               oci_bind_by_name($stmt, ':range_value', $range_value);
               oci_execute($stmt);   
	       break;
	    case "select":
	       echo $question_array[$i]["name"];
	       $stmt = oci_parse($conn, 'BEGIN expoSurvey.insertSelectResponses(:question_id, :response_id); END;');
               oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
               oci_bind_by_name($stmt, ':response_id', $question_array[$i]["value"]);
               oci_execute($stmt);   
	       break;
	    case "checkbox":
	       echo $question_array[$i]["name"];
	       $stmt = oci_parse($conn, 'BEGIN expoSurvey.insertCheckboxResponses(:question_id, :response_id); END;');
               oci_bind_by_name($stmt, ':question_id', $question_array[$i]["name"]);
               oci_bind_by_name($stmt, ':response_id', $question_array[$i]["value"]);
               oci_execute($stmt);   
	      break;
	 }
         echo "V: ".$question_array[$i]["value"];
	 echo "\n";
      }
   }
?>
