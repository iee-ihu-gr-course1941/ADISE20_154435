<?php

Class Pawn{

    const BLACK_PAWN = "Black";
    const WHITE_PAWN = "White";



    private $color;

    public function __construct($color){
        $this->setColorPawn($color);
    }


    public function getColorPawn(){
        return $this->color;
    }

    public function setColorPawn($color){
        $this->color=$color;
    }
}