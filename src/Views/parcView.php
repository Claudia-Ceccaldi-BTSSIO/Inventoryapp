<?php
// Inclusion des fichiers pour l'authentification et la connexion à la base de données
require_once '../Controllers/authController.php';
require_once '../Models/databaseConnexion.php';
require_once '../Models/materiel.php'; // Inclusion de la classe Materiel

// Démarrage d'une session si aucune session n'est active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Création d'une instance de la classe Materiel
$materiel = new Materiel();

// Récupération du terme de recherche s'il a été soumis
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Appel de la méthode searchMateriel pour obtenir les données en fonction du terme de recherche
$materielData = $materiel->searchMateriel($searchTerm);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PARC de la CAF 47</title>
    <link rel="stylesheet" href="/assets/css/main.css?v=1">
</head>

<body>
    <nav>
        <!-- Barre de navigation -->
        <!-- Bouton de retour à la page d'accueil -->
        <a href="../../index.php" class="retour-accueil">Retour à la page d'accueil</a>
    </nav>
    <!-- Bouton pour afficher les comptes utilisateurs -->
    <button id="showFormButton">Affichage des Comptes Utilisateurs</button>
    <form id="ajoutMaterielForm" action="../Utils/insert.php" method="get" style="display: none;">
        <!-- Champs du formulaire correspondant à la structure de la table 'Materiel' -->
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="text" name="service" placeholder="Service" required>
        <input type="text" name="validation_compte_user" placeholder="validation_compte_user"required>
        <input type="submit" value="Ajouter">
    </form>
    <!-- Bouton pour afficher le formulaire d'ajout de matériel -->
    <button id="showFormButton">Ajout d'un matériel</button>
    <!-- Formulaire d'ajout de matériel, initialement caché -->
    <form id="ajoutMaterielForm" action="../Utils/insert.php" method="post" style="display: none;">
        <!-- Champs du formulaire correspondant à la structure de la table 'Materiel' -->
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="text" name="service" placeholder="Service" required>
        <input type="text" name="type_materiel" placeholder="Type de matériel" required> <!-- Correction -->
        <input type="text" name="description_materiel" placeholder="Description" required> <!-- Correction -->
        <input type="text" name="emplacement_materiel" placeholder="Emplacement" required> <!-- Correction -->
        <input type="number" name="annee_materiel" placeholder="Année UC"> <!-- Correction -->
        <input type="submit" value="Ajouter">
    </form>
    <!-- Formulaire de recherche -->
    <form action="../Views/parcView.php" method="post">
        <input type="text" id="search" name="search" placeholder="Rechercher par nom...">
        <input type="submit" value="Recherche">
    </form>
    <!-- Affichage des messages d'erreur, le cas échéant -->
    <?php
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']);
    }
    ?>
    <!-- Tableau pour afficher les données du matériel -->
    <table>
        <thead>
            <!-- En-têtes du tableau -->
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Service</th>
                <th>Type de matériel</th>
                <th>Description</th>
                <th>Emplacement</th>
                <th>Année UC</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Boucle pour remplir le tableau avec les données du matériel -->
            <?php foreach ($materielData as $row) : ?>
                <tr>
                    <!-- Affichage des données de chaque matériel -->
                    <td><?= isset($row['nom_utilisateur']) ? htmlspecialchars($row['nom_utilisateur']) : '' ?></td>
                    <td><?= isset($row['prenom_utilisateur']) ? htmlspecialchars($row['prenom_utilisateur']) : '' ?></td>
                    <td><?= isset($row['service_utilisateur']) ? htmlspecialchars($row['service_utilisateur']) : '' ?></td>
                    <td><?= isset($row['type_materiel']) ? htmlspecialchars($row['type_materiel']) : '' ?></td> <!-- Correction -->
                    <td><?= isset($row['description_materiel']) ? htmlspecialchars($row['description_materiel']) : '' ?></td> <!-- Correction -->
                    <td><?= isset($row['emplacement_materiel']) ? htmlspecialchars($row['emplacement_materiel']) : '' ?></td> <!-- Correction -->
                    <td><?= isset($row['annee_materiel']) ? htmlspecialchars($row['annee_materiel']) : '' ?></td> <!-- Correction -->
                    <td>
                        <!-- Liens pour modifier et supprimer le matériel -->
                        <a href='../Utils/update.php?id_materiel=<?= $row['id_materiel'] ?>'>Modifier</a> |
                        <a href='../Utils/delete.php?id_materiel=<?= $row['id_materiel'] ?>' onclick='return confirm("Confirmez la suppression");'>Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Script JavaScript pour gérer l'affichage du formulaire d'ajout de matériel -->
    <script>
        document.getElementById('showFormButton').addEventListener('click', function() {
            var form = document.getElementById('ajoutMaterielForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>

</html>
