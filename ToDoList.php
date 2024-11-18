<?php
session_start(); // Démarrer la session pour stocker les tâches

// Initialiser la liste des tâches dans la session si elle n'existe pas
if (!isset($_SESSION['taches'])) {
    $_SESSION['taches'] = [];
}

// Ajouter une tâche si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tache']) && !empty(trim($_POST['tache']))) {
    $nouvelle_tache = htmlspecialchars($_POST['tache']); // Sécuriser l'entrée utilisateur
    $_SESSION['taches'][] = $nouvelle_tache; // Ajouter la tâche à la session
}

// Supprimer une tâche (optionnel : ajout d'un bouton supprimer)
if (isset($_GET['supprimer'])) {
    $index = intval($_GET['supprimer']); // Convertir l'index en entier
    if (isset($_SESSION['taches'][$index])) {
        unset($_SESSION['taches'][$index]); // Supprimer la tâche
        $_SESSION['taches'] = array_values($_SESSION['taches']); // Réindexer le tableau
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tâches</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        ul { list-style-type: none; padding: 0; }
        li { margin: 5px 0; }
        form { margin-bottom: 20px; }
        button { cursor: pointer; }
    </style>
</head>
<body>
    <h1>Liste des Tâches</h1>
    <form method="post" action="">
        <label for="tache">Ajouter une tâche :</label><br>
        <input type="text" id="tache" name="tache" required><br><br>
        <button type="submit">Ajouter</button>
    </form>

    <?php if (!empty($_SESSION['taches'])): ?>
        <ul>
            <?php foreach ($_SESSION['taches'] as $index => $tache): ?>
                <li>
                    <?php echo htmlspecialchars($tache); ?>
                    <a href="?supprimer=<?php echo $index; ?>" style="color: red; text-decoration: none;">[Supprimer]</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune tâche pour l'instant.</p>
    <?php endif; ?>
</body>
</html>
