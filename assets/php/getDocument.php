<?php

// Connexion 
$bdd = mysqli_connect('localhost', 'root', '', 'tiw');
if (!$bdd) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

//Recherche
if (isset($_GET['Rmot']) && !empty($_GET['Rmot'])) {
    $documentId = mysqli_real_escape_string($bdd, $_GET['Rmot']); // Évite les attaques par injection SQL

    $query = "SELECT m.mot AS text, md.poids AS size
                  FROM mot m
                  INNER JOIN mot_document md ON m.id = md.id_mot
                  INNER JOIN document d ON md.id_document = d.id
                  WHERE d.id = '$documentId' AND m.mot IS NOT NULL";

    $docs = mysqli_query($bdd, $query);

    $resultat = array(); //Tab Résultats
    if ($docs) {
        if (mysqli_num_rows($docs) > 0) {
            while ($row = mysqli_fetch_assoc($docs)) {
                $row["text"] = str_replace("’", "", $row["text"]);
                $resultat[] = array('text' => $row["text"], 'size' => (int)$row["size"]);
            }
        } else {
            $resultat['error'] = 'Aucun résultat trouvé.';
        }
    } else {
        $resultat['error'] = 'Erreur dans la requête SQL : ' . mysqli_error($bdd);
    }

    // Affichage JSON
    echo json_encode($resultat);
} else {
    // si le mot recherché n'est pas valide
    echo json_encode(array('error' => 'Paramètre "Rmot" manquant ou invalide.'));
}


mysqli_close($bdd);

?>
