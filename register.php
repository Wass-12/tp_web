<?php
session_start();

require_once 'Userdb.php';
require_once 'User.php';

$db = UserDb::load();

if (!empty($_POST)) {

    $email = trim($_POST['email']);
    $pseudo = trim($_POST['pseudo']);
    $password = $_POST['password'];

    // Vérifier si l'email existe déjà
    if ($db->getByEmail($email)) {
        $error = "Cet email est déjà utilisé.";
    } else {
        // Créer l'utilisateur
        $user = User::create($pseudo, $password, $email);
        $db->insertUser($user);
        $db->save();

        header("Location: login.php");
        exit;
    }
var_dump($db->get());
var_dump($user = User::create($pseudo, $password, $email));
}
//                          <!-- partie front -->
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" href="style.css"> -->
<title>Inscription</title>
</head>
<body>

<h1>Créer un compte</h1>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="pseudo" placeholder="Pseudo" required><br><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br><br>
    <button type="submit">S'inscrire</button>
</form>

</body>
</html>