<?PHP
declare(strict_types=1);

spl_autoload_register(function ($class_name) {
    require_once('./' . $class_name . '.php');
});

try{
   $db = new PDO('mysql:host=localhost;dbname=algogen;charset=utf8', 'root', '');
}
catch(Exception $e){
        die('Erreur fatal : '.$e->getMessage());
}

// Chemin d'accès au fichier CSV
$data = new Data( '../donnees/data3.csv');

$manager = new IndividuManager($db);

$ag = new AlgoGen($data,$manager); //individus aléatoires
//$ag->evolution();



/*
$timestart=time();
$data->eval($ind); 
//Fin du code PHP
$timeend=time();
$time=$timeend-$timestart; 
echo "Temps: ". $time;

var_dump($ind);
*/
