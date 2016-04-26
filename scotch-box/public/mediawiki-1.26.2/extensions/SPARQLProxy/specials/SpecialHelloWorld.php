<?php
/**
 * HelloWorld SpecialPage for SPARQLProxy extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialHelloWorld extends SpecialPage {
	public function __construct() {
		parent::__construct( 'HelloWorld' );
	}

	/**
	 * Show the page to the user
	 *
	 * @param string $sub The subpage string argument (if any).
	 *  [[Special:HelloWorld/subpage]].
	 */
	public function execute( $sub ) {
		$out = $this->getOutput();

		//$out->setPageTitle( $this->msg( 'sparqlproxy-helloworld' ) );

		$out->addHelpLink( 'How to become a MediaWiki hacker' );

		$out->addWikiMsg( 'sparqlproxy-helloworld-intro' );
	}

	protected function getGroupName() {
		return 'other';
	}
}