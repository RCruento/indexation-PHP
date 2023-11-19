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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.7/d3.layout.cloud.min.js"></script>
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
                $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
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
                        
                        echo "<button class='button' id='$id' value='$id'>Cliquer ici pour afficher le nuage de mots-clés</button>";
                        // Container for the word cloud
                        echo "<div id='wordCloudContainer_$id' style='display:none;'></div>";
                    }
                } else {
                    echo "<h3 style='color: blue;'>Aucune correspondance</h3>";
                }
            }
            ?>

            <!-- JavaScript pour afficher le nuage de mots-clés -->
            <script>
                function displayWordCloud(documentId) {
                    var containerId = 'wordCloudContainer_' + documentId;
                    var container = $('#' + containerId);

                    // If the container is visible, hide it
                    if (container.is(':visible')) {
                        container.empty(); // Clear the content
                        container.hide();
                        return;
                    }

                    $.ajax({
                        type: 'GET',
                        url: 'assets/php/getDocument.php',
                        data: { Rmot: documentId },
                        success: function(data) {
                            var words = JSON.parse(data);

                            var width = 500; // Adjust according to your layout
                            var height = 500; // Adjust according to your layout

                            var layout = d3.layout.cloud().size([width, height])
                                .words(words)
                                .padding(5)
                                .rotate(function() { return ~~(Math.random() * 2) * 90; })
                                .font("Impact")
                                .fontSize(function(d) { return d.size; })
                                .on("end", draw);

                            function draw(words) {
                                // Replace this with your actual rendering logic
                                var svg = d3.select('#' + containerId)
                                    .append("svg")
                                    .attr("width", width)
                                    .attr("height", height)
                                    .append("g")
                                    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

                                svg.selectAll("text")
                                    .data(words)
                                    .enter().append("text")
                                    .style("font-size", function(d) { return d.size + "px"; })
                                    .style("font-family", "Impact")
                                    .style("fill", function(d, i) { return d3.schemeCategory10[i % 10]; })
                                    .attr("text-anchor", "middle")
                                    .attr("transform", function(d) {
                                        return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                                    })
                                    .text(function(d) { return d.text; });
                            }

                            layout.start();
                            container.show();
                        },
                        error: function() {
                            console.error('Error fetching word cloud data.');
                        }
                    });
                }

                $(document).on('click', '.button', function() {
                    var documentId = $(this).attr('id');
                    displayWordCloud(documentId);
                });
            </script>
        </div>
    </div>

    <!-- Inclusion du fichier JavaScript Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
