<?php

require_once('AbstractXMLEntity.class.php');


/**
 * Gallery category.
 *
 * @author Bartosz Firyn (SarXos)
 */
class Category extends AbstractXMLEntity {

	/**
	 * @var string
	 */
	private $name = NULL;

	/**
	 * @var string
	 */
	private $description = NULL;

	/**
	 * @var array[Image]
	 */
	private $images = NULL;


	public function Category() {
	}

	/**
	 * Get name.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->$name;
	}

	/**
	 * Get description.
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Return images from category.
	 *
	 * @return array[Image]
	 */
	public function getImages() {
		return $this->images === NULL ? array() : $this->images;
	}
}
