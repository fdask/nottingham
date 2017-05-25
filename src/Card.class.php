<?php
namespace fdask\Sheriff;

/**
* defines a class to represent an individual munchkin card
**/
abstract class Card {
	/** constants representing the position of the card in the game **/
	const STATE_FACEDOWN = 'facedown';
	const STATE_FACEUP = 'faceup';

	/** @var string the name of the card **/
	public $name = null;

	/** @var string represents the state of the card (faceup or facedown) **/
	public $state = null;

	/**
	* initializes a new Card instance
	**/
	public function __construct() {
	}

	/**
	* returns a string representation of the card
	*
	* @return string
	**/
	public function __toString() {
		$ret = "Card: '" . $this->getName() . "' - Type: " . $this->getCardType() . " - State: " . $this->getState();

		return $ret;
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
	* sets the name property
	*
	* @param string $name	
	**/
	public function setName($name) {
		$this->name = $name;
	}

	/**
	* sets the state property
	*
	* @param string $state
	**/
	public function setState($state) {
		$this->state = $state;
	}

	/**
	* returns the state property
	*
	* @return string
	**/
	public function getState() {
		return $this->state;
	}

	/**
	* returns a string, identifying the type of card we have
	*
	* @return string
	**/
	public function getCardType() {
		// since this is an abstract class, we don't return anything!  subclasses must implement this
		return "";
	}
}
