<?php

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'SPARQLProxy' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['SPARQLProxy'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['SPARQLProxyAlias'] = __DIR__ . '/SPARQLProxy.i18n.alias.php';
	$wgExtensionMessagesFiles['SPARQLProxyMagic'] = __DIR__ . '/SPARQLProxy.i18n.magic.php';
	wfWarn(
		'Deprecated PHP entry point used for SPARQLProxy extension. Please use wfLoadExtension ' .
		'instead, see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return true;
} else {
	die( 'This version of the SPARQLProxy extension requires MediaWiki 1.25+' );
}
