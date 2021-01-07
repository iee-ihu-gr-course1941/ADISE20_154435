<?php
//return current state of board in json format
function currentBoard() {
   
        header('Content-type: application/json');
        print json_encode(getBoardState(), JSON_PRETTY_PRINT);
    }
}
?>
