<?php

class GameOperator
{

    private $boardOperator;

    private $diceConstructor;
    private $movementConstructor;
    private $dice;
    private $turn;

    private $players;

    public function __construct(BoardOperator $boardOperator, DiceConstructor $diceConstructor, MovementConstructor $movementConstructor){

        $this->boardOperator = $boardOperator;
        $this->diceConstructor = $diceConstructor;
        $this->movementConstructor = $movementConstructor;
        $this->players = [Pawn::BLACK_PAWN, Pawn::WHITE_PAWN];
    }

    public function startNewGame(){
        $this->boardOperator->setNewRound();
        $this->turn = $this->players[rand(0, (count($this->players) - 1))];
        $this->roll();
    }

    public function getTurn(){
        return $this->turn;
    }

    public function getDice(){
        return $this->dice;
    }

    private function roll(){
        $this->dice = [];

        $values = [
            rand(1,6),
            rand(1,6)
        ];
        if($values[0]=$values[1]){      //Periptosi diplis zarias
            $values[]=$values[0];
            $values[]=$values[0];
        }

        foreach($values as $v){
            $this->dice[] = $this->diceConstructor->create($v);
        }

        if(count($this->getMoves())===0){
            $this->endTurn();
        }
    }
}
/*Apomenoun.
makeMove method
finishMove method
endTurn
ValidateMove
getBoard
getValidateMoves
