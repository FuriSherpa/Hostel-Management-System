<?php
session_start();
session_destroy();
header("Location: index.php");
exit; // Ensure script execution stops after redirection
?>
