<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

require_once 'JsonObject.php';
require_once 'SalonDb.php';

$salonCree = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['name'] ?? '';

    if (!empty($nom)) {

        // 1. Charger la base
        $salonDb = SalonDb::load();

        // 2. Créer l'objet
        $salonCree = Salon::create($nom);

        // 3. Insérer dans la base
        $salonDb->insert($salonCree);

        // 4. Sauvegarder dans le fichier JSON
        $salonDb->save();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="salon.css"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon - Entrée au Lobby</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #1a1c2c 0%, #0a0b14 100%);
            font-family: 'Rajdhani', sans-serif;
            color: #e0e0e0;
            overflow: hidden;
        }
        .gaming-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 3px solid #00f2ff;
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.15);
        }
        .neon-text {
            font-family: 'Orbitron', sans-serif;
            text-shadow: 0 0 10px rgba(0, 242, 255, 0.7);
        }
        .input-glow:focus {
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.3);
            border-color: #00f2ff;
        }
        .btn-ready {
            background: linear-gradient(90deg, #00f2ff, #7000ff);
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s;
        }
        .btn-ready:hover {
            filter: brightness(1.2);
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(112, 0, 255, 0.6);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="gaming-card p-10 rounded-2xl w-full max-w-md relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-blue-500 blur-[80px] opacity-20"></div>
        
        <header class="text-center mb-8">
            <h1 class="neon-text text-3xl font-bold text-cyan-400 mb-2">SALON D'ENTRÉE</h1>
            <p class="text-gray-400 uppercase text-xs tracking-[0.3em]">Identification requise pour rejoindre</p>
        </header>

<?php if ($salonCree !== null): ?>
        <h2>Salon créé</h2>
        <p>Nom du salon : <?= htmlspecialchars($salonCree->name, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div class="relative">
                <label class="block text-xs font-semibold text-cyan-500 uppercase mb-2 ml-1">Tag Joueur (Email)</label>
                <input type="email" name="email" placeholder="nom@domaine.com" required 
                    class="w-full bg-black/40 border border-gray-700 rounded-lg px-4 py-3 text-white outline-none input-glow transition-all">
            </div>

            <div class="relative">
                <label class="block text-xs font-semibold text-cyan-500 uppercase mb-2 ml-1">Clé d'accès</label>
                <input type="password" name="password" placeholder="••••••••" required 
                    class="w-full bg-black/40 border border-gray-700 rounded-lg px-4 py-3 text-white outline-none input-glow transition-all">
            </div>

            <button type="submit" class="btn-ready w-full py-4 rounded-lg font-bold text-white mt-4">
                Déployer la session
            </button>
        </form>

        <footer class="mt-8 pt-6 border-t border-white/5 text-center">
            <p class="text-gray-500 text-sm">
                Pas encore de grade ? 
                <a href="register.php" class="text-cyan-400 hover:text-white transition-colors duration-300 font-semibold underline underline-offset-4">
                    Rejoindre l'escouade
                </a>
            </p>
        </footer>
    </div>

    <div class="pointer-events-none fixed inset-0 bg-[linear-gradient(rgba(18,16,16,0)_50%,rgba(0,0,0,0.1)_50%),linear-gradient(90deg,rgba(255,0,0,0.03),rgba(0,255,0,0.01),rgba(0,0,255,0.03))] bg-[length:100%_4px,3px_100%] z-50"></div>

</body>
</html>
