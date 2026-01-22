<!-- <?php

require_once 'JsonObject.php';
require_once 'Salon.php'; // fichier contenant ta classe Salon

$salonCree = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère le nom envoyé par le formulaire
    $nom = $_POST['name'] ?? '';

    if (!empty($nom)) {
        // On crée un objet Salon avec la méthode create
        $salonCree = Salon::create($nom);
    } 
 }
?>-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création de salon</title>
</head>
<body>
    <h1>Créer un salon</h1>

    <form method="post" action="">
        <label for="name">Nom du salon :</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Créer</button>
    </form>
<?php if ($salonCree !== null): ?>
        <h2>Salon créé</h2>
        <p>Nom du salon : <?= htmlspecialchars($salonCree->name, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
</body>
</html>

