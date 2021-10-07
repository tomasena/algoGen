<?PHP
class Individu{
    public const COTE = 4; // nb de bits pour representer la cote
    public const DIFF = 4;   
    public static float $intervalCote = (6.0 - 1.0) / 2**self::COTE ; 
    public static float $intervalDiff = (4.0) / 2**self::DIFF ;

    private int $id;
    private int $unXdeux;
    private int $cote;
    private int $diff;
    private String $chromo;  // chromosome binaire

    // valeurs réels
    private String $valUnXdeux;
    private float $valCote;  // entre 1.0 et 6.0    
    private float $valDiff;  // entre -2.0 et 2.0
    private int $ng;         // numero generation

    private float $gain;  // initialisés par l'appel à eval de Data
    private int $nbGagnes;
    private int $nbPerdus;


    public function __construct(){  
        $ctp = func_num_args();
        $args = func_get_args();
        if ($ctp == 1)
            $this->construct0($args[0]);
        else
            $this->construct1($args[0],$args[1]);
    }
    private function construct0(int $ng){
        $this->unXdeux= $this->gen(2);  // trois posibles valeurs : 0, 1, 2
        $this->valUnXdeux =  ($this->unXdeux == 0) ? "H" : (($this->unXdeux == 1) ? "D" : "A");
        $this->cote=$this->gen(2**self::COTE-1);
        $this->diff=$this->gen(2**self::DIFF-1);
        $this->chromo= substr(
                        decbin(                  2**(2+self::COTE+self::DIFF) + // 1 au depart, pour forcer presence des 0s
                                $this->unXdeux * 2**(self::COTE+self::DIFF)  + 
                                $this->cote *    2**self::DIFF  +  //0b100000000  +  
                                $this->diff),
                                1, (2+self::COTE+self::DIFF) )  ;  // on retire le premier 1
        
        $this->valCote= (self::$intervalCote) * $this->cote + 1.0;
        $this->valDiff= (self::$intervalDiff) * $this->diff - 2.0;
        $this->ng = $ng;
    }
    private function construct1(String $chromo, int $ng){
        $this->chromo = $chromo;
        $this->unXdeux= bindec(substr($chromo,0,2));   // trois posibles valeurs : 0, 1, 2
        $this->valUnXdeux =  ($this->unXdeux == 0) ? "H" : (($this->unXdeux == 1) ? "D" : "A");
        $this->cote= bindec(substr($chromo,2,self::COTE)) ;
        $this->diff= bindec(substr($chromo,self::COTE+2,self::DIFF));
       
        $this->valCote= (self::$intervalCote) * $this->cote + 1.0;
        $this->valDiff= (self::$intervalDiff) * $this->diff - 2.0;
        $this->ng = $ng;
    }    
    public function reproduction(Individu $b) { // crossover entre $this et $b
        $cut = random_int(2,strlen($b->getChromo())-1); // coupes : 0 à ($cut-1) et $cut à length
        $a1 = substr($this->getChromo(),0,$cut);
        $b1 = substr($b->getChromo(),0,$cut);
        $a2 = substr($this->getChromo(),$cut,strlen($this->getChromo()));
        $b2 = substr($b->getChromo(),$cut,strlen($b->getChromo()));
        //echo "new Individu($a1 . $b2 <br>";
        //echo "new Individu($b1 . $a2 <br>";
        $a1b2 = new Individu($a1 . $b2, $this->ng+1);
        $b1a2 = new Individu($b1 . $a2, $this->ng+1);
        return array($a1b2,$b1a2);
    }
    public function mute(){
        $chromo = $this->getChromo();
        //echo "mute : $chromo";
        do {
            $nBit = random_int(0,strlen($chromo)-1);
            $bit = substr($chromo,$nBit,1);
            $bit = ($bit == "1") ? "0" : "1";
            $chromoNew = substr_replace($chromo, $bit, $nBit, 1); 
            } while (substr($chromoNew,0,2) == "11");
        //echo "$chromo -> $chromoNew <br>";
        return new Individu($chromoNew, $this->ng+1);
    }
    public function gen(int $max){ //entier aleatoire entre 0 et $max
        return random_int(0, $max);
    }
    public function getChromo(){
        return $this->chromo;
    }
    public function getUnXdeux(){
        return $this->unXdeux;
    }
    public function getCote(){
        return $this->cote;
    }
    public function getDiff(){
        return $this->diff;
    }
    public function getValUnXdeux(){
        return $this->valUnXdeux;
    }
    public function getValCote(){
        return $this->valCote;
    }
    public function getValDiff(){
        return $this->valDiff;
    }
    public function getNg(){
        return $this->ng;
    }
    public function getGain(){
        return $this->gain;
    }
    public function getNbGagnes(){
        return $this->nbGagnes;
    }
    public function getNbPerdus(){
        return $this->nbPerdus;
    }
    public function setGain(float $gain){
        $this->gain = $gain;
    }
    public function setNbGagnes(int $nbGagnes){
        $this->nbGagnes = $nbGagnes;
    }
    public function setNbPerdus(int $nbPerdus){
        $this->nbPerdus = $nbPerdus;
    }
}

