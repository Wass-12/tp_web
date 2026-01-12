<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
?>
                            <!-- partie front -->
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<title>Accueil</title>
</head>
<body>

<h1>Bienvenue, <?=htmlspecialchars($user['pseudo'])?></h1>

<a class="item" href="chat.php?type=dm&id=<?= $user['id'] ?>">Messages privés</a>
<a class="item" href="chat.php?type=channel&id=1">Salons</a>


<p><a href="logout.php">Déconnexion</a></p>

</body>
</html>
