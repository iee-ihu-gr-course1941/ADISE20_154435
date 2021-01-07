<?php
//eisagwgh arxeiwn 
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
//return current state of board in json format
function currentBoard() {
   
        header('Content-type: application/json');
        print json_encode(getBoardState(), JSON_PRETTY_PRINT);
    }
}
?>
