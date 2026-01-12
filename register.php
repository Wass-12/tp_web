<?php
$usersFile = __DIR__ . "/data/users.json";
$users = json_decode(file_get_contents($usersFile), true);


if (!empty($_POST)) {
    $email = trim($_POST['email']);
    $pseudo = trim($_POST['pseudo']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Vérifier si email existe déjà
    foreach ($users as $u) {
        if ($u['email'] === $email) {
            $error = "Cet email est déjà utilisé.";
        }
    }

    if (!isset($error)) {
        $users[] = [
            "id" => count($users) + 1,
            "email" => $email,
            "pseudo" => $pseudo,
            "password" => $password
        ];

        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));

        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">
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
