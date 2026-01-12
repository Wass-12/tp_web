<?php
session_start();

include 'classes/UserDb.php';

$db = UserDb::load();

if (!empty($_POST)) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // On récupère l'utilisateur APRES avoir l'email
    $user = $db->getByEmail($email);

    if ($user && password_verify($password, $user->password)) {
        // On stocke l'utilisateur en tableau dans la session
        $_SESSION['user'] = json_decode($user->toJson(), true);
        header("Location: index.php");
        exit;
    }

    $error = "Email ou mot de passe incorrect.";
}
//                       partie front 
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