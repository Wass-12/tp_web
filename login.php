<?php
session_start();

require_once 'Userdb.php';
require_once 'User.php';

$userDb = UserDb::load();
$users = $userDb->get();

if (!empty($_POST)) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    foreach ($users as $u) {
        if ($u->email === $email && password_verify($password, $u->password)) {
            $_SESSION['user'] = $u;
            header("Location: index.php");
            exit;
        }
    }

    $error = "Email ou mot de passe incorrect.";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
<title>Connexion</title>
</head>
<body>

<h1>Connexion</h1>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br><br>
    <button type="submit">Se connecter</button>
</form>

<p><a href="register.php">Créer un compte</a></p>

</body>
</html>