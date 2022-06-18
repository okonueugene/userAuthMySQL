<?php
   session_start();
   
   if(session_destroy()) {
    header("location: /userAuthMySQL/forms/login.html");
   }
?>