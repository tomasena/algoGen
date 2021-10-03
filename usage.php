<?PHP
declare(strict_types=1);

spl_autoload_register(function ($class_name) {
    require_once('./' . $class_name . '.php');
});
/*
// Définir le chemin d'accès au fichier CSV
$csv = '../donnees/data2.csv';
$gd = new GetData();
$tab = $gd->read($csv);

var_dump($tab);
*/
$ind = new Individu(); //individu aléatoire
var_dump($ind);
echo  $ind->getChromo() ;

