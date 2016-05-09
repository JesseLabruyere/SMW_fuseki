<?php
use GuzzleHttp\Client;

/**
 * HelloWorld SpecialPage for SPARQLProxy extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialSPARQLEndpoints extends SpecialPage {

	public function __construct() {
		parent::__construct( 'sparql-endpoints' );
	}

	/**
	 * @override
	 * Get called before the execute function.
	 *
	 * @param string|null $sub The subpage string argument (if any).
	 * [[Special:sparql-endpoints/subpage]].
	 */
	protected function beforeExecute( $sub ) {
	}

	/**
	 * @override
	 * Show the page to the user
	 *
	 * @param string|null $sub The subpage string argument (if any).
	 *  [[Special:sparql-endpoints/subpage]].
	 */
	public function execute( $sub ) {
		$path = explode('/',$sub);
		$user = $this->getUser();
		if(count($path) > 1) {
			switch ($path[1]) {
				case 'query':
					if ($user->isAllowed('sparql-query')) {
						$this->query($path[0]);
					} else {
						$this->accessForbidden();
					}
					break;
				case 'update':
					if ($user->isAllowed('sparql-update')) {
						$this->update($path[0]);
					} else {
						$this->accessForbidden();
					}
					break;
			}
		}
		$this->generatePage();
	}

	/**
	 * Generate the elements on this page
	 */
	public function generatePage() {
		$out = $this->getOutput();
		$out->setPageTitle( $this->msg( 'sparqlproxy-endpoints' ) );
		$out->addWikiMsg( 'sparqlproxy-endpoints-intro' );
		$out->addWikiText($this->generateEndpointListings());
		$out->addWikiText($this->generateExampleCalls());
		$out->addWikiMsg( 'sparqlproxy-endpoints-body' );


	}

	protected function getGroupName() {
		return 'other';
	}

	/**
	 * Run a query
	 *
	 * @param String $db the target db.
	 */
	protected function query($db) {
		$values = $this->getRequest()->getQueryValues();
		$dbConfig = $this->getDBConfig($db);

		if (count($dbConfig) === 0 || !isset($dbConfig['query-url'])) {
			return;
		}

		if (isset($values['query'])) {
			echo $this->executeSPARQLQuery($values['query'], (isset($values['output']) ? $values['output'] : 'json'), (isset($values['stylesheet']) ? $values['stylesheet'] : ''), $dbConfig['query-url']);
		}

		die;
	}

	/**
	 * Execute a SPARQLQuery and return the results.
	 * @param String $query the query given as url-parameter.
	 * @param String $output the output type: text, json, xml, csv, tsv.
	 * @param String $stylesheet the stylesheet: /xml-to-html, /xml-to-html-links, /xml-to-html-plain
	 * @param String $url the url this query should be send to
	 *
	 * @return String a string with the query results.
	 */
	protected function executeSPARQLQuery($query, $output, $stylesheet, $url) {
		$httpClient = new Client();
		$result = $httpClient->request('GET', $url, [
			'query' => ['query' => $query, 'output' => $output, 'stylesheet' => $stylesheet]
		]);
		return $result->getBody()->getContents();
	}

	/**
	 * Run an update query
	 *
	 * @param String $db the target db.
	 */
	protected function update($db) {
		$values = $this->getRequest()->getQueryValues();
		$dbConfig = $this->getDBConfig($db);

		if (count($dbConfig) === 0 || !isset($dbConfig['update-url'])) {
			return;
		}

		if (isset($values['update'])) {
			echo $this->executeSPARQLUpdate($values['update'], $dbConfig['update-url']);
		}

		die;
	}

	/**
	 * Execute an update query.
	 * @param String $query the query given as POST variable.
	 * @param String $url the url this query should be send to
	 *
	 * @return String with the query response.
	 */
	protected function executeSPARQLUpdate($query, $url) {
		$httpClient = new Client();
		$result = $httpClient->request('POST', $url, [
			'form_params' => ['update' => $query]
		]);
		return $result->getBody()->getContents();
	}

	protected function getDBConfig($dbName) {
		$endpoints = $this->getConfig()->get('SPARQLProxySparqlEndpoints');

		foreach($endpoints as $config ) {
			if( $config['name'] === $dbName) {
				return $config;
			}
		}

		return [];
	}

	/**
	 * Generate a list with all the endpoints to display on the page.
	 * @return String with the generated html.
	 */
	protected function generateEndpointListings() {
		$endpoints = $this->getConfig()->get('SPARQLProxySparqlEndpoints');
		$listing = '<h2>Available endpoints</h2>';

		foreach($endpoints as $key => $config ) {
			if(isset($config['name'])) {
				$listing .= '<b>Name: </b>' . $config['name'] . '<br/>';
				$listing .= '<b>Query-url: </b>' . (isset($config['query-url']) ? '{{canonicalurl:{{FULLPAGENAMEE}}}}' . '/' . $config['name'] . '/query?query= ' .'<br/>' : 'Not configured');
				$listing .= '<b>Update-url: </b>' .(isset($config['update-url']) ? '{{canonicalurl:{{FULLPAGENAMEE}}}}' . '/' . $config['name'] . '/update?update= ' . '<br/>' : 'Not configured');
				$listing .= ($key === (count($endpoints) -1) ? '' : '<br/> <br/>');
			}
		}

		return $listing;
	}

	/**
	 * Generate example calls for the available endpoints.
	 * @return String with the generated html.
	 */
	protected function generateExampleCalls() {
		$endpoints = $this->getConfig()->get('SPARQLProxySparqlEndpoints');
		$exampleCalls = '<h2>Example calls</h2>';

		foreach($endpoints as $key => $config ) {
			if(isset($config['name'])) {
				$exampleCalls .= '<b>Name: </b>' . $config['name'] . '<br/>';
				$exampleCalls .= (isset($config['query-url']) ? '<b>Query: </b> <br/>' . '{{canonicalurl:{{FULLPAGENAMEE}}}}' . '/' . $config['name'] . '/query?query=SELECT+%3Fs+%3Fp+%3Fo%0D%0AWHERE+{%0D%0A+%3Fs+%3Fp+%3Fo%0D%0A}&output=text&stylesheet=%2Fxml-to-html.xsl' : '');
				$exampleCalls .= (isset($config['update-url']) ? '<br/> <b>Update:</b> <br/>' . '{{canonicalurl:{{FULLPAGENAMEE}}}}' . '/' . $config['name'] . '/update?update=%0A%09%09PREFIX+d%3A++++%3Chttp%3A%2F%2Fexample.com%2Fns%2Fdata%23%3E%0A%09%09PREFIX+rdfs%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F2000%2F01%2Frdf-schema%23%3E%0A%0A%09%09INSERT+DATA%0A%09%09%7B%0A%09%09++d%3Ai1+rdfs%3Alabel+%27one%27+.%0A%09%09++d%3Ai2+rdfs%3Alabel+%27two%27+.%0A%09%09%7D%0A%09%09' . '<br/>' : '');
				$exampleCalls .= ($key === (count($endpoints) -1) ? '' : '<br/> <br/>');
			}
		}

		return $exampleCalls;
	}

	/**
	 * Throw access forbidden.
	 */
	protected function accessForbidden() {
		header('HTTP/1.0 403 Forbidden');
		die('You are not allowed to access this page.');
	}
}
