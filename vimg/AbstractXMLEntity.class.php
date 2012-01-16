<?php

require_once('Validation.class.php');


/**
 * This class represents abstract XML entity.
 *
 * @author Bartosz Firyn (SarXos)
 */
 abstract class AbstractXMLEntity {

 	/**
 	 * Set attribute for given node if value is not NULL.
 	 *
 	 * @param DOMElement $node
 	 * @param string $name
 	 * @param string $value
 	 */
 	public static function setAttr(DOMElement $node, $name, $value) {

 		Validation::validateIsNotNull($node, 'DOMElement Node cannot be null.');
 		Validation::validateIsInstancedClass($node, 'DOMElement', 'Invalid node argument passed to write REST DOM attribute - class ' . get_class($node) . '.');
 		Validation::validateIsNotNull($name, 'REST DOM attribute \'name\' cannot be null');
 		Validation::validateIsString($name, 'REST DOM attribute \'name\' must be string.');

 		if ($value !== NULL) {
 			$node->setAttribute($name, $value);
 		}
 	}

 	/**
 	 * This function read given attribute from node and return it, or NULL if
 	 * attribute has not been set.
 	 *
 	 * @param DOMElement $node
 	 * @param string $name
 	 * @return string
 	 */
 	public static function getAttr(DOMElement $node, $name) {

 		if (!$node->hasAttribute($name)) {
 			return NULL;
 		}

 		Validation::validateIsNotNull($node, 'DOMElement Node cannot be null.');
 		Validation::validateIsInstancedClass($node, 'DOMElement', 'Invalid node argument passed to write REST DOM attribute - class ' . get_class($node) . '.');
 		Validation::validateIsNotNull($name, 'REST DOM attribute \'name\' cannot be null');
 		Validation::validateIsString($name, 'REST DOM attribute \'name\' must be string.');

 		$value = $node->getAttribute($name);
 		return $value;
 	}

 	/**
 	 * Convert XML entity implementation to the DOMElement object.
 	 *
 	 * @param DOMDocument $document
 	 * @param DOMElement $node (optional)
 	 * @return DOMElement
 	 */
 	public abstract function toDOM(DOMDocument $document, DOMElement $node = NULL);

 	/**
 	 * Convert REST entity impl to the new DOMDocument.
 	 *
 	 * @return DOMDocument
 	 */
 	public abstract function toXML();

 	/**
 	 * Convert DOMDocument to the XML entity impl.
 	 *
 	 * @return Restable
 	 */
 	public function fromXML($xml) {
 		$dom = NULL;
 		if ($xml instanceof DOMDocument) {
 			$dom = $xml;
 		} else {
 			$dom = new DOMDocument();
 			$dom->loadXML($xml);
 		}
 		return self::fromDOM($dom->documentElement);
 	}
 }
