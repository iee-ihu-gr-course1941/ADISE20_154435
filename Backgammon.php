<?php
//eisagwgh arxeiwn 
require 'Console.php';
require './src/Operators/BoardOperator.php';
require './src/Operators/GameOperator.php';
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


 /*session_start();
  if(!isset ($_SESSION['username'])){ 
    $_SESSION['username'] = "";
    
  }*/
//aythentikopoihsh gia na kalesoyme to api estw thn prwth fora meta apo elenxo
$username = readline("Enter the Username");
if($username!="Anastasia"){                         //Username Anastasia
    echo "wrong username. Run the script Again";
    die(); 
}

//print_r(get_included_files());
welcomeMessage();
//dhmioyrgia board
$boardOperator = new BoardOperator(
    new BoardConstructor(),
    new PositionConstructor(),
    new PawnConstructor()
);

$diceConstructor = new DiceConstructor();
$movementConstructor = new MovementConstructor();
$players=[];


$gameOperator = new GameOperator($boardOperator, $diceConstructor, $movementConstructor);
$gameOperator->startNewGame();//created new game 

$colors=[Pawn::WHITE_PAWN, Pawn::BLACK_PAWN];

foreach($colors as $c){
    $players->setColor($c);
    $players[$c] = $players;

}
//player make a move 
while(true){
    $players[$gameOperator->getTurn()]->makeMove($gameOperator);
}




