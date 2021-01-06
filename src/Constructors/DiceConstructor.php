<?php

class DiceConstructor{

    public function create($value){
        $dice = new Dice();
        $dice->setdiceUsed(false);
        $dice->setValue($value);

        return $dice;

    }

}
