<?PHP
class Individu{
    private int $unXdeux;
    private int $cote;
    private int $diffCote;
    
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
     
        $this->unXdeux = $this->gen(2);  // trois posibles valeurs : 0, 1, 2
        $this->cote=$this->gen(8);
        $this->diffCote=$this->gen(8);

    }
    public function gen(int $max){ //entier aleatoire entre 0 et $max
        return random_int(0, $max);
    }
        
}

