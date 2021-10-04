<?php

class AlgoGen {
    private array $population;
    private Data $data;
    public const NB_INDIVIDUS = 8;

    public function __construct(Data $data)   {
        $this->data = $data;
        // population aléatoire
        for ($i=0;$i<self::NB_INDIVIDUS;$i++) {
            $ind = new Individu();
            $data->eval($ind); 
            $this->population[] = $ind;
        }
        usort($this->population, "self::cmp");
        var_dump( $this->population );
    }
    static function cmp(Individu $a, Individu $b)    {
        return ($a->getGain() < $b->getGain()) ? +1 : -1;
    }
    public function nouGen(){
        // crossover
        $a=0;
        $limite = self::NB_INDIVIDUS/2 - 1;
        $n = $limite+1;
        $estOccupe[$limite] = false;
        while ($a<$limite){ // slectionner $a et $b
            do {$b = random_int($a+1,$limite); } while (isset($estOccupe[$b]) && $estOccupe[$b]);
            $estOccupe[$a] = true;
            $estOccupe[$b] = true;
            // reproduction
            $fils = ($this->population[$a])->reproduction($this->population[$b]); // tab dux fils
            //var_dump($fils);
            $ab = $fils[0]; $ba = $fils[1];
            $this->data->eval($ab);  $this->data->eval($ba);
            $this->population[$n++] = $ab;
            $this->population[$n++] = $ba;

            do $a++; while ($a<$limite && isset($estOccupe[$a]) && $estOccupe[$a]);
        }
        usort($this->population, "self::cmp");
        var_dump( $this->population );
    }


    
}