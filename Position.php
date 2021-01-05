<?php

class Position{

    private $pawns = [];

    public function addPawn(Pawn $pawn){
        $this->pawns[] = $pawn;
    }

    public function removePawn(){
        return array_pop($this->pawns);
    }

    public function isInUse(){
        return $this->getNumberPawns() > 0;
    }

    public function inUseBy(){
        if($this->isInUse()){
            return $this->pawns[0]->getColorPawn();
        }
        else{
            return null;
        }
    }

    public function getNumberPawns(){
        return count($this->pieces);
    }



}