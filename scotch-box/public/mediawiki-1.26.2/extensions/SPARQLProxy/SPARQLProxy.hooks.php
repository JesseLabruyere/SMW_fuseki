<?php
/**
 * Hooks for SPARQLProxy extension
 *
 * @file
 * @ingroup Extensions
 */

class SPARQLProxyHooks {

	public static function onParserFirstCallInit( Parser &$parser ) {
		// threw error, could not find magicword 'something': $parser->setFunctionHook( 'something', 'SPARQLProxyHooks::doSomething' );
	}

	public static function doSomething( Parser &$parser ) {
		// Called in MW text like this: {{#something: }}

		// For named parameters like {{#something: foo=bar | apple=orange | banana }}
		// See: https://www.mediawiki.org/wiki/Manual:Parser_functions#Named_parameters

		return "This text will be shown when calling this in MW text.";
	}
}
