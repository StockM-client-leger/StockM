<?php
session_start();
session_destroy(); // Détruit la session
header("Refresh: 3; url=http://localhost/Clientleger/index.php"); // Redirection correcte
echo "Vous etes déconnecté !".
exit();
?>