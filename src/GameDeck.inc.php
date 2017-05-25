<?php
namespace fdask\Sheriff;

/**
144 Legal goods
- 48 apples worth 2 each
- 36 cheese worth 3 gold each
- 36 bread worth 3 gold each
- 24 chickens worth 4 gold each

60 contraband
- 22 pepper worth 6 gold
- 21 mead worth 7 gold
- 12 silk worth 8 gold
- 5 crossbows with 9 gold 
**/

for ($x = 0; $x < 48; $x++) {
	$card = new GoodsCard("Apples", GoodsCard::TYPE_LEGAL, 2);
	$drawDeck->addCard($card);
}

for ($x = 0; $x < 36; $x++) {
	$card = new GoodsCard("Cheese", GoodsCard::TYPE_LEGAL, 3);
	$drawDeck->addCard($card);
}

for ($x = 0; $x < 36; $x++) {
	$card = new GoodsCard("Bread", GoodsCard::TYPE_LEGAL, 3);
	$drawDeck->addCard($card);
}

for ($x = 0; $x < 24; $x++) {
	$card = new GoodsCard("Chicken", GoodsCard::TYPE_LEGAL, 4);
	$drawDeck->addCard($card);
}

for ($x = 0; $x < 22; $x++) {
	$card = new GoodsCard("Pepper", GoodsCard::TYPE_CONTRABAND, 6);
	$drawDeck->addCard($card);
}

for ($x = 0; $x < 21; $x++) {
	$card = new GoodsCard("Mead", GoodsCard::TYPE_CONTRABAND, 7);
	$drawDeck->addCard($card);
}

for ($x = 0; $x < 12; $x++) {
	$card = new GoodsCard("Silk", GoodsCard::TYPE_CONTRABAND, 8);
	$drawDeck->addCard($card);
}

for ($x = 0; $x < 5; $x++) {
	$card = new GoodsCard("Crossbows", GoodsCard::TYPE_CONTRABAND, 9);
	$drawDeck->addCard($card);
}
