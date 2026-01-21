<?php
require_once 'JsonObject.php';
require_once 'JsonDb.php';
require_once 'User.php';
require_once 'Userdb.php';
require_once 'salons.php';
require_once 'SalonDb.php';
require_once 'message.php';
require_once 'MessageDb.php';


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
            case 'delete_user':
                // Logique pour supprimer l'utilisateur si nécessaire
                break;
        }
    } catch (Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

 ?>


<!DOCTYPE html>
<html lang="fr">
<head>


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

