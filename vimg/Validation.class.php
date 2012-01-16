<?php

/**
 * This class represents validations.
 *
 * @author Bartosz Firyn (SarXos)
 */
class Validation {

	const MAIL_REGEX     = '/^[_a-zA-Z0-9-]+(\.[_a-zA-z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/';
	const DATETIME_REGEX = '/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}.?/';
	const URL_REGEX      = '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i';

	/**
	 * Construct Validation.
	 */
	public function Validation() {
	}

	/**
	 * Check if given value is valid for specified enum (const Array).
	 *
	 * @param mixed $value
	 * @param Array $enum
	 */
	public static function isValid($value, $enum) {
		return isset($enum[$value]);
	}

	/**
	 * Validate long ID form.
	 *
	 * @param string $id
	 * @throws InvalidArgumentException
	 */
	public static function validateLongID($id, $entityName = '', $length = 10) {
		self::validateIsNotEmpty($id, $entityName . ' ID cannot be NULL or Empty.');
		self::validateIsLong($id, $entityName . ' ID is not long integer value.');
		self::validateIsMatch($id, '/^[0-9]{1,' . $length . '}$/', $entityName . ' ID does not match pattern: [0-9]{1,' . $length . '}. Current value is: ' . $id . '.');
	}

	/**
	 * Validate alphanumeric ID form.
	 *
	 * @param string $id
	 * @param string $entityName - REST entity name
	 * @param string $length
	 * @throws InvalidArgumentException
	 */
	public static function validateAlphaNumericID($id, $entityName = '', $length = 10) {
		self::validateIsNotEmpty($id, $entityName . 'ID cannot be NULL or Empty.');
		self::validateIsMatch($id, '/^[0-9A-Za-z]{1,' . $length . '}$/', $entityName . ' ID does not match pattern: [0-9A-Za-z]{1,' . $length . '}. Current value is: ' . $id . '.');
	}

	/**
	 * Validate value is not NULL
	 *
	 * @param $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsNotNull($arg, $errorMsg = 'Argument cannot be null.') {
		if ($arg === NULL) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Validate value is not empty
	 *
	 * @param $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsNotEmpty($value, $errorMsg) {
		if (empty($value)) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Check if node passed as the argument has appropriate name.
	 *
	 * @param DOMNode $node
	 * @param string $name
	 * @param string $message
	 */
	public static function validateNode(DOMNode $node, $name, $errorMsg) {
		self::validateIsNotNull($node, 'Node cannot be null.');
		self::validateIsInstancedClass($node, 'DOMNode', 'Node must be and instance of DOMNode.');
		self::validateIsNotEmpty($name, 'Name cannot be empty.');
		self::validateIsString($name, 'Name must be a string.');

		if ($node->nodeName != $name) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Validate value is string
	 *
	 * @param string $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsString($value, $errorMsg) {
		if (!is_string($value)) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Validate value is long - alias of validateIsInt
	 *
	 * @param long $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsLong($value, $errorMsg) {
		self::validateIsInt($value, $errorMsg);
	}

	/**
	 * Validate value is int
	 *
	 * @param int $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsInt($value, $errorMsg) {
		self::validateIsMatch($value, '/^-?[0-9]+$/', $errorMsg);
	}


	/**
	 * Validate value is float
	 *
	 * @param float $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsFloat($value, $errorMsg) {
		self::validateIsMatch($value, '/^-?[0-9]+([,\.][0-9]+)?$/xD', $errorMsg);
	}

	/**
	 * Validate value is double - alias of validateIsFloat
	 *
	 * @param doable $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsDouble($value, $errorMsg) {
		self::validateIsFloat($value, $errorMsg);
	}

	/**
	 * Validate value is bool
	 *
	 * @param bool $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsBool($value, $errorMsg) {

		switch(gettype($value)) {
			case 'boolean':
				break;
			case 'string':
				if ( (strtolower($value) == 'true' || $value == '1') || (strtolower($value) == 'false' || $value == '0') ) {
					return;
				} else {
					throw new InvalidArgumentException($errorMsg);
				}
				break;
			case 'integer':
			case 'double':
				if ($value == 1 || $value == 0) {
					return;
				} else {
					throw new InvalidArgumentException($errorMsg);
				}
				break;
			default:
				throw new InvalidArgumentException($errorMsg);
		}

	}

	/**
	 * Validate value is bool or NULL
	 *
	 * @param bool|null $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsBoolOrNull($value, $errorMsg) {

		switch(gettype($value)) {
			case 'NULL':
			case 'boolean':
				break;
			case 'string':
				if ( (strtolower($value) == 'true' || $value == '1') || (strtolower($value) == 'false' || $value == '0') ) {
					return;
				} else {
					throw new InvalidArgumentException($errorMsg);
				}
				break;
			case 'integer':
			case 'double':
				if ($value == 1 || $value == 0) {
					return;
				} else {
					throw new InvalidArgumentException($errorMsg);
				}
				break;
			default:
				throw new InvalidArgumentException($errorMsg);
		}

	}

	/**
	 * Validate value is DateTime
	 *
	 * @param DateTime $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsDateTime($value, $errorMsg) {
		self::validateIsMatch($value, self::DATETIME_REGEX, $errorMsg);
	}

	/**
	 * Validate value is Match Regex
	 *
	 * @param string $value
	 * @param string $regex
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsMatch($value, $regex, $errorMsg) {
		if (!preg_match($regex, $value)) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Validate value is not Match Regex
	 *
	 * @param string $value
	 * @param pattern $regex
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsNotMatch($value, $regex, $errorMsg) {
		if (preg_match($regex, $value)) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Validate value is Email
	 *
	 * @param string $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsEmail($value, $errorMsg) {
		self::validateIsMatch($value, self::MAIL_REGEX, $errorMsg);
	}

	/**
	 * Validate value is Url
	 *
	 * @param string $value
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsUrl($value, $errorMsg) {
		self::validateIsMatch($value, self::URL_REGEX, $errorMsg);
	}

	/**
	 * Validate enum
	 *
	 * @param string $value
	 * @param string $enum
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateEnum($value, $enum, $errorMsg) {
		if (!class_exists($enum)) {
			throw new InvalidArgumentException("Passed string '$enum' cannot be identified as a Class.");
		}
		if (!method_exists($enum, 'isValid')) {
			throw new InvalidArgumentException("Class '$enum' doesn't have method called 'isValid'.");
		}
		if (!method_exists($enum, 'values')) {
			throw new InvalidArgumentException("Class '$enum' doesn't have method called 'values'.");
		}
		if (!call_user_func(array($enum, 'isValid'), $value)) {
			$s = implode(", ", call_user_func(array($enum, 'values')));
			throw new InvalidArgumentException($errorMsg . " may only be one of [$s] and '$value' given.");
		}
	}

	/**
	 * Validate value length
	 *
	 * @param string $value
	 * @param int $min
	 * @param int $max
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateLength($value, $min, $max, $errorMsg) {
		self::validateIsMatch($value, '/^.{' . $min . ',' . $max . '}$/us', $errorMsg);
	}

	/**
	 * Validate input element is an array
	 *
	 * @param $array
	 * @param string $errorMsg
	 *
	 * @throws InvalidArgumentException
	 */
	public static function validateIsArray($array, $errorMsg) {
		if (!is_array($array)) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Validate input element is an array and contains only object of selected type
	 *
	 * @param $array
	 * @param $type
	 * @param string $errorMsg
	 *
	 * @throws InvalidArgumentException
	 */
	public static function validateIsArrayOfType($array, $type, $errorMsg) {
		self::validateIsArray($array, $errorMsg);
		foreach ($array as $element) {
			self::validateIsInstancedClass($element, $type, $errorMsg);
		}
	}

	/**
	 * Validate input element is an array and contains only strings matching pattern
	 *
	 * @param $array
	 * @param $pattern
	 * @param string $errorMsg
	 *
	 * @throws InvalidArgumentException
	 */
	public static function validateIsArrayAndMatch($array, $regex, $errorMsg) {
		self::validateIsArray($array, $errorMsg);
		if (empty($array)) {
			return;
		}
		foreach ($array as $element) {
			self::validateIsString($element, $errorMsg);
			self::validateIsMatch($element, $regex, $errorMsg);
		}
	}

	/**
	 * Validate value is instance of target Class
	 *
	 * @param <object> $object
	 * @param <class> $class
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateIsInstancedClass($object, $class, $errorMsg) {
		if (!is_object($object)) {
			throw new InvalidArgumentException($errorMsg);
		}
		if (!$object instanceof $class) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

	/**
	 * Validate range (inclusive)
	 *
	 * @param numeric $value
	 * @param numeric $from
	 * @param numeric $to
	 * @param string $errorMsg
	 * @throws InvalidArgumentException
	 */
	public static function validateRange($value, $min, $max, $errorMsg) {
		if ($value < $min || $value > $max) {
			throw new InvalidArgumentException($errorMsg);
		}
	}

}
