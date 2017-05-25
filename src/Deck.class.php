<?php
namespace fdask\Sheriff;

/**
* represents a deck
**/
class Deck implements \Iterator, \Countable {
	/** @var string give a name to a deck **/
	public $name = null;

	/** @var string indicates whether the cards in this deck are face up or face down **/
	public $state = null;

	/** @var array holds the cards **/
	public $cards = null;

	/** @var integer the position in the cards array we're currently on - required by Iterator **/
	public $position = null;

	/**
	* initializes a new deck object
	**/
	public function __construct() {
		$this->position = 0;
		$this->cards = array();
	}

	/**
	* method to implement countable
	*
	* @return integer
	**/
	public function count() {
		return count($this->cards);
	}

	// methods required to implement Iterator

	/**
	* returns the current card pointed to by position - required by Iterator
	*
	* @return Card
	**/
	public function current() {
		return $this->cards[$this->position];
	}

	/**
	* returns the position value - required by Iterator
	*
	* @return integer
	**/
	public function key() {
		return $this->position;
	}

	/**
	* advances the internal pointer - required by Iterator
	**/
	public function next() {
		$this->position++;
	}

	/**
	* resets the array position back to zero.  required by Iterator 
	**/
	public function rewind() {
		$this->position = 0;
	}

	/**
	* checks to see if the current position is valid - required by Iterator
	*
	* @return boolean
	**/
	public function valid() {
		return isset($this->cards[$this->position]);
	}
	// end of Iterator methods

	/**
	* returns a string representation of a deck
	*
	* @return string
	**/
	public function __toString() {
		$ret = $this->getName() . " [" . $this->getState() . "]:\n";

		$cards = $this->getCards();

		if (!empty($cards)) {
			$pos = 0;

			foreach ($cards as $card) {
				$ret .= "$pos) " . $card . "\n";

				$pos++;
			}
		} else {
			$ret .= "NO CARDS\n";
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
	* gets the name property
	*
	* @return string
	**/
	public function getName() {
		return $this->name;
	}

	/** 
	* sets the state property
	*
	* @param string $state should be one of the Card::STATE_X constants
	**/
	public function setState($state) {
		$this->state = $state;
	}

	/**
	* gets the state property
	*
	* @return string
	**/
	public function getState() {
		return $this->state;
	}

	/**
	* sets the cards property
	*
	* @param array $cards
	**/
	public function setCards($cards) {
		$this->cards = $cards;
	}

	/**
	* adds a single card object to the cards property
	*
	* @param object $card
	**/
	public function addCard(Card $card) {
		if (is_null($this->cards)) {
			$this->cards = array();
		}

		// set the card to the appropriate state
		$card->setState($this->getState());

		// add it to the pile	
		$this->cards[] = $card;
	}

	/**
	* gets the cards property
	*
	* @return array
	**/
	public function getCards() {
		return $this->cards;
	}

	/**
	* randomizes the order of the cards property
	**/
	public function shuffleDeck() {
		if (is_array($this->cards) && count($this->cards) > 0) {
			shuffle($this->cards);		
		}
	}

	/**
	* sorts the cards by name!
	* 
	* @return boolean indicating success or failure
	**/
	public function sort() {
		return usort($this->cards, function ($a, $b) {
			$aName = $a->getName();
			$bName = $b->getName();

			if ($aName == $bName) {
				return 0;
			} else {
				return strcmp($aName, $bName);
			}
		});	
	}

	/**
	* retrieves a single card from the top of the cards array
	*
	* @return false|object 
	**/
	public function getCard() {
		if (count($this->cards) > 0) {
			$card = array_shift($this->cards);

			return $card;
		}

		return false;
	}

	/**
	* retrieves a single card from the specified position of the array
	*
	* @param integer $position
	* @return false|object
	**/
	public function getCardByPosition($position = 0) {
		if (count($this->cards) > 0 && isset($this->cards[$position])) {
			$card = array_splice($this->cards, $position, 1)[0];

			return $card;
		}	

		return false;
	}

	/**
	* searches the deck for a card with the given name.  case irrelevant.  
	* returns the card if it's found, otherwise, false
	*
	* @param string $name
	* @return false|Card
	**/
	public function getCardByName($name) {
		foreach ($this->cards as $card) {
			if (strtolower($card->getName()) == strtolower($name)) {
				return $card;
			}
		}

		return false;
	}

	/**
	* searches the deck for a card with the given name.  case irrelevant.
	* returns all matching cards, not just one!
	*
	* @param string $partial
	* @return false|Array
	**/
	public function getCardByPartialName($partial) {
		$ret = array();

		foreach ($this->cards as $card) {
			if (strpos(strtolower($card->getName()), strtolower($partial)) === 0) {
				$ret[] = $card;
			}
		}

		if (!empty($ret)) {
			return $ret;
		}

		return false;
	}
}
