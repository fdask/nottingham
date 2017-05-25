<?php
namespace fdask\Sheriff;

use fdask\Sheriff\Card;

/**
* represents the cards in the game
**/
class GoodsCard extends Card {
	/** constants representing the cardType **/
	const TYPE_LEGAL = 'legal';
	const TYPE_CONTRABAND = 'contraband';
	const TYPE_ROYAL = 'royal';

	/** @var string the type of goods! **/
	public $cardType = null;

	/** @var integer the card value **/
	public $value = null;

	/** @var boolean indicating if this card is suitable for three players **/
	public $forThree = null;

	/**
	* initializes a new card
	**/
	public function __construct($name, $type, $value) {
		$this->setName($name);
		$this->setCardType($type);
		$this->setValue($value);
	}

	/**
	* outputs a string representation
	*
	* @return string
	**/
	public function __toString() {
		$ret = $this->getName() . " - " . $this->getValue() . " - " . ucfirst($this->getCardType());

		return $ret;
	}

	/**
	* sets the cardType property
	*
	* @param string $type
	**/
	public function setCardType($type) {
		$this->cardType = $type;
	}

	/**
	* gets the cardType
	*
	* @return string
	**/
	public function getCardType() {
		return $this->cardType;
	}

	/**
	* sets the value property
	*
	* @param integer $value
	**/
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	* returns the value property
	*
	* @return integer
	**/
	public function getValue() {
		return $this->value;
	}

	/**
	* sets the forThree property
	*
	* @param boolean $bool
	**/
	public function setForThree($bool) {
		$this->forThree = $bool;
	}

	/**
	* gets the forThree property
	*
	* @return boolean
	**/
	public function getForThree() {
		return $this->forThree;
	}
}
