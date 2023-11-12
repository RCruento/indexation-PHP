<?php

    // Fonction de connexion à la base de données
    function connexionBD(){
        $conn = mysqli_connect("localhost", "root", "", "indexation"); // Connexion à la base de données MySQL
        return $conn;
    }

    // Chargement du dictionnaire
    $TabMotsVides = file('assets/dictionnaire.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    // Fonction pour extraire le corps d'une page HTML en utilisant un modèle regex
    function getBody($modele, $chaine_html){
        preg_match($modele, $chaine_html, $tableau_res); // Recherche du modèle dans la chaîne HTML

        if($tableau_res[1]) {
            return $tableau_res[1]; // Si une correspondance est trouvée, renvoyer le résultat
        } else {
            return ""; // Sinon, renvoyer une chaîne vide
        }
    }

    
    // Fonction pour diviser une chaîne en mots en filtrant les mots vides et courts
    function traitementElement($separateurs, $chaine){
        global $TabMotsVides; // Accès à la variable $TabMotsVides définie précédemment
        
        $tab = array(); // Initialisation d'un tableau pour stocker les mots valides
        $tok = strtok($chaine, $separateurs); // Découpe la chaîne en utilisant les séparateurs

        if (strlen($tok) > 2) {
            $tab[] = $tok; // Ajoute le premier mot s'il a plus de 2 caractères
        }

        while ($tok !== false) {
            $tok = strtok($separateurs);
            if (strlen($tok) > 2 && !in_array($tok, $TabMotsVides)) {
                $tab[] = $tok; // Ajoute les mots valides au tableau
            }
        }
        return $tab; // Renvoie le tableau de mots valides
    }

    // Fonction pour attribuer des poids aux mots en fonction de leur occurrence
    function poids($tabl_occurrences, $coeficient){
        $tabl_poids = array(); // Initialisation d'un tableau pour les poids
        
        foreach ($tabl_occurrences as $mot => $occurrence){
            $poid = $occurrence * $coeficient; // Calcule le poids
            $tabl_poids[$mot] = $poid; // Stocke le mot et son poids correspondant
        }
        return $tabl_poids; // Renvoie le tableau des poids
    }

    function getDescription($source){
        $table_metas = get_meta_tags($source); // Récupère les balises meta de la page
        
        if(isset($table_metas['description'])){
            return $table_metas['description']; // Si la balise "description" existe, la renvoyer
        } else {
            return ""; // Sinon, renvoyer une chaîne vide
        }
    }


    function getKeywords($source){
        $table_metas = get_meta_tags($source); // Récupère les balises meta de la page

        if (isset($table_metas['keywords'])){
            return $table_metas['keywords']; // Si la balise "keywords" existe, la renvoyer
        } else {
            return ""; // Sinon, renvoyer une chaîne vide
        }
    }

    function getTitle($modele, $chaine){
        preg_match($modele, $chaine, $tableau_res); // Recherche du modèle dans la chaîne HTML

        if ($tableau_res[1]) {
            return $tableau_res[1]; // Si une correspondance est trouvée, renvoyer le résultat
        } else {
            return ""; // Sinon, renvoyer une chaîne vide
        }
    }

    // Fonction pour supprimer les accents des caractères d'une chaîne
    function Unaccent($txt) {
        $transliterator = Transliterator::createFromRules(':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', Transliterator::FORWARD);
        return $transliterator->transliterate($txt); // Supprime les accents et renvoie la chaîne sans accents
    }
?>
