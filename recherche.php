<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Recherche</title>
    <!-- Inclusion de fichiers CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Drag-Drop-File-Input-Upload.css">
    <link rel="stylesheet" href="assets/css/Navbar-Right-Links-icons.css">
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-md bg-body py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#"><span><strong><em>Rayan KOUSSA</em></strong></span></a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-2">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php"><strong>Indexation</strong></a></li>
                    <li class="nav-item"><a class="nav-link" href="recherche.php"><strong>Recherche</strong></a></li>
                </ul>
                
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="text-center">
        <h1>Recherche</h1>
        <p class="text-center">
            <em>Bienvenue sur la page de recherche.</em>
            <br>
            <em>Veuillez taper un mot pour chercher les documents correspondants.</em>
        </p>
    </div>
    
    <div class="container pb-5 pt-5">
        <div class="col-md-9 col-xl-8 ml-auto mr-auto">
            <form method="post" action="recherche.php">
                <div class="align-items-center form-row">
                    <div class="col-sm form-group mb-3">
                        <input class="form-control form-control ps-4 pe-4 rounded-pill" type="text" name="search" placeholder="mot clé">
                    </div>
                    <div class="col-sm-auto text-end form-group mb-3">
                        <button class="btn btn-primary ps-4 pe-4 rounded-pill" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            <!-- PHP : Traitement des résultats de la recherche -->
            <?php
            $conn = mysqli_connect('localhost', 'root', '', 'indexation');
            if (isset($_POST['search'])) {
                $searchTerm = mysqli_real_escape_string($conn, $_POST['search']); // Évite les attaques par injection SQL
                $sql = "SELECT document.id as id, document.source as doc,
                        document.titre as titre,
                        document.description as descrip,
                        mot_document.poids as poid
                        FROM mot_document
                        JOIN document ON mot_document.id_document = document.id
                        JOIN mot ON mot_document.id_mot = mot.id
                        WHERE mot.mot = '$searchTerm'";
                $result = mysqli_query($conn, $sql);
                echo "Résultats pour <b> $searchTerm </b>...<br><br>";
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<h3 style='color:blue;'>" . $row["titre"] . "</h3>";
                        echo "<font color='green'>" . $row["doc"] . "</font><br>";
                        $id = $row['id'];
                        echo "" . $row["descrip"] . "<br>";
                        echo "<font color='red'>Poids = " . $row["poid"] . "</font><br>";
                        //echo "<button class='button' id='$id' value='$id'>Cliquer ici pour afficher le nuage de mots-clés</button>";
                    }
                }else{
                    echo "<h3 style='color: blue;'>Aucune correspondance</h3>";
                }
            }
            ?>

            <!-- JavaScript pour afficher le nuage de mots-clés -->
            <!--
            <div class="col-sm-6">
                <script type="text/javascript">
                    $(".button").click(function () {
                        var id = $(this).attr('id');
                        $.getJSON("getDocument.php?Rmot=" + id, function (data) {
                            d3.wordcloud()
                                .size([550, 300])
                                .selector('#wordcloud')
                                .words(data)
                                .start();
                        });
                    });
                </script>
                <div id="wordcloud"></div>
            </div>
                -->
        </div>
    </div>
    <!-- Inclusion du fichier JavaScript Bootstrap -->
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
