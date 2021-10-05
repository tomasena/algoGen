<?php

class AlgoGen {
    private array $population;
    private Data $data;
    public const NB_INDIVIDUS = 100;
    public const NB_MUTATION = 2; // parmi la population
    public const NB_GENERATIONS = 10;

    public function __construct(Data $data)   {
        $this->data = $data;
        // population aléatoire
        for ($i=0;$i<self::NB_INDIVIDUS;$i++) {
            $ind = new Individu();
            $data->eval($ind); 
            $this->population[] = $ind;
        }
        usort($this->population, "self::cmp");
        //var_dump( $this->population );
    }
    static function cmp(Individu $a, Individu $b)    {
        return ($a->getGain() < $b->getGain()) ? +1 : -1;
    }
    public function crossover(){
        // crossover
        $a=0;
        $limite = self::NB_INDIVIDUS/2 - 1;
        $n = $limite+1;
        $estOccupe[$limite] = false;
        while ($a<$limite-1){ // slectionner $a et $b
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
        // usort($this->population, "self::cmp"); // on le fait après mutation
        //var_dump( $this->population );
    }
    public function mutation(){
        for ($i=0;$i<self::NB_MUTATION;$i++){
            $k = random_int(0,self::NB_INDIVIDUS-1);
            $ind = $this->population[$k]; 
            $nouveau = $ind->mute();
            $this->data->eval($nouveau);
            $this->population[$k] = $nouveau;
        }
        usort($this->population, "self::cmp");
        //var_dump( $this->population );
    }

    public function evolution(){
        for ($i=0;$i<self::NB_GENERATIONS;$i++){
            $this->crossover();
            $this->mutation();
            echo "géneration $i : "; var_dump($this->population[0]);
            }


    }
}