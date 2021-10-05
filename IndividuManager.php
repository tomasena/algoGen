<?php
class IndividuManager
{
  private PDO $db; // Instance de PDO

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function add(Individu $ind)
  {
    $q = $this->db->prepare(
        'INSERT INTO individu
            (unXdeux,cote,diff,chromo,valUnXdeux,valCote,valDiff,ng,gain,nbGagnes,nbPerdus)
     VALUES (:unXdeux,:cote,:diff,:chromo,:valUnXdeux,:valCote,:valDiff,:ng,:gain,:nbGagnes,:nbPerdus)');

    $q->execute(array(
        'unXdeux' => $ind->getUnXdeux(),
        'cote'=>  $ind->getCote(),
        'diff'=>  $ind->getDiff(),
        'diff'=> $ind->getDiff(),
        'chromo'=>  $ind->getChromo(),
        'valUnXdeux'=> $ind->getValUnXdeux(),
        'valCote'=>  $ind->getValCote(),
        'valDiff'=> $ind->getValDiff(),
        'ng'=> $ind->getNg(),
        'gain'=> $ind->getGain(),
        'nbGagnes'=>  $ind->getNbGagnes(),
        'nbPerdus'=>  $ind->getNbPerdus()
	));
  }
/*
  public function delete(Individu $perso)
  {
    $this->db->exec('DELETE FROM personnage WHERE id = '.$perso->id());
  }

  public function get(int $id)
  {
    $id = (int) $id;

    $q = $this->db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnage WHERE id = '.$id);
    $donnees = $q->fetch(PDO::FETCH_ASSOC);

    return new Individu($donnees);
  }

  public function getList()
  {
    $persos = [];

    $q = $this->db->query('SELECT id, nom, forcePerso, degats, niveau, experience FROM personnage ORDER BY nom');

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new Personnage($donnees);
    }

    return $persos;
  }

  public function update(Individu $perso)
  {
    $q = $this->db->prepare('UPDATE personnages SET forcePerso = :forcePerso, degats = :degats, niveau = :niveau, experience = :experience WHERE id = :id');

    $q->bindValue(':forcePerso', $perso->forcePerso(), PDO::PARAM_INT);
    $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
    $q->bindValue(':niveau', $perso->niveau(), PDO::PARAM_INT);
    $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);
    $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);

    $q->execute();
  }
*/
}