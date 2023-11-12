<?php
    include_once "assets/php/fonction.php";
    include_once "assets/php/traitement.php";

    // Connexion à la base de données
    $conn = connexionBD();

    
    session_start();

    // Vérification de la connexion
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); // Redirect to the login page
        exit();
    }

    // Bouton d'indexation
    if(isset($_POST["add"]))
{
		$dossier = $_POST["rep"];
		PDL($dossier);
	
}

    // Bouton de suppression (Nettoyer la BDD)
    if (isset($_POST["delete"])) {
        // Supprimer les données de la base de données
        $sql2 = "DELETE FROM `document`";
        mysqli_query($conn, $sql2);
        $sql3 = "DELETE FROM `mot_document`";
        mysqli_query($conn, $sql3);
        $sql1 = "DELETE FROM `mot`";
        mysqli_query($conn, $sql1);
        
    }

    // Historique de données
    $historique = array();
    $sql = "SELECT id, source, titre, date FROM document";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $historique[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>index</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Drag-Drop-File-Input-Upload.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-icons.css">
</head>

<body>
    <nav class="navbar navbar-expand-md bg-body py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span><strong><em>Rayan KOUSSA</em></strong>
                </span>
            </a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-2">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php"><strong>Indexation</strong></a></li>
                    <li class="nav-item"><a class="nav-link" href="recherche.php"><strong>Recherche</strong></a></li>
                </ul>
                <a class="btn btn-primary ms-md-2" href="logout.php" role="button">Logout</a>

            </div>
        </div>
    </nav>
    <div class="text-center">
        <h1>Indexation</h1>
        <p class="text-center">
            <em>Bienvenue sur la page d'indexation.</em>
            <br>
            <em>Veuillez sélectionner le dossier que vous souhaitez indexer dans la base de données.</em>
        </p>
    </div>
    <div class="text-center">
    <div class="container">


<form action="" method="post" enctype="multipart/form-data">
    
    <input type="text" class="form-control" name="rep" id="rep"><br>
	<input type="submit"  class="btn btn-primary btn-block"value="Indexation" name="add" /><br>
	<input type="submit"  class="btn btn-primary btn-block"value="Supprimer Indexation" name="delete" />
</form>
</div>
    </div>
    <div class="text-center">
        <p class="text-center">
            <em>Historique d'indexation</em>
        </p>
        <div id="tabhis">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Fichiers indexés</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Date</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($historique)) : ?>
                    <?php foreach ($historique as $entry) : ?>
                        <tr>
                            <td>
                                <a href="<?php echo $entry['source']; ?>" target="_blank">
                                    <?php echo $entry['source']; ?>
                                </a>
                            </td>
                            <td><?php echo $entry['titre']; ?></td>
                            <td><?php echo $entry['date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="3">Aucun élément dans l'historique.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </table>
        </div>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
