<?php

include 'init.php';

function playPoker()
{


    echo "\n**************** NEW GAME ***************\n\n";

    echo " Type 'shuffle' command to shuffle the deck of cards:  ";

    $shuffleVal =trim(fgets(STDIN,1024));

    if($shuffleVal=="shuffle")
    {
        $gameOfPoker = new PokerGame();
        $gameOfPoker->shuffleCards();
        $gameOfPoker->showShuffledCards();

     $stageInit=0;
    while ($stageInit==0)
    {
        $dealInternalInit=false;
        while($dealInternalInit==false)
        {

        echo "\n Type 'deal'[space] Number of Players to deal cards (eg: 'deal 3'): ";

         $dealVal =trim(fgets(STDIN,1024));
         $dealVals = explode(" ", $dealVal);

        $ctr= count($dealVals);

           if($ctr==2)
           {

               if($dealVals[0]=="deal")
               {

                   if( ctype_digit(strval($dealVals[1])))
                   {
                       $dealInternalInit=true;
                   }
                   else
                   {
                       echo $dealVals[1];
                   }
               }
           }
           else
           {
               echo "You entered wrong command";
           }
        }

        $noOfPlayers=(int)$dealVals[1];
        if ($noOfPlayers > 1 && $noOfPlayers <= 5)
        {
            $stageInit=1;

            $gameOfPoker->dealHands($noOfPlayers);
            $gameOfPoker->showHands();

            $gameOfPoker->dealCommunityCards();
            $gameOfPoker->showCommunityCards();
            $gameOfPoker->scoreHand();
            echo "\n**************** Results ***************";
            $gameOfPoker->getWinner();

            echo "\n****************END OF GAME****************\n";
        }
        else
        {
            echo "No of players must be between 2 and 5";
        }
    }

    }
    else
    {
        echo "You entered wrong command ";
    }
}


while (true)
{
   playPoker();
}

function my_is_int($var) {
    $tmp = (int) $var;
    if($tmp == $var)
        return true;
    else
        return false;
}


?>