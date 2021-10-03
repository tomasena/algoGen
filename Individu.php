<?PHP
class Individu{
    public const COTE = 4; // nb de bits pour representer la cote
    public const DIFF = 4;    

    private int $unXdeux;
    private int $cote;
    private int $diff;
    private String $chromo;

    // valeurs réels
    private String $valUnXdeux;
    private float $valCote;  // entre 1.0 et 6.0
    private float $intervalCote;
    private float $valDiff;  // entre -2.0 et 2.0
    private float $intervalDiff;


    public function __construct(){
        /* dans ttab :
         0 => string 'Date of the game' (length=16)
        1 => string 'Leagues' (length=7)
        2 => string 'Final Scores' (length=12)
        3 => string '' (length=0)
        4 => string '' (length=0)
        5 => string '1' (length=1)
        6 => string '1' (length=1)
        7 => string 'diff' (length=4)
        8 => string 'X' (length=1)
        9 => string 'X' (length=1)
        10 => string 'diff' (length=4)
        11 => string '2' (length=1)
        12 => string '2' (length=1)
        13 => string 'diff' (length=4)
        */
     
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
        $this->intervalCote = (6.0 - 1.0) / 2**self::COTE ;
        $this->valCote= ($this->intervalCote) * $this->cote + 1.0;
        $this->intervalDiff = (4.0) / 2**self::DIFF ;
        $this->valDiff= ($this->intervalDiff) * $this->diff - 2.0;
    }
    public function gen(int $max){ //entier aleatoire entre 0 et $max
        return random_int(0, $max);
    }
    public function getChromo(){
        return $this->chromo;
    }
        
}

