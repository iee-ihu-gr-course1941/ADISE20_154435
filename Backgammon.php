<?php


$boardOperator = new BoardOperator(
    new BoardConstructor(),
    new PositionConstructor(),
    new PawnConstructor()
);

$diceConstructor = new DiceConstructor();
$movementConstructor = new MovementConstructor();
$players=[];


$gameOperator = new GameOperator($boardOperator, $diceConstructor, $movementConstructor);
$gameOperator->startNewGame();

$colors=[Pawn::WHITE_PAWN, Pawn::BLACK_PAWN];

while(true){
    $players[$gameOperator->getTurn()]->makeMove($gameOperator);
}

/*Only one functionality missing. To be completed after GameOperator is finished.


