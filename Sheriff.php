#!/usr/bin/php
<?php
require 'vendor/autoload.php';

use fdask\Sheriff\Player;
use fdask\Sheriff\Game;
use fdask\Sheriff\Deck;
use fdask\Sheriff\Card;
use fdask\Sheriff\GoodsCard;

$game = new Game();

// create the players!
$p1 = new Player();
$p1->setName("Player 1");
$game->addPlayer($p1);

$p2 = new Player();
$p2->setName("Player 2");
$game->addPlayer($p2);

$p3 = new Player();
$p3->setName("Player 3");
$game->addPlayer($p3);

$p4 = new Player();
$p4->setName("Player 4");
$game->addPlayer($p4);

$drawDeck = new Deck();
$drawDeck->setState(Card::STATE_FACEDOWN);

$discardOneDeck = new Deck();
$discardOneDeck->setName("DISCARD ONE");
$discardOneDeck->setState(Card::STATE_FACEUP);

$discardTwoDeck = new Deck();
$discardTwoDeck->setName("DISCARD TWO");
$discardTwoDeck->setState(Card::STATE_FACEUP);

include 'src/GameDeck.inc.php';

$drawDeck->shuffleDeck();

$game->setDrawDeck($drawDeck);
$game->setDiscardOneDeck($discardOneDeck);
$game->setDiscardTwoDeck($discardTwoDeck);

// pick a sheriff.
$sheriff = $game->getRandomPlayer();
$game->setSheriff($sheriff);

// pick a player to go first.
do {
	$turn = $game->getRandomPlayer();
} while ($turn == $sheriff);

$game->setTurn($turn);

// start the game.
$game->initialDeal();

echo $game;

// main game loop!
while (1) {
   $input = readline("MOVE? ");

   if (trim($input) == "dump") {
      file_put_contents("GAME_DUMP", serialize($game));

      echo "Game dumped!\n";

      continue;
   } else if (trim($input) == "load") {
      if (file_exists("GAME_DUMP")) {
         $game = unserialize(file_get_contents("GAME_DUMP"));

         echo "Game loaded!\n";

         echo $game;
      } else {
         echo "Game file 'GAME_DUMP' not found!\n";
      }

      continue;
   }

   $game->getMove($input);

   readline_add_history($input);
}
