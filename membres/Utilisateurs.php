<?php

class Utilisateurs 
{
    private $erreurs=[],
            $id,
            $nom,
            $prenom,
            $tel,
            $mel;


    const NOM_INVALIDE = 1;
    const PRENOM_INVALIDE = 2;
    const MEL_INVALIDE = 3;

    public function __construct($donnees = []){
        if(!empty($donnees)){
            $this->hydrater($donnees);
        }
        
    }

    public function hydrater($donnees){
        foreach ($donnees as $attribut => $valeur){
            $methodeSetters = 'set'.ucfirst($attribut);
            $this->$methodeSetters($valeur);
        }
    }

    // setters

    public function setId($id){
        if(!empty($id)){
            $this->id = (int) $id;
        }
    }

    public function setNom($nom){
        if(!is_string($nom) || empty($nom)){
            $this->erreurs[] = self::NOM_INVALIDE;
        } else {
            $this->nom = $nom;
        }
    }

    public function setPrenom($prenom){
        if(!is_string($prenom) || empty($prenom)){
            $this->erreurs[] = self::PRENOM_INVALIDE;
        } else {
            $this->prenom = $prenom;
        }

    }

    public function setTel($tel){
        $this->tel = $tel;
    }

    public function setMel($mel){
        if(filter_var($mel, FILTER_VALIDATE_EMAIL)){
            $this->mel = $mel;
        } else {
            $this->erreurs[]= self::MEL_INVALIDE;
        }
    }
// getters

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getTel(){
        return $this->tel;
    }

    public function getMel(){
        return $this->mel;
    }

    public function getErreurs(){
        return $this->erreurs;
    }

    public function isUserValide(){
        return !(empty($this->nom) || empty($this->prenom) || empty($this->mel));
    }


}