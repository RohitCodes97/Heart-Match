<?php
session_start();
session_unset();
session_destroy();

header("location: ./sign_up_in.php");

exit();

?>