<?php
use GuzzleHttp\Client;

/**
 * HelloWorld SpecialPage for SPARQLProxy extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialSPARQLQuery extends SpecialPage {
	public function __construct() {
		parent::__construct( 'sparql-query' );
	}

	/**
	 * @override
	 * Get called before the execute function.
	 *
	 * @param string|null $sub The subpage string argument (if any).
	 * [[Special:sparql-query/subpage]].
	 */
	protected function beforeExecute( $sub ) {
	}

	/**
	 * @override
	 * Show the page to the user
	 *
	 * @param string|null $sub The subpage string argument (if any).
	 *  [[Special:sparql-query/subpage]].
	 */
	public function execute( $sub ) {
		$values = $this->getRequest()->getQueryValues();

		// How do global configuration variables work in mediawiki $test = $wgSPARQLProxySparqlEndpoints;


		if (isset($values['query'])) {
			echo $this->executeSPARQLQuery($values['query'], (isset($values['output']) ? $values['output'] : "json"), (isset($values['stylesheet']) ? $values['stylesheet'] : ""));
			die;
		} else {
			$this->generatePage();
		}
	}

	/**
	 * Generate the elements on this page
	 */
	public function generatePage() {
		$out = $this->getOutput();
		$out->setPageTitle( $this->msg( 'sparqlproxy-query' ) );
		$out->addWikiMsg( 'sparqlproxy-query-intro' );
	}

	protected function getGroupName() {
		return 'other';
	}

	/**
	 * Execute a SPARQLQuery and return the results.
	 * @param String $query the query given as url-parameter.
	 * @param String $output the output type: text, json, xml, csv, tsv
	 * @param String $stylesheet the stylesheet: /xml-to-html, /xml-to-html-links, /xml-to-html-plain
	 *
	 * @return String a string with the query results
	 */
	protected function executeSPARQLQuery($query, $output, $stylesheet) {
		$httpClient = new Client();
		$result = $httpClient->request('GET', 'localhost:3030/db/query', [
			'query' => ['query' => $query, 'output' => $output, 'stylesheet' => $stylesheet]
		]);
		return $result->getBody()->getContents();
	}
}
