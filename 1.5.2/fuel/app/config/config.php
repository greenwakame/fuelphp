<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.5
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * If you want to override the default configuration, add the keys you
 * want to change here, and assign new values to them.
 */

return array(
    'language' => 'ja',
    'locale' => 'ja_JP.utf8',
    'default_timezone' => 'Asia/Tokyo',

    'packages' => array(
    'orm',
    'auth',

	'Fuel\\Core\\View',
	'Fuel\\Core\\ViewModel',
	'Closure',
	'Fuel\\Core\\Validation',

    'input_filter' => array(
        'MyInputFilters::check_encoding',
        'MyinputFilters::check_control',
        ),
	),
);
