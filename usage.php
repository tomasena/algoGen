<?PHP
declare(strict_types=1);

spl_autoload_register(function ($class_name) {
    require_once('./' . $class_name . '.php');
});

// Définir le chemin d'accès au fichier CSV
$csv = '../donnees/data1.csv';
$gd = new GetData();
$tab = $gd->read($csv);

var_dump($tab);

