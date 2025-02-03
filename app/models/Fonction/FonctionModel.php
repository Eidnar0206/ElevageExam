<?php

namespace app\models\Fonction;
use \Exception;
class FonctionModel
{
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    
    function fileName($file)
    {
        $fichier = explode(".", $file['name']);
        $date = time();
        $rep = $fichier[0] . $date . "." . $fichier[1];
        echo $rep;
        return $rep;
    }

    public function upload($file, $dossier)
    {
        $dossier = "public/assets/img/"."$dossier/";
        $fichier = $this->fileName($file);
        $extensions = ['.png', '.gif', '.jpg', '.jpeg', '.PNG', '.GIF', '.JPG', '.JPEG'];
        $extension = strrchr($file['name'], '.');

        // Validate the file extension
        if (!in_array($extension, $extensions)) {
            $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
            echo $erreur;
            return false; // Return false to indicate failure
        }

        // Format the file name
        $fichier = strtr($fichier,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
        $fullPath = $dossier . $fichier;

        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $fullPath)) {
            echo 'Upload effectué avec succès !';
            return $fullPath; // Return the file path on success
        } else {
            echo 'Echec de l\'upload !';
            return false; // Return false on failure
        }
    }


}