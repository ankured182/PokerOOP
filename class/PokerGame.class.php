<?php
class PokerGame  {

	
//	public $seats =3;

	public $pokerPlayers;  
	public $cardDeck;

	public $communityCards;

    public function __construct()
    {
        $deckOfCards = new Deck();
        $this->cardDeck = $deckOfCards;
    }


	public function getWinner() 
	{
		$scoreArray = array();

		foreach($this->pokerPlayers as $node =>$pokerPlayer)
		{
			$scoreArray[$pokerPlayer->playerName] = array($pokerPlayer->getHandScore(), $pokerPlayer);
		}

 $totalPlayers=count($this->pokerPlayers);
//echo "m".$myCount;
		$ctr=1;
		while ($ctr<=$totalPlayers)
        {
            $highScore = 0;
            $highScoreArray = array();

            foreach ($scoreArray as $player) {
                if ($player[0] == $highScore) {
                    //There will be at least ONE player in the highscorearray
                    //compare the player to the winners.
                    $winner = $highScoreArray[0];
                    $winnerCounts = $winner[1]->getBestHand()->getValueCounts();
                    $newCounts = $player[1]->getBestHand()->getValueCounts();
                    $maxArray = max(array_keys($newCounts), array_keys($winnerCounts));

                    $arrayReturn = array_intersect_key($newCounts, array_flip($maxArray));

                    //special case for straights
                    if ($highScore == 9 OR $highScore == 5) {
                        $sumOfPlayer = $player[1]->getBestHand()->handSum();
                        $sumOfWinner = $winner[1]->getBestHand()->handSum();
                        if ($sumOfPlayer != 28 AND $sumOfWinner != 28) {
                            if ($sumOfPlayer == $sumOfWinner) {
                                $highScoreArray[] = $player;
                            } elseif ($sumOfPlayer > $sumOfWinner) {
                                //reset the array to zero items because all previous items were ties.
                                $highScoreArray = array();
                                $highScoreArray[] = $player;
                            }
                        } elseif ($sumOfPlayer != 28 AND $sumOfWinner == 28) {
                            //reset the array to zero items because all previous items were ties.
                            $highScoreArray = array();
                            $highScoreArray[] = $player;
                        }
                    } elseif ($newCounts == $winnerCounts) {
                        $highScoreArray[] = $player;
                    } elseif ($arrayReturn === $newCounts) {

                        //reset the array to zero items because all previous items were ties.
                        $highScoreArray = array();
                        $highScoreArray[] = $player;
                    }

                } elseif ($player[0] > $highScore) {
                    //reset highscore and clear array;
                    //this also handles the first item of an array
                    $highScoreArray = array();
                    $highScoreArray[] = $player;
                    $highScore = $player[0];
                }
            }

            if (count($highScoreArray) > 1)
            {
                echo "\n\n-------------------\nRank  $ctr : ";
                foreach ($highScoreArray as $tiePlayer)
                {
                    $tiePlayer[1]->showBestHand();
                    echo "\n";

                    $name = $tiePlayer[1]->playerName;
                    unset($scoreArray[$name]);

                    $ctr++;
                }
				echo "\n-------------------";
            }
            else
            {
                echo "\n\n-------------------\nRank  $ctr : ";
                $highScoreArray[0][1]->showBestHand();
                echo "\n-------------------";

                $name = $highScoreArray[0][1]->playerName;
                unset($scoreArray[$name]);
               // $this->getWinner2($name);

                $ctr++;
            }


        }

	}



    public function getWinner2($name)
    {

        echo "My Plan";

        $scoreArray = array();

        foreach($this->pokerPlayers as $node =>$pokerPlayer)
        {

            $scoreArray[$pokerPlayer->playerName] = array($pokerPlayer->getHandScore(), $pokerPlayer);

            unset($scoreArray[$name]);
            //unset($scoreArray["Player 2"]);

        }

        $highScore = 0;
        $highScoreArray = array();

        foreach($scoreArray as $player)
        {
            if($player[0] == $highScore)
            {
                //There will be at least ONE player in the highscorearray
                //compare the player to the winners.
                $winner = $highScoreArray[0];

                $winnerCounts = $winner[1]->getBestHand()->getValueCounts();

                $newCounts = $player[1]->getBestHand()->getValueCounts();

                $maxArray = max(array_keys($newCounts), array_keys($winnerCounts));

                $arrayReturn = array_intersect_key($newCounts, array_flip($maxArray));

                //special case for straights
                if($highScore == 9 OR $highScore ==5)
                {
                    $sumOfPlayer = $player[1]->getBestHand()->handSum();
                    $sumOfWinner = $winner[1]->getBestHand()->handSum();
                    if($sumOfPlayer != 28 AND  $sumOfWinner != 28)
                    {
                        if($sumOfPlayer == $sumOfWinner)
                        {
                            $highScoreArray[] = $player;
                        }
                        elseif($sumOfPlayer > $sumOfWinner)
                        {
                            //reset the array to zero items because all previous items were ties.
                            $highScoreArray = array();
                            $highScoreArray[] = $player;
                        }
                    }
                    elseif ($sumOfPlayer != 28 AND $sumOfWinner ==28)
                    {
                        //reset the array to zero items because all previous items were ties.
                        $highScoreArray = array();
                        $highScoreArray[] = $player;
                    }
                }
                elseif($newCounts == $winnerCounts)
                {
                    $highScoreArray[] = $player;
                }
                elseif($arrayReturn === $newCounts)
                {

                    //reset the array to zero items because all previous items were ties.
                    $highScoreArray = array();
                    $highScoreArray[] = $player;
                }

            }
            elseif ($player[0] > $highScore)
            {

                // echo "eee";
                // echo $highScoreArray->;

                //reset highscore and clear array;
                //this also handles the first item of an array
                $highScoreArray = array();
                $highScoreArray[] = $player;
                $highScore = $player[0];

            }
        }

        if(count($highScoreArray) > 1)
        {
            echo "\n-------------------\nIt is a tie between: \n-----------------";
            foreach ($highScoreArray as $tiePlayer)
            {
                $tiePlayer[1]->showBestHand();
            }
        }
        else
        {

            echo "\n-------------------\nThe 2nd place is: \n-------------------";
            $highScoreArray[0][1]->showBestHand();
        }
      //  return $highScore;

    }


	public function scoreHand()
	{
		foreach($this->pokerPlayers as $player)
		{
			$player->loadCommunityCards($this->communityCards);
			$player->scoreHand();
		}
	}


	public function dealHands($noOfPlayers)
	{
        for ($i=1;$i<=$noOfPlayers;$i++)
        {
            $this->pokerPlayers[]=new Player("Player ".$i);
        }

		foreach($this->pokerPlayers as $node => $players)
		{
			$card1 = $this->cardDeck->getCard();
			$card2 = $this->cardDeck->getCard();
			$pokerHand = new PokerHand($card1, $card2);
		 	$players->newHand($pokerHand);
		}

	}

	public function showHands()
	{
		foreach($this->pokerPlayers as $node =>$players)
		{
            $players->showHand();
        }
	}

	public function showBestHands()
	{
		foreach($this->pokerPlayers as $node =>$players)
		{	
			$players->showBestHand();
		}
	}

	public function dealCommunityCards()
	{
		$this->communityCards = array(
			$this->cardDeck->getCard(), 
			$this->cardDeck->getCard(), 
			$this->cardDeck->getCard(),
			$this->cardDeck->getCard(),
			$this->cardDeck->getCard());
	}

	public function showCommunityCards()
	{
		echo "\nCommunity Cards: \n";

		foreach($this->communityCards as $card)
		{
			$card->displayCard();
		}
		echo "\n\n";
	}


	public function shuffleCards()
	{
        $this->cardDeck->shuffleDeck();
	}

    public function showShuffledCards()
    {
        $this->cardDeck->printShuffledDeck();
    }


}

?>