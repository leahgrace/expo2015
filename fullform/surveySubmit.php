<?php
   $queryParameter = json_decode($_POST["json"], true);
   foreach($queryParameter as $value)
   {
      echo "--".$value["name"];
      echo "--".$value["value"];
   }
?>