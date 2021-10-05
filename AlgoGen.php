<?php

class AlgoGen {
    private array $population;
    private Data $data;
    private IndividuManager $im; 

    public const NB_INDIVIDUS = 140;
    public const NB_MUTATION = 3; // parmi la population
    public const NB_GENERATIONS = 25;

    public function __construct(Data $data, IndividuManager $im)   {
        $this->data = $data;
        $this->im = $im;
        // population aléatoire
        for ($i=0;$i<self::NB_INDIVIDUS;$i++) {
            $ind = new Individu(0);
            $data->eval($ind); 
            $im->add($ind);
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
        $limite = self::NB_INDIVIDUS/2 ;
        $n = $limite+1;
        $nb = range(0, $limite);
        shuffle($nb);
        //var_dump($nb);
        for ($i=0;$i<$limite;$i=$i+2) { // slectionner $a et $b
            $a = $nb[$i];
            $b = $nb[$i+1];
            // reproduction
            $fils = ($this->population[$a])->reproduction($this->population[$b]); // tab dux fils
            //var_dump($fils);
            $ab = $fils[0]; $ba = $fils[1];
            $this->data->eval($ab);  $this->data->eval($ba);
            $this->im->add($ab);  $this->im->add($ba);
            $this->population[$n++] = $ab;
            $this->population[$n++] = $ba;
            // echo "a $a b $b <br>";
        }
        //var_dump( $this->population );
    }
    public function mutation(){
        for ($i=0;$i<self::NB_MUTATION;$i++){
            $k = random_int(0,self::NB_INDIVIDUS-1);
            $ind = $this->population[$k]; 
            $nouveau = $ind->mute();
            $this->data->eval($nouveau);
            //$this->im->add($nouveau);
            $this->population[$k] = $nouveau;
        }
        usort($this->population, "self::cmp");
        //var_dump( $this->population );
    }
    public function supprimeDoublons(){
        $tab = array('world','hello','good','planet');
        $element = 'hello';
        unset($tab[array_search($element, $tab)]);

        print_r($tab);

        // affiche
        // Array ( [0] => world [2] => good [3] => planet )

        sort($tab); // Trie un tableau

        print_r($tab);
        // Affiche
        // Array ( [0] => good [1] => planet [2] => world )
    }

    public function evolution(){
        for ($i=0;$i<self::NB_GENERATIONS;$i++){
            $this->supprimeDoublons();
            $this->crossover();
            $this->mutation();
            echo "géneration $i : "; var_dump($this->population[0]);
            }
        var_dump($this->population);
        

    }
}