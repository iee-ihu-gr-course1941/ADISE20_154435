<?php

class MovementConstructor{

    public function create($firstPosition, $numberOfPoints){

        $move = new Movement();
        $move->setStartingPosition($firstPosition);
        //$move->setNumberOfPoints($numberOfPoints);    To check if neccessary
        return $move;
        }
}
