<?php

require_once('AbstractXMLEntity.class.php');


class Image extends AbstractXMLEntity {

	/**
	 * @var string
	 */
	private $path = NULL;

	/**
	 * @var string
	 */
	private $name = NULL;

	/**
	 * @var string
	 */
	private $description = NULL;


	public function Image() {
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
}
