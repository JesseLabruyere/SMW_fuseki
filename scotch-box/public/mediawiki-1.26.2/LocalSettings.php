<?php
# This file was automatically generated by the MediaWiki 1.26.2
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "ROOMZ_wiki";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/mediawiki-1.26.2";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "http://192.168.33.10";


## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/wiki.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@192.168.33.10";
$wgPasswordSender = "apache@192.168.33.10";

$wgEnotifUserTalk = true; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = "my_wiki";
$wgDBuser = "mediawiki";
$wgDBpassword = "mediawikipassword";

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = array();

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/Names.php
$wgLanguageCode = "nl-informal";

$wgSecretKey = "06c3f2d590a027bfa620785cc30af9bbe3104b4e2f29ccaa32cee34d7909ad48";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "b1af347bfee68951";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# The following permissions were set based on your choice in the installer
$wgGroupPermissions['*']['createaccount'] = false;
$wgGroupPermissions['*']['edit'] = false;


/* Permissions for SPARQLProxy */

// use the basic user rights
$wgGroupPermissions['SPARQLProxyUser'] = $wgGroupPermissions['user'];
$wgGroupPermissions['SPARQLProxyUser']['sparql-query'] = true;
$wgGroupPermissions['SPARQLProxyUser']['sparql-update'] = false;

$wgGroupPermissions['SPARQLProxyAdmin'] = $wgGroupPermissions['user'];
$wgGroupPermissions['SPARQLProxyAdmin']['sparql-query'] = true;
$wgGroupPermissions['SPARQLProxyAdmin']['sparql-update'] = true;


## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
wfLoadSkin( 'CologneBlue' );
wfLoadSkin( 'Modern' );
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Vector' );


# Enabled Extensions. Most extensions are enabled by including the base extension file here
# but check specific extension documentation for more details
# The following extensions were automatically enabled:
wfLoadExtension( 'Cite' );
wfLoadExtension( 'CiteThisPage' );
wfLoadExtension( 'ConfirmEdit' );
wfLoadExtension( 'Gadgets' );
wfLoadExtension( 'ImageMap' );
wfLoadExtension( 'InputBox' );
wfLoadExtension( 'Interwiki' );
wfLoadExtension( 'LocalisationUpdate' );
wfLoadExtension( 'Nuke' );
wfLoadExtension( 'ParserFunctions' );
wfLoadExtension( 'PdfHandler' );
wfLoadExtension( 'Poem' );
wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'SpamBlacklist' );
wfLoadExtension( 'SyntaxHighlight_GeSHi' );
wfLoadExtension( 'TitleBlacklist' );
wfLoadExtension( 'WikiEditor' );
require_once "$IP/extensions/AccessControl/AccessControl.php";
require_once "$IP/extensions/Lockdown/Lockdown.php";
require_once "$IP/extensions/LinkedWiki/LinkedWiki.php";

# End of automatically generated settings.
# Add more configuration options below.


/**
 * --- LockDown config ---
 * Protect namespace testnamespace
 */
# define custom namespaces
define('TEST_NAMESPACE', 100);
$wgExtraNamespaces[TEST_NAMESPACE] = 'Testnamespace';

# restrict "read" permission to logged in users
$wgNamespacePermissionLockdown[TEST_NAMESPACE]['read'] = array('user');

# prevent inclusion of pages from that namespace
$wgNonincludableNamespaces[] = TEST_NAMESPACE;


/**
 * --- SMW SPARQL configuration ---
 * Use Fuseki store
 */
// Start the DB: fuseki-server.bat --update --port=3030 --loc='/var/www/public/db' /db
$smwgDefaultStore = 'SMWSparqlStore';
$smwgSparqlDatabaseConnector = 'fuseki';
$smwgSparqlQueryEndpoint = 'http://localhost:3030/db/query';
$smwgSparqlUpdateEndpoint = 'http://localhost:3030/db/update';
$smwgSparqlDataEndpoint = '';


/**
 * --- LinkedWiki configuration ---
 */
$wgLinkedWikiConfigDefaultEndpoint = "http://localhost:3030/db/query";


/**
 * --- SPARQLProxy configuration
 */
wfLoadExtension( 'SPARQLProxy' );
// Set the supported datastore endpoints
$wgSPARQLProxySparqlEndpoints = [
	[
		'name'	=> 'db',
		'query-url' => 'localhost:3030/db/query',
		'update-url' => 'localhost:3030/db/update'
	]
];


/**
 * --- Mediawiki root ---
 */
enableSemantics( '192.168.33.10/mediawiki-1.26.2/' );


/**
 * --- Debuggen ---
 */
error_reporting( -1 );
ini_set( 'display_errors', 1 );
$wgShowExceptionDetails = true;



