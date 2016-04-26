<?php
/**
 * HelloWorld SpecialPage for SPARQLProxy extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialSPARQLUpdate extends SpecialPage {
	public function __construct() {
		parent::__construct( 'sparql-update' );
	}

	/**
	 * Show the page to the user
	 *
	 * @param string $sub The subpage string argument (if any).
	 *  [[Special:sparql-update/subpage]].
	 */
	public function execute( $sub ) {
		$out = $this->getOutput();

		$out->setPageTitle( $this->msg( 'sparqlproxy-update' ) );

		$out->addHelpLink( 'How to become a MediaWiki hacker' );

		$out->addWikiMsg( 'sparqlproxy-update-intro' . $sub );


	}

	protected function getGroupName() {
		return 'other';
	}
}
