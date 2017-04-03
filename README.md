# PokerOOP
Console Poker App using OOP best practices

Required Software/Environment : XAMPP PHP 7.0.15 was used to run the program on WINDOWS 7 Machine

This is a Poker application in PHP to be run in Console.

Currently there are 5 classes in the class folder:
1. Deck.class.php
2. Player.class.php
3. PlayingCard.class.php
4. PokerGame.class.php
5. PokerHand.class.php

And 2 Files (not counting this Instruction sheet) in the main folder.

1. init.php
2. poker.php (this is the main file to be run via command line)

Note : Abbreviations used for cards( for better console viewing) are as follows : S for SPADES , H for HEARTS, D for DIAMONDS, C for CLUBS.
INSTRUCTIONS (FOR WINDOWS) :

1. Open the Command Line and point to the directory and type php poker.php
2. Enter ‘shuffle’ command to shuffle the deck of card
3. For dealing the cards, type ‘deal[space] number of players’ and press enter (number of players must be between 2 & 5)
-- The program leaves out the top most card and deals the cards to the players, including 5 community cards.
-- Ranks of the players, player names and their best hands are printed accordingly
-- The User is prompted to start a new game again.

