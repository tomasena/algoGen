<?PHP
declare(strict_types=1);

spl_autoload_register(function ($class_name) {
    require_once('./' . $class_name . '.php');
});

// Chemin d'accès au fichier CSV
$data = new Data( '../donnees/data3.csv');
//var_dump($gd);

$ag = new AlgoGen($data); //individus aléatoires
$ag->nouGen();


/*
$timestart=time();
$data->eval($ind); 
//Fin du code PHP
$timeend=time();
$time=$timeend-$timestart; 
echo "Temps: ". $time;

var_dump($ind);
*/
