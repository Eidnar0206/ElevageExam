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
            return $fichier; // Return the file path on success
        } else {
            echo 'Echec de l\'upload !';
            return false; // Return false on failure
        }
    }

    public function resetData() {
        $pdo = $this->db;
        try {
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
            $pdo->exec("SET SESSION sql_mode = '';");
    
            $pdo->beginTransaction();
    
            $tables = [
                "elevage_imagesAnimaux",
                "elevage_morts",
                "elevage_Ventes",
                "elevage_achatAlimentation",
                "elevage_alimentation",
                "elevage_animaux",
                "elevage_espece",
                "elevage_capitalTransactions",
                "elevage_capital"
            ];
    
            foreach ($tables as $table) {
                $stmt = $pdo->prepare("DELETE FROM $table");
                $stmt->execute();
                // echo "Données supprimées de $table<br>";
            }
    
            $pdo->commit();
    
            foreach ($tables as $table) {
                $stmt = $pdo->prepare("ALTER TABLE $table AUTO_INCREMENT = 1");
                $stmt->execute();
            }
    
            $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    
            echo "Réinitialisation réussie !";
        } catch (Exception $e) {
            if ($pdo->inTransaction()) { 
                $pdo->rollBack();
            }
            echo "Erreur : " . $e->getMessage();
        }
    }    
}