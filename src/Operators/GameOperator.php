<?php
require './src/Constructors/BoardConstructor.php';
require './src/Constructors/DiceConstructor.php';
require './src/Constructors/PawnConstructor.php';
require './src/Constructors/PositionConstructor.php';
require './src/Constructors/MovementConstructor.php';
require './src/Parts/Movement.php';
require './src/Parts/Board.php';
require './src/Parts/Position.php';
require './src/Parts/Dice.php';
require './src/Parts/Pawn.php';
require './src/Parts/Players.php';

class GameOperator{

    private $boardOperator;

    private $diceConstructor;
    private $movementConstructor;
    private $dice;
    private $turn;

    private $players;

    public function __construct(BoardOperato $boardOperator, DiceConstructor $diceConstructor, MovementConstructor $movementConstructor){

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


    public function makeMove(Movement $movement){
        $positionIndex = $movement->getStartingPosition();
        $positions = $movement->getNumberPosition();

        $this->validateMove($positionIndex, $positions);

        $board = $this->boardOperator->getBoardState();
        $point = $board->getPoints($positionIndex);
        $pawn = $point->removePawn();
        $newpos=null;


        //$dice
        if($pawn->getColor() == Piece::COLOUR_WHITE && ($positionIndex + $positions) < 25) {
            $newpos = $board->getPoint($positionIndex + $positions);
        }

        if($pawn->getColor() == Piece::COLOUR_BLACK && ($positionIndex - $positions) > 0) {
            $newpos = $board->getPoint($positionIndex + $positions);
        }

        if($newpos !== null) {
            if ($newpos->isOccupied() && $newpos->occupiedBy() !== $pawn->getColor()) {
                throw new PointOccupiedException($point);
            }

            $newpos->addPawn($pawn);
        }
        $dice = $this->getUnusedDiceByValue($positions);
        $dice->setUsed(true);

        if(count($this->getMoves()) === 0) {
            $this->output->outputNotification('no more moves');
        }

        if(count($this->getMoves()) === 0) {
            $this->endTurn();
        } else {
            $this->finish();
        }

        }

    public function validateMove($positionIndex, $positions){
        $board = $this->boardOperator->getBoardState();
        $pos = $board->getPoints($positionIndex);

        $newpos = null;

        if($this->getTurn()==Pawn::WHITE_PAWN && ($positionIndex + $positions) < 25){
            $newpos = $board->getPoints($positionIndex + $positions);
            return $newpos;
        }
        if($this->getTurn()==Pawn::BLACK_PAWN && ($positionIndex - $positions) > 0){
		if($positionIndex + $positions)>24)
	    $newpos = $board->getPoints($positionIndex + $positions - 24);
		else
            $newpos = $board->getPoints($positionIndex + $positions);
            return $newpos;
        }

        if($newpos!=null){
            if($newpos->isInUse() && $newpos->inUseBy() !=$this->getTurn()){        //Sunthiki teliki an to Position einai katelimeno exception gia tin thesi.
                throw new PositionOccupiedException($positions);
            }
        }
        else{
            throw new NoMoveOfBoardException();
        }

       $this->getUnusedDiceByValue($positions);

    }

    public function endTurn(){
        foreach($this->dice as $x){
            $x->setUsed(true);
        }

        if($this->getTurn() === Pawn::BLACK_PAWN) {
            $this->turn = Pawn::WHITE_PAWN;
        }
        else {
            $this->turn = Pawn::BLACK_PAWN;
        }

        $this->roll();
    }
///Methodos gia collect poulia afou ftasoun stin vasi ola "mazema"
    public function canCollectPieces(){                                             

        if($this->getTurn()===Pawn::WHITE_PAWN){
            $start = 0;
            $end = 18;
        }

        if($this->getTurn()===Pawn::BLACK_PAWN){
            $start = 7;
            $end = 25;
        }

        for($i = $start; $i < $end; $i++){
            if($this->boardOperator->getBoardState()->getPosition($i)->inUseBy() === $this->getTurn()){
                return false;
            }
        }
        return true;

    }

    private function finish()
    {
        $dice = $this->getDice();

        foreach($dice as $x) {
            if($x->isUsed() === false) {
                return;
            }
        }
                                //Here push to database the current state of board
        $this->endTurn();
    }


    public function getMoves(){
        $board = $this->boardOperator->getBoardState();

        $point = $board->getPoints();


        $startingPositions = [];

        foreach($point as $index => $point) {
            if($point->isOccupied() && $point->occupiedBy() === $this->getTurn()) {
                $startingPositions[] = $index;
            }
        }

     /*   if(count($startingPositions) == 0) {
            $this->output->outputBoard($this->getBoard());
            $this->output->outputNotification($this->getTurn() . " wins");
            die(); //ToDo make this better
        }   */

        $validMoves = [];

        foreach($startingPositions as $startingPosition) {
            foreach($this->getDice() as $d) {
                try {
                    $this->validateMove($startingPosition, $d->getValue());

                    $move = $this->moveFactory->create($startingPosition, $d->getValue());
                    $validMoves[] = $move;
                } catch (MoveException $exception) {

                }
            }
        }

        return $validMoves;
    }

    private function getUnusedDiceByValue($value)
    {
        $dice = $this->getDice();

        foreach($dice as $die) {
            if(!$die->isUsed() && $die->getValue() === $value) {
                return $die;
            }
        }

        throw new NoValidDiceFoundException($this->getDice(), $value);
    }

}



