<?php
// Inclure tous les fichiers nécessaires
require_once 'JsonObject.php';
require_once 'JsonDb.php';
require_once 'User.php';
require_once 'Userdb.php';
require_once 'salons.php';
require_once 'SalonDb.php';
require_once 'message.php';
require_once 'MessageDb.php';

// Gérer les actions
$action = $_GET['action'] ?? 'list';
$message = '';

// Actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        switch ($_POST['action']) {
            case 'create_user':
                $userDb = UserDb::load();
                $user = User::create($_POST['pseudo'], $_POST['password'], $_POST['email']);
                $userDb->insertUser($user);
                $userDb->save();
                $message = "Utilisateur créé avec succès (ID: {$user->id})";
                break;

            case 'create_salon':
                $salonDb = SalonDb::load();
                $salon = Salon::create($_POST['name']);
                $salonDb->insert($salon);
                $salonDb->save();
                $message = "Salon créé avec succès (ID: {$salon->id})";
                break;

            case 'create_message':
                $messageDb = MessageDb::load();
                $msg = Message::create(
                    (int)$_POST['salonId'],
                    $_POST['author'],
                    $_POST['content']
                );
                $messageDb->insert($msg);
                $messageDb->save();
                $message = "Message créé avec succès (ID: {$msg->id})";
                break;

            case 'delete_user':
                $userDb = UserDb::load();
                $userDb->delete((int)$_POST['id']);
                $userDb->save();
                $message = "Utilisateur supprimé avec succès";
                break;

            case 'delete_salon':
                $salonDb = SalonDb::load();
                $salonDb->delete((int)$_POST['id']);
                $salonDb->save();
                $message = "Salon supprimé avec succès";
                break;

            case 'delete_message':
                $messageDb = MessageDb::load();
                $messageDb->delete((int)$_POST['id']);
                $messageDb->save();
                $message = "Message supprimé avec succès";
                break;
        }
    } catch (Exception $e) {
        $message = "Erreur: " . $e->getMessage();
    }
}

// Charger les données
$userDb = UserDb::load();
$salonDb = SalonDb::load();
$messageDb = MessageDb::load();

$users = $userDb->get();
$salons = $salonDb->get();
$messages = $messageDb->get();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Application PHP - TP Web</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .section {
            margin-bottom: 40px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #4CAF50;
        }
        .section h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        form {
            display: grid;
            gap: 15px;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            padding: 12px 24px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        button:hover {
            background: #45a049;
        }
        button.delete {
            background: #f44336;
            padding: 8px 16px;
            font-size: 14px;
        }
        button.delete:hover {
            background: #da190b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .empty {
            text-align: center;
            color: #999;
            padding: 20px;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Interface de Test - Application PHP</h1>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Section Utilisateurs -->
        <div class="section">
            <h2>👤 Gestion des Utilisateurs</h2>
            
            <form method="POST">
                <input type="hidden" name="action" value="create_user">
                <div class="form-group">
                    <label>Pseudo:</label>
                    <input type="text" name="pseudo" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Créer un utilisateur</button>
            </form>

            <h3>Liste des utilisateurs (<?= count($users) ?>)</h3>
            <?php if (empty($users)): ?>
                <div class="empty">Aucun utilisateur</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pseudo</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user->id ?></td>
                                <td><?= htmlspecialchars($user->pseudo) ?></td>
                                <td><?= htmlspecialchars($user->email) ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete_user">
                                        <input type="hidden" name="id" value="<?= $user->id ?>">
                                        <button type="submit" class="delete">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Section Salons -->
        <div class="section">
            <h2>💬 Gestion des Salons</h2>
            
            <form method="POST">
                <input type="hidden" name="action" value="create_salon">
                <div class="form-group">
                    <label>Nom du salon:</label>
                    <input type="text" name="name" required>
                </div>
                <button type="submit">Créer un salon</button>
            </form>

            <h3>Liste des salons (<?= count($salons) ?>)</h3>
            <?php if (empty($salons)): ?>
                <div class="empty">Aucun salon</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($salons as $salon): ?>
                            <tr>
                                <td><?= $salon->id ?></td>
                                <td><?= htmlspecialchars($salon->name) ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete_salon">
                                        <input type="hidden" name="id" value="<?= $salon->id ?>">
                                        <button type="submit" class="delete">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <!-- Section Messages -->
        <div class="section">
            <h2>📝 Gestion des Messages</h2>
            
            <form method="POST">
                <input type="hidden" name="action" value="create_message">
                <div class="form-group">
                    <label>ID du salon:</label>
                    <input type="number" name="salonId" required min="1">
                </div>
                <div class="form-group">
                    <label>Auteur:</label>
                    <input type="text" name="author" required>
                </div>
                <div class="form-group">
                    <label>Contenu:</label>
                    <textarea name="content" rows="3" required></textarea>
                </div>
                <button type="submit">Créer un message</button>
            </form>

            <h3>Liste des messages (<?= count($messages) ?>)</h3>
            <?php if (empty($messages)): ?>
                <div class="empty">Aucun message</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Salon ID</th>
                            <th>Auteur</th>
                            <th>Contenu</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?= $msg->id ?></td>
                                <td><?= $msg->salonId ?></td>
                                <td><?= htmlspecialchars($msg->author) ?></td>
                                <td><?= htmlspecialchars($msg->content) ?></td>
                                <td><?= htmlspecialchars($msg->timestamp) ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete_message">
                                        <input type="hidden" name="id" value="<?= $msg->id ?>">
                                        <button type="submit" class="delete">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

