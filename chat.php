<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'JsonObject.php';
require_once 'message.php';
require_once 'MessageDb.php';
require_once 'salons.php';
require_once 'SalonDb.php';

// 1. Vérifier que le salon existe
$salonId = $_GET['salonId'] ?? null;

if (!$salonId) {
    die("Aucun salon sélectionné.");
}

$salonDb = SalonDb::load();
$salon = $salonDb->getById((int)$salonId);

if (!$salon) {
    die("Salon introuvable.");
}

// 2. Charger les messages
$messageDb = MessageDb::load();
$messages = $messageDb->getBy("salonId", (int)$salonId);

// 3. Envoi d’un message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $author = $_POST['author'] ?? 'Anonyme';
    $content = trim($_POST['content'] ?? '');

    if (!empty($content)) {
        $msg = Message::create(
            (int)$salonId,
            $author,
            $content
        );

        $messageDb->insert($msg);
        $messageDb->save();

        header("Location: chat.php?salonId=" . $salonId);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chat - <?= htmlspecialchars($salon->name) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0a0b14] text-gray-200">

<div class="max-w-3xl mx-auto mt-10">

    <h1 class="text-3xl font-bold text-cyan-400 mb-6">
        💬 Salon : <?= htmlspecialchars($salon->name) ?>
    </h1>

    <!-- Zone des messages -->
    <div class="bg-black/40 border border-gray-700 rounded-lg p-6 h-96 overflow-y-auto mb-6">

        <?php if (empty($messages)): ?>
            <p class="text-gray-500 italic">Aucun message pour le moment...</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="mb-4">
                    <p class="text-cyan-300 font-semibold">
                        <?= htmlspecialchars($msg->author) ?>
                        <span class="text-gray-500 text-xs">
                            (<?= htmlspecialchars($msg->timestamp) ?>)
                        </span>
                    </p>
                    <p class="text-gray-300"><?= htmlspecialchars($msg->content) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <!-- Formulaire d’envoi -->
    <form method="POST" class="space-y-4">

        <input type="text" name="author" placeholder="Votre pseudo"
               class="w-full bg-black/40 border border-gray-700 rounded-lg px-4 py-2 text-white">

        <textarea name="content" placeholder="Votre message..."
                  class="w-full bg-black/40 border border-gray-700 rounded-lg px-4 py-2 text-white h-24"
                  required></textarea>

        <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-cyan-400 to-purple-600 rounded-lg font-bold text-white">
            Envoyer
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="admin.php" class="text-cyan-400 underline">Retour à l'administration</a>
    </div>

</div>

</body>
</html>