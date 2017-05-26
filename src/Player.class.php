<?php
namespace fdask\Sheriff;

/*
* represents a player in the game
**/
class Player {
	/** constants to identify which player deck one might want to access **/
	const DECK_HAND = 'deckhand';
	const DECK_PUBLICSTAND = 'deckpublicstand';
	const DECK_HIDDENSTAND = 'deckhiddenstand';

	/** @var string the name of the player **/
	public $name = null;

	/** @var integer the players gold **/
	public $gold = null;

	/** @var Deck representing the cards in a players hand **/
	public $cardHand = null;

	/** @var Deck representing the cards in the players public market stand **/
	public $cardPublicStand = null;

	/** @var Deck representing the cards in the players hidden market stand **/
	public $cardHiddenStand = null;

	/** @var Deck an extra hand of cards used for various purposes **/
	public $cardAux = null;

	/** @var boolean indicating the player has finished their turn **/
	public $doneTurn = null;

	/**
	* initializes a new player!
	**/
	public function __construct() {
		$this->cardHand = new Deck();
		$this->cardHand->setName("Hand");
		$this->cardHand->setState(Card::STATE_FACEDOWN);

		$this->cardPublicStand = new Deck();
		$this->cardPublicStand->setName("Market stand");
		$this->cardPublicStand->setState(Card::STATE_FACEUP);

		$this->cardHiddenStand = new Deck();
		$this->cardHiddenStand->setName("Contraband Stash");
		$this->cardHiddenStand->setState(Card::STATE_FACEDOWN);

		$this->cardAux = new Deck();
		$this->cardAux->setName("Aux Deck");
		$this->cardAux->setState(Card::STATE_FACEDOWN);
	}

	/**
	* returns a string representation of the player
	*
	* @return string
	**/
	public function __toString() {
		$ret = $this->getName() . " [" . $this->getGold() . "]";

		if ($this->getDoneTurn()) {
			$ret .= " - DONE";
		}

		$ret .= "\n";
	
		$ret .= $this->getCardHand() . "\n";
		$ret .= $this->getCardPublicStand() . "\n";
		$ret .= $this->getCardHiddenStand() . "\n";

		if (count($this->getCardAux()) > 0) {
			$ret .= $this->getCardAux() . "\n";
		}

		return $ret;
	}

	/**
	* sets the name property
	*
	* @param string $name
	**/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* returns the name property
	*
	* @return string
	**/
	public function getName() {
		return $this->name;
	}

	/**
	* sets the gold property
	*
	* @param integer $gold
	**/
	public function setGold($gold) {
		$this->gold = $gold;
	}

	/**
	* adds an amount to the gold property
	*
	* @param integer $amount
	* @return integer the new gold count
	**/
	public function addGold($amount) {
		$this->gold += $amount;

		return $this->gold;
	}

	/**
	* removes an amount from the gold property
	*
	* @param integer $amount
	* @return integer the new gold
	**/
	public function removeGold($amount) {
		// don't let the level fall below 1!
		$this->gold = (($this->gold - $amount) >= 0) ? ($this->gold - $amount) : 0;

		return $this->gold;
	}

	/**
	* returns the gold property
	*
	* @return integer
	**/
	public function getGold() {
		return $this->gold;
	}

	/**
	* sets the cardHand property
	*
	* @param Deck $deck
	**/
	public function setCardHand(Deck $deck) {
		$this->cardHand = $deck;
	}

	/**
	* gets the cardHand property
	*
	* @return Deck
	**/
	public function getCardHand() {
		return $this->cardHand;
	}

	/**
	* sets the cardPublicStand property
	*
	* @param Deck $deck
	**/
	public function setCardPublicStand(Deck $deck) {
		$this->cardPublicStand = $deck;
	}

	/**
	* gets the cardPublicStand property
	*
	* @return Deck
	**/
	public function getCardPublicStand() {
		return $this->cardPublicStand;
	}

	/**
	* sets the cardHiddenStand property
	*
	* @param Deck $deck
	**/
	public function setCardHiddenStand(Deck $deck) {
		$this->cardHiddenStand = $deck;
	}

	/**
	* gets the cardHiddenStand property
	*
	* @return Deck
	**/
	public function getCardHiddenStand() {
		return $this->cardHiddenStand;
	}

	/**
	* sets the cardAux property
	*
	* @param Deck $deck
	**/
	public function setCardAux(Deck $deck) {
		$this->cardAux = $deck;
	}

	/**
	* gets the cardAux property
	*
	* @return Deck
	**/
	public function getCardAux() {
		return $this->cardAux;
	}

	/**
	* sets the doneTurn property
	* 
	* @param boolean $bool
	**/
	public function setDoneTurn($bool) {
		$this->doneTurn = $bool;
	}

	/**
	* gets the doneTurn property
	*
	* @return boolean
	**/
	public function getDoneTurn() {
		return $this->doneTurn;	
	}
}
