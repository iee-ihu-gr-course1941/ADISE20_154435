<?php

class Board {

    private $points;

    public function getPoints(){
        return $this->points;
    }

    public function getPosition($index){
        return $this->points[$index];
    }

    public function setPosition($index, Position $position){
        $this->points[$index] = $position;
    }

}
