<?php

class Dice{
    private $inuse;

    private $value;

    public function diceUsed(){
        return $this->inuse;
    }

    public function setdiceUsed($inuse){
        $this->inuse = $inuse;
    }

    public function getdiceUsed(){
        return $this->value;
    }

    public function getValue(){
        return $this->value;
    }

    public function setValue($value){
        $this->value = $value;
    }

}