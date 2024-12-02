<?php 

class Comptes {
    private $idCompte;
    private $solde;


    public function __construct(int $id, float $solde)
    {
        $this->idCompte = $id;
        $this->solde = $solde;
    }

    public function virement(float $amount) {
        if($amount > $this->solde) {
            throw new Exception("solde insufisant !");
        }else {
            $this->solde -= $amount;
            req_new_solde($this->solde, $this->idCompte);
        }
    }

    public function get_virement(float $amount) {
        $this->solde += $amount;
        req_new_solde($this->solde, $this->idCompte);
    }
}