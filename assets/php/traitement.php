<?php
require_once 'assets/php/fonction.php';

//Parcours dossier et lecture
function PDL($dossier)
{
    if (is_dir($dossier)) {
        $dir = opendir($dossier); // Ouvre le répertoire
        if ($dir) {
            while (false !== ($file = readdir($dir))) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($source = str_replace('/', DIRECTORY_SEPARATOR, $dossier) . DIRECTORY_SEPARATOR . $file)) {
                    PDL($source); // Si c'est un sous-dossier, appelez récursivement la fonction
                } else {
                    if (strpos($source, '.htm') !== false) { // Vérifiez l'extension du fichier
                        
                        traitement($source);
                    }
                }
            }
            closedir($dir); // Ferme le répertoire
        } else {
            echo "Impossible d'ouvrir le répertoire : $dossier";
        }
    } else {
        echo "Répertoire introuvable : $dossier";
    }
}

function traitement($source)
{

    //nettoyage du html

        // lEspace
        $html = implode(' ', file($source));

        // CSS
        $html = preg_replace('/<style>.*?<\/style>/is', '', $html);
        $html = preg_replace('/<[^>]+ style="[^"]*"/', '', $html);

        //JS
        $htmlSScript = preg_replace("/<script[^>]*?>.*?<\/script>/is", "", $html);

        

    //fin du nettoyage

    $separateurs = ",.;\'()/\n/\S/\t/\r 0123456789€\?\!:{}_\"";


    //Traitement Head

        // recouperation du descriptif
        $description = getDescription($source);

        // recuperation des keywords
        $keywords = getKeywords($source);

        // recuperation du title
        $btitre = "/<title>(.*)<\/title>/i";
        $title = getTitle($btitre, $html);

        //head sans rien
        $head = strtolower($title . " " . $description . " " . $keywords);

        // segmentation du texte en mots
        $tab_mots_head = traitementElement($separateurs, $head);

        //filtrage de doublons et obtention de nombre d'occurrences
        $tabOccuHead = array_count_values($tab_mots_head);

    //Traitement Body

        //recupération du body du corps du document
        $modele = "/<body[^>]*>(.*)<\/body>/is";
        $htmlBody = getBody($modele, $html);



        //suppression de balises html du body -> body en texte brute
        $body = strip_tags($htmlSScript);

        //minuscule 
        $body = strtolower($body);

        // segmentation du texte en mots

        $tabBody = traitementElement($separateurs, $body);


        //filtrage de doublons et obtention de nombre d'occurrences
        $tabOccuBody = array_count_values($tabBody);

        //Poids
        $tabMotsPHead = poids($tabOccuHead, 2);
        $tabMotsPBody = poids($tabOccuBody, 1);
        //Fusionner Head et Body
        foreach ($tabMotsPHead as $mot => $occurrence) {

            if (array_key_exists($mot, $tabMotsPBody)) {
                $OldOccu = $tabMotsPBody[$mot];
                $NvOccu = $occurrence + $OldOccu;
                $tabMotsPBody[$mot] = $NvOccu;
            } else
                $tabMotsPBody = array_merge($tabMotsPBody, array($mot => $occurrence));
        }

    //BDD 
        //Connexion
        $bdd = connexionBD();
        $source = mysqli_real_escape_string($bdd, $source);
        $title = Unaccent($title);
        $description = Unaccent($description);
        // insertion source dans la table document
        $sql = "INSERT INTO document (source,titre,description) VALUES('$source','$title','$description')";
        mysqli_query($bdd, $sql);
        $id_document = mysqli_insert_id($bdd);


        //Insertion des Mots
        foreach ($tabMotsPBody as $mot => $poids) {
            $mot = Unaccent($mot);
            // insertion mot dans la table mot	
            $sql3 = "INSERT INTO mot (mot) VALUES ('$mot')";
            mysqli_query($bdd, $sql3);
            $id_mot = mysqli_insert_id($bdd);  //recuperation de la derniere ID
            //}

            // mise relation ID_mot avec id_document et le poids
            $sql4 = "INSERT INTO mot_document (id_mot,id_document,poids) VALUES ($id_mot,$id_document,$poids)";
            mysqli_query($bdd, $sql4);
        }
}
