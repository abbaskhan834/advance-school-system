<?php
session_start();
session_unset();    // Saare session variables ko delete karta hai
session_destroy();  // Session ko khatam karta hai

// Browser cache ko clear karne ke liye headers (Optional lekin behtar hai)
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 

header("Location: index.php");
exit();
?>