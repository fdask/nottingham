<?php
namespace fdask\Sheriff;

/**
* the main object
**/
class Game {
	/** constants representing the five phases of a turn **/
	const PHASE_MARKET = 'market';
	const PHASE_BAGLOAD = 'bagload';
	const PHASE_DECLARE = 'declare';
	const PHASE_INSPECT = 'inspect';
	const PHASE_CLEANUP = 'cleanup';

	/** @var string a unique identifier representing this game **/
	public $id = null;

	/** @var string the phase of the current game **/
	public $phase = null;

	/** @var integer sets the total amount of gold in play **/
	public $totalGold = null;

	/** @var array holding the player objects involved in the game **/
	public $players = null;

	/** @var integer represents a position in the players array for who is sheriff this turn **/
	public $sheriff = null;

	/** @var integer represents a position in the players array for whose turn it is now **/
	public $turn = null;

	/** @var Deck the main draw deck **/
	public $drawDeck = null;

	/** @var Deck the first discard pile **/
	public $discardOneDeck = null;

	/** @var Deck the second discard pile **/
	public $discardTwoDeck = null;

	/**
	* initializes a new game
	**/
	public function __construct() {
		// generate a new identifier for the game
		$this->setId($this->generateId());
		$this->setPhase(self::PHASE_MARKET);
		$this->setTotalGold(1189);
	}

	/**
	* php magic method to output the class as a string
	*
	* @return string
	**/
	public function __toString() {
		$ret = "Game\n";
		$ret .= "Id: " . $this->getId() . "\n";
		$ret .= "Phase: " . $this->getPhase() . "\n";
		$ret .= "Players:\n";

		$players = $this->getPlayers();
		$sheriff = $this->getSheriff();
		$turn = $this->getTurn();

		foreach ($players as $position => $player) {
			if ($position === $turn) {
				$ret .= "THIS PLAYERS TURN!\n";
			} else if ($position === $sheriff) {
				$ret .= "(SHERIFF)\n";
			}

			$ret .= $player . "\n";
		}

		return $ret;
	}

	/**
	* sets the id property
	*
	* @param string $id
	**/
	public function setId($id) {
		$this->id = $id;
	}

	/**
	* generates a unique identifier
	*
	* @return string
	**/
	public function generateId() {
		return uniqid();
	}

	/**
	* gets the id property
	*
	* @return string
	**/
	public function getId() {
		return $this->id;
	}

	/**
	* sets the phase property
	*
	* @param string $phase
	**/
	public function setPhase($phase) {
		$this->phase = $phase;
	}

	/**
	* returns the phase property
	*
	* @return string
	**/
	public function getPhase() {
		return $this->phase;
	}

	/**
	* sets the totalGold property
	*
	* @param integer $gold
	**/
	public function setTotalGold($gold) {
		$this->totalGold = $gold;
	}

	/**
	* gets the totalGold property
	*
	* @return integer
	**/
	public function getTotalGold() {
		return $this->totalGold;
	}

	/**
	* sets the players property
	*
	* @param array $players
	**/
	public function setPlayers($players) {
		$this->players = $players;
	}

	/**
	* adds a single player object onto the players property
	*
	* @param Player $player
	**/
	public function addPlayer($player) {
		if (is_null($this->players)) {
			$this->players = array();
		}

		$this->players[] = $player;
	}

	/**
	* returns the players property
	* 
	* @return array
	**/
	public function getPlayers() {
		return $this->players;
	}

	/**
	* sets the turn property
	*
	* @param integer $turn
	**/
	public function setTurn($turn) {
		$this->turn = $turn;
	}

	/**
	* advances/cycles the turn property
	*
	* @return Player
	**/
	public function nextTurn() {
		if (isset($this->players[($this->turn + 1)])) {
			$this->turn++;
		} else {
			$this->turn = 0;
		}

		return $this->players[$this->turn];
	}

	/**
	* returns the turn property
	*
	* @return integer
	**/
	public function getTurn() {
		return $this->turn;
	}

	/**
	* sets the sheriff property
	*
	* @param integer $sheriff
	**/
	public function setSheriff($sheriff) {
		$this->sheriff = $sheriff;
	}

	/**
	* gets the sheriff property
	*
	* @return integer
	**/
	public function getSheriff() {
		return $this->sheriff;
	}

	/**
	* moves to the next sheriff
	*
	* @return Player
	**/
	public function nextSheriff() {

	}

	/**
	* sets the drawDeck property
	*
	* @param Deck $deck
	**/
	public function setDrawDeck(Deck $deck) {
		$this->drawDeck = $deck;
	}

	/**
	* gets the drawDeck property
	*
	* @return Deck
	**/
	public function getDrawDeck() {
		return $this->drawDeck;
	}

	/**
	* sets the discardOneDeck property
	*
	* @param Deck $deck
	**/
	public function setDiscardOneDeck(Deck $deck) {
		$this->discardOneDeck = $deck;
	}

	/**
	* gets the discardOneDeck property
	*
	* @return Deck
	**/
	public function getDiscardOneDeck() {
		return $this->discardOneDeck;
	}

	/**
	* sets the discardTwoDeck property
	*
	* @param Deck $deck
	**/
	public function setDiscardTwoDeck(Deck $deck) {
		$this->discardTwoDeck = $deck;
	}

	/**
	* gets the discardTwoDeck property
	*
	* @return Deck
	**/
	public function getDiscardTwoDeck() {
		return $this->discardTwoDeck;
	}

	// GAME LOGIC METHODS START HERE 

	/**
	* deals out the initial cards to the players, sets them up with the proper gold
	**/
	public function initialDeal() {
		// give each player 50 gold
		$gold = $this->getTotalGold();

		for ($x = 0; $x < count($this->players); $x++) {
			$gold = $gold - 50;
			$this->players[$x]->setGold(50);
			$this->setTotalGold($gold);
		}

		// deal six cards to each player
		for ($x = 0; $x < 6; $x++) {
			for ($p = 0; $p < count($this->players); $p++) {
				$card = $this->getDrawDeck()->getCard();

				$this->players[$p]->getCardHand()->addCard($card);		
			}
		}

		// set up the two discard Decks
		for ($x = 0; $x < 5; $x++) {
			$card = $this->getDrawDeck()->getCard();
			$this->getDiscardOneDeck()->addCard($card);
		}

		for ($x = 0; $x < 5; $x++) {
			$card = $this->getDrawDeck()->getCard();
			$this->getDiscardTwoDeck()->addCard($card);
		}
	}

	/**
	* randomly picks one of the players to go first!
	*
	* @return integer representing the position in the player array
	**/
	public function getRandomPlayer() {
		return array_rand($this->players);
	}

	/**
	* pulls a card from the given deck, matching the input, from the deck
	*
	* @param integer $player (integer representing the player number in the players array
	* @param string $deck Player::DECK_HAND or Player::DECK_PLAY
	* @param string $input either an integer, or a string matching a card name to draw
	* @return false|Card
	**/
	public function findCard($player, $deck, $input) {
		if (isset($this->players[$player])) {
			$player = $this->players[$player];

			if ($deck == Player::DECK_HAND) {
				$deck = $player->getCardHand();
			} else if ($deck == Player::DECK_PLAY) {
				$deck = $player->getCardPlay();
			}

			if ($deck && !empty($deck)) {
				if (is_numeric(trim($input))) {
					$cardPosition = (int)trim($input);

					$card = $deck->getCardByPosition($cardPosition);

					if (!$card) {
						echo "Invalid card number\n";
					}

					return $card;
				} else {
					$cardName = trim($input);

					// get the users hand and check to see if we can find a matching card!
					$card = $deck->getCardByName($cardName);				

					if (!$card) {
						// lets try a partial match!
						$cards = $deck->getCardByPartialName($cardName);

						if (!empty($cards)) {
							if (count($cards) > 1) {
								// two or more partial matches found!  Lets print them!
								echo "Ambiguous card name...\n";

								foreach ($cards as $card) {
									echo $card . "\n";
								}
							} else {
								$card = $cards[0];

								return $card;
							}
						} else {
							echo "Couldn't find a card with name '" . $cardName . "'\n";
						}
					} else {
						return $card;
					}
				}
			}
		}

		return false;
	}

	/**
	* for testing, we capture input from the cli and parse it here to figure out moves.
	*
	* @param string $input
	**/
	public function getMove($input) {
		// expode the input
		$cbits = explode(",", trim($input));

		$cmd = $cbits[0];

		if ($cmd == "d1") {
			echo $this->getDiscardOneDeck();
		} else if ($cmd == "d2") {
			echo $this->getDiscardTwoDeck();
		} else if ($cmd == "d") {
			echo $this->getDiscardOneDeck();
			echo $this->getDiscardTwoDeck();
		} else if ($cmd == "h") {
			$turn = $this->getTurn();

			if (isset($this->players[$turn])) {
				echo $this->players[$turn]->getCardHand();
			} else {
				echo "Turn set to $turn, but that player doesn't exist!\n";
			}
		} else if ($cmd == "t") {
			$turn = $this->getTurn();

			if (isset($this->players[$turn])) {
				echo $this->players[$turn];
			} else {
				echo "Turn set to $turn, but that player doesn't exist!\n";
			}
		} else if (preg_match("@^p(\d)@", $cmd, $matches)) {
			$playerNum = $matches[1];

			if (isset($this->players[$playerNum])) {
				if ($playerNum == $turn) {
					echo "THIS PLAYERS TURN!\n";
				} else if ($playerNum == $sheriff) {
					echo "(SHERIFF)\n";
				}

				echo $this->players[$playerNum];
			} else {
				echo "Player $playerNum doesn't exist!\n";
			}
		} else if ($cmd == "p") {
			for ($x = 0; $x < count($this->players); $x++) {
				$turn = $this->getTurn();
				$sheriff = $this->getSheriff();

				if ($x == $turn) {
					echo "THIS PLAYERS TURN!\n";
				} else if ($x == $sheriff) {
					echo "(SHERIFF)\n";
				}

				echo $this->players[$x];
			}	
		} else if (trim($cbits[0]) == "done") {
			if ($this->getState() == self::STATE_STARTUP) {
				// if the game state is still in the first round, mark the player as done
				$this->players[$player]->setDoneTurn(true);	

				// check to see if all players are done
				$everyoneReady = true;

				foreach ($this->players as $player) {
					if (!$player->getDoneTurn()) {
						$everyoneReady = false;
					}
				}

				if ($everyoneReady) {
					// advance the game to actual gameplay!!
					echo "EVERYONE IS READY!  Advancing game to regular turns!\n";
					echo "Player " . ($this->getTurn() + 1) . " is up first!\n";

					$this->setState(self::STATE_REGULAR);

					echo $this->players[$this->getTurn()];
				}
			} else {
				// lets assume the player is ending their turn!  or going to the next phase, anyway.
			}
		} else {
			$this->turnHelp();
		}
	}

	/**
	* outputs text describing possible moves
	***/
	public function turnHelp() {
		echo "h - Show your hand\n";
		echo "t - Show the current player\n";
		echo "d - Show both discard decks\n";
		echo "d1 - Show first discard deck\n";
		echo "d2 - Show second discard deck\n";
		echo "done - Finish your turn\n";
		echo "p - Show data on all players\n";
		echo "pX - Show data on player\n";
	}

	/**
	* helper that determines the type of card we have, and which pile it should be added too
	*
	* @param Card $card
	* @return boolean indicating success or failure of the discard
	**/
	public function discard($card) {
		if (is_subclass_of($card, 'fdask\Munchkin\TreasureCard')) {
			$this->treasureDeckDiscard->addCard($card);
		} else if (is_subclass_of($card, 'fdask\Munchkin\DoorCard')) {
			$this->doorDeckDiscard->addCard($card);
		} else {
			echo "Unknown card class!  " . $card->getCardType() . "\n";

			return false;
		}

		return true;
	}

	/**
	* returns an array of all the possible game state constants
	*
	* @return array
	**/
	public static function getGamePhases() {
		return array(
			self::PHASE_MARKET,
			self::PHASE_BAGLOAD,
			self::PHASE_DECLARE,
			self::PHASE_INSPECT,
			self::PHASE_CLEANUP
		);
	}
}
