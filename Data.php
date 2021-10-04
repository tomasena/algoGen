<?PHP
class Data{
    private array $data;
    /* exmple de match dans $data :
          0 => string '27/07/2021 17:00' (length=16)
          1 => string 'Champions League' (length=16)
          2 => int 1
          3 => int 3
          4 => string 'A' (length=1)
          5 => float 3.5
          6 => float 4.37
          7 => float -0.87
          8 => float 3.4
          9 => float 3.95
          10 => float -0.55
          11 => float 2.02
          12 => float 1.82
          13 => float 0.2
      */
    public function bonFormat($m){  // conventi au bon type $m
        $m[2] = (int) $m[2];
        $m[3] = (int) $m[3];
        for ($i=5;$i<14;$i++)
            $m[$i] = (float) $m[$i];
        return $m;
    }
    public function __construct($csv) {
        $file = fopen($csv, 'r');
        $i=0;
        while (!feof($file) && $i < 66000 ) {
            $this->data[] = $this->bonFormat(fgetcsv($file, 1024));
            $i++;
        }
        fclose($file);        
    }
   
    public function eval(Individu $ind){
        $gain = 0;
        $nbGagnes = 0;
        $nbPerdus = 0;
        $i = 2;
        $ip =  ($ind->getValUnXdeux() == "H") ? 6 : (($ind->getValUnXdeux() == "D") ? 9 : 12); // indice cote paris
        //echo "eval";    var_dump($ind);
        foreach ($this->data as $m) {  
            if (    abs($m[$ip] - $ind->getValCote()) <=  Individu::$intervalCote &&
                    abs($m[$ip+1] - $ind->getValDiff()) <=  Individu::$intervalDiff     ) // on pari
                if (    $m[4] == $ind->getValUnXdeux()  ) {    // on gagne
                    //echo "gange "; var_dump($m) ;
                    $gain += $m[$ip] - 1.0;
                    $nbGagnes++;
                }
                else {   // on perd
                    //echo "perd "; var_dump($m) ;
                    $gain -= 1.0;
                    $nbPerdus++;
                }
        }
        $ind->setGain($gain);
        $ind->setNbGagnes($nbGagnes);
        $ind->setNbPerdus($nbPerdus);

    }
}

