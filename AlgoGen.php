<?php

class AlgoGen {
    private array $population;
    private Data $data;
    private IndividuManager $im; 

    public const NB_INDIVIDUS = 100;
    public const NB_MUTATION = 2; // parmi la population
    public const NB_GENERATIONS = 15;

    public function __construct(Data $data, IndividuManager $im)   {
        $this->data = $data;
        $this->im = $im;
        // population aléatoire
        for ($i=0;$i<self::NB_INDIVIDUS;$i++) {
            $ind = new Individu(0);
            $data->eval($ind); 
            //$im->add($ind);
            $this->population[] = $ind;
        }
        usort($this->population, "self::cmp");
        //var_dump( $this->population );
    }
    static function cmp(Individu $a, Individu $b)    {
        return ($a->getGain() < $b->getGain()) ? +1 : -1;
    }
    public function estRepete(Individu $ind){
        for ($i=0;$i<self::NB_INDIVIDUS;$i++) {
            if ($ind->getChromo() == $this->population[$i]->getChromo())
                return true;
        }
        return false;

    }
    public function crossover(){
        // crossover
        $a=0;
        $limite = self::NB_INDIVIDUS/2 ;
        $n = self::NB_INDIVIDUS-1;
        $nb = range(0, $limite);
        shuffle($nb);
        //var_dump($nb);
        for ($i=0;$i<$limite;$i=$i+2) { // slectionner $a et $b
            $a = $nb[$i];
            $b = $nb[$i+1];
            // reproduction
            if (($this->population[$a])->getChromo() !=  ($this->population[$b])->getChromo()) { // sont differents
                $fils = ($this->population[$a])->reproduction($this->population[$b]); // tab dux fils
                //var_dump($fils);
                $ab = $fils[0]; $ba = $fils[1];
                if (!$this->estRepete($ab)){
                    $this->data->eval($ab);
                    //$this->im->add($ab);
                    $this->population[$n--] = $ab;
                }
                if (!$this->estRepete($ba)){
                    $this->data->eval($ba);
                    // $this->im->add($ba);
                    $this->population[$n--] = $ba;
                } 
            }
        }
        //var_dump( $this->population );
    }
    public function mutation(){
        for ($i=0;$i<self::NB_MUTATION;$i++){
            $k = random_int(0,self::NB_INDIVIDUS-1);
            $ind = $this->population[$k]; 
            $nouveau = $ind->mute();
            if (!$this->estRepete($nouveau)){
                $this->data->eval($nouveau);
                //$this->im->add($nouveau);
                $this->population[$k] = $nouveau;
                }
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
        var_dump($this->population);
        $this->im->addList($this->population);
        

    }
}