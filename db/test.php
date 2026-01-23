<?php
$data = ['status' => 'test OK'];
$result = file_put_contents('userdb.json', json_encode($data));

if ($result === false) {
    echo "Échec d'écriture\n";
    error_log("Erreur : impossible d'écrire dans userdb.json");
} else {
    echo "Écriture réussie\n";
}


?>
