<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
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
            header("Location: salon_a.php");
            exit;
        }
    }

    $error = "Email ou mot de passe incorrect.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Connexion</h1>
            <p class="text-gray-500 mt-2">Accédez à votre espace membre</p>
        </div>

     <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                <input type="email" name="email" placeholder="nom@exemple.com" required 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform active:scale-[0.98]">
                Se connecter
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <p class="text-gray-600">
                Pas encore inscrit ? 
                <a href="register.php" class="text-blue-600 font-semibold hover:underline">Créer un compte</a>
            </p>
        </div>
    </div>

</body>
</html>