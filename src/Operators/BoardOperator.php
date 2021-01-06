<?php

use CodeOn\Backgammon\Model\Piece;

class BoardOperator{

    private $BoardConstructor;

    private $PawnConstructor;

    private $PositionConstructor;

    private $board;

    public function __construct(BoardConstructor $BoardConstructor, PositionConstructor  $PositionConstructor, PawnConstructor $PawnConstructor){
        $this->BoardConstructor = $BoardConstructor;
        $this->PositionConstructor = $PositionConstructor;
        $this->PawnConstructor = $PawnConstructor;
    }
//create new round 
    public function setNewRound(){
        $this->board = $this->BoardConstructor->create();
        $this->createBoardPositions();

        $this->setPositionPieces();

        $this->setPositionPieces(1, 15, Piece::COLOUR_WHITE);
        $this->setPositionPieces(13, 15, Piece::COLOUR_BLACK);

    }
//create board 
    public function createBoardPositions($index, $quantity, $pawncolor){
        for ($i=0; $i< $quantity; $i++){
            $this->board->getPosition($index)->addPawn($this->PawnConstructor->create($pawncolor));
        }

    }
//stysimo poyliwn
    public function setPositionPieces($index, $quantity, $pawncolor){
        for($i=0; $i<quantity; $i++){
            $this->board->getPosition($index)->addPawn($this->PawnConstructor->create($pawncolor));
        }

    }
//kinhsh 
    public function movePawn($positionIndex, $newPositionIndex){
        $position = $this->board->getPotision($positionIndex);
        $pawn = $position->removePawn();

        $newPosition = $this->board->getPotision($newPositionIndex);

        $newPosition->addPawn($pawn);
    }
//trexousa katastash board
    public function getBoardState(){
        return $this->board;
    }
}

