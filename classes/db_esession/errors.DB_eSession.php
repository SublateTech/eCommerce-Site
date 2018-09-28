<?PHP //Make sure there are no whitespaces before '<' on this line.
// +----------------------------------------------------------------------+
// | DB_eSession, Copyright (c) 2004 Lawrence Osiris, All Rights Reserved |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 2 of the License, or    |
// | (at your option) any later version. Read the full included license.  |
// |                                                                      |
// | This file contains all the warning and error messages used in the    |
// | DB_eSession class. The arrays are two dimensional, with the first    |
// | key being the warning/error message key, and the second is the       |
// | language code key. You must have the same warning/error message key  |
// | for each language used. So, the language code key can change but     |
// | not the warning/error message key (the first key). Leave the '%s'    |
// | in place for the class to populate with values. You can customize    |
// | these errors/warnings (but don't change the first index array keys!).|
// +----------------------------------------------------------------------+

// Start of English Error message definitions
$_lg = 'en';

$_ERR['BAD_ALGO']     [$_lg] = 'Could not assign the encryption algorithm %s' .
                               " - It's not supported. Set to something else" .
                               ".\n";

$_ERR['BAD_ENC_MODE'] [$_lg] = 'Could not assign the encryption mode %s'      .
                               ' - mode not supported. Set to something else' .
                               ".\n";

$_ERR['BAD_MODE_SUPP'][$_lg] = 'Could not assign the encryption mode %s.'     .
                               " Use class supported modes of: %s\n";

$_ERR['HANDLER_FAIL'] [$_lg] = 'While in DB_eSession constructor, execution'  .
                               " of session_set_save_handler() failed.\n";

$_ERR['CONNECT_FAIL'] [$_lg] = 'Connection to MySQL server failed. Check'     .
                               " host, username and password settings.\n";

$_ERR['SELECTDB_FAIL'][$_lg] = "Could not select MySQL database: %s\n";

$_ERR['READ_FAILED']  [$_lg] = 'Main select/read query failed. Could not read'.
                               " session data for session ID: %s\n";

$_ERR['UPDATE_FAILED'][$_lg] = 'Update failed. Could not update session' .
                               " data for session ID: %s\n";

$_ERR['INSERT_FAILED'][$_lg] = 'Insert failed. Could not insert session' .
                               " data for session ID: %s\n";

$_ERR['PARSE_ERROR']  [$_lg] = 'Data may contain single quotes without' .
                               " backslashes causing an SQL syntax error.\n";

$_ERR['INSERT_FAILED'][$_lg] = 'Insert failed. Could not insert session' .
                               " data.\n";

$_ERR['RECOMD_SLASH'] [$_lg] = "Recommend to turn on param['slash_anyway'] to".
                               " TRUE.\n";

$_ERR['DESTROY_FAIL'] [$_lg] = 'Destroy failed. Could not delete session' .
                               " data for session ID: %s\n";

$_ERR['GARBAGE_FAIL'] [$_lg] = 'Delete failed during garbage collection/' .
                               "cleanup.\n";

$_ERR['INFO_FAIL']    [$_lg] = 'Session info. query failed. Could not read' .
                               " session data for session ID: %s\n";

$_ERR['ALL_INFO_FAIL'][$_lg] = "All session information query failed.\n";

$_ERR['ACTIVE_FAIL']  [$_lg] = 'Active sessions query failed. Could not read' .
                               " session data.\n";

$_ERR['INACTIVE_FAIL'][$_lg] = 'Inactive sessions query failed. Could not read'.
                               " session data.\n";

$_ERR['A_LOCK_FAIL']  [$_lg] = 'Lock/unlock failed. Could not change session' .
                               " data for session ID: %s\n";

$_ERR['ALL_LOCK_FAIL'][$_lg] = 'Lock/unlock failed. Could not change all' .
                               " session data.\n";

$_ERR['A_DEL_FAIL']   [$_lg] = 'Delete request failed. Could not delete' .
                               " session data for session ID: %s\n";

$_ERR['ALL_DEL_FAIL'] [$_lg] = 'Delete all request failed. Could not delete' .
                               " all session data.\n";

$_ERR['ENC_OPEN_FAIL'][$_lg] = 'Could not open encryption module %s in %s' .
                               " mode for encrypting.\n";

$_ERR['ENC_KEY_LEN']  [$_lg] = 'Key length for encrypting with %s in %s' .
                               ' mode is incorrect. Use an encryption'   .
                               ' algorithm/cipher that matches the key'  .
                               " length used (%s).\n";

$_ERR['ENC_MEMORY']   [$_lg] = 'There were memory allocation problems while' .
                               " trying to encrypt with %s in %s mode.\n";

$_ERR['ENC_UNKNOWN']  [$_lg] = 'There were unknown errors while trying' .
                               " to encrypt with %s in %s mode.\n";

$_ERR['DEC_OPEN_FAIL'][$_lg] = 'Could not open encryption module %s in %s' .
                               " mode for decryption.\n";

$_ERR['DEC_KEY_LEN']  [$_lg] = 'Key length for decrypting with %s in %s' .
                               ' mode is incorrect. Use a decryption'    .
                               ' algorithm/cipher that matches the key'  .
                               " length used (%s).\n";

$_ERR['DEC_MEMORY']   [$_lg] = 'There were memory allocation problems while' .
                               " trying to decrypt with %s in %s mode.\n";

$_ERR['DEC_UNKNOWN']  [$_lg] = 'There were unknown errors while trying' .
                               " to decrypt with %s in %s mode.\n";


// Start of English Warning message definitions
$_WRN['NOT_ARRAY']    [$_lg] = 'Warning: parameter passed to class is not an' .
                               ' array. Ignoring value passed and going to'   .
                               " use defaults instead.\n";

$_WRN['SESS_LENGTH']  [$_lg] = 'Warning: Custom session ID passed is not the' .
                               ' right length. Based on current settings it'  .
                               ' should be %s characters long. Ignoring'      .
                               " value passed [%s].\n";

$_WRN['SESS_INVALID'] [$_lg] = 'Warning: Custom session ID passed is invalid.'.
                               ' It must be alphanumeric. Ignoring value' .
                               " passed [%s].\n";

$_WRN['NEW_SESS_ID']  [$_lg] = "Assigning a new session ID.\n";

$_WRN['NAME_INVALID'] [$_lg] = 'Warning: Session configuration option' .
                               ' [session.name] must be alphanumeric.' .
                               " Ignoring value passed [%s].\n";

$_WRN['NOT_SECURE']   [$_lg] = 'Warning: You are setting session.cookie_secure'.
                               ' for use over secure connections, however, the'.
                               ' current connection is not secure. Not going'  .
                               " to override your setting.\n";

$_WRN['SESS_OPTION']  [$_lg] = 'Warning: Session configuration option' .
                               " [session.%s] could not be assigned [%s].\n";

$_WRN['URL_TAGS']     [$_lg] = 'Warning: Configuration option [url_rewriter.' .
                               "tags] could not be assigned [%s].\n";

$_WRN['HEADER_SENT_1'][$_lg] = 'Warning: HTTP headers have already been sent' .
                               " to the browser in %s on line %s. Don't send" .
                               ' ANY HTML output to the browser before'       .
                               ' creating an object instance of DB_eSession'  .
                               ' class. Find and stop the HTML output or use' .
                               " output buffering with ob_start() option.\n";

$_WRN['HEADER_SENT_2'][$_lg] = 'Warning: HTTP headers have already been sent' .
                               " to the browser. Don't send"                  .
                               ' ANY HTML output to the browser before'       .
                               ' creating an object instance of DB_eSession'  .
                               ' class. Find and stop the HTML output or use' .
                               " output buffering with ob_start() option.\n";

$_WRN['NO_SESS_INFO'] [$_lg] = 'Warning: No session data found while doing' .
                               " session info. query on session ID: %s\n";

$_WRN['NO_SESS_INFO2'][$_lg] = 'Warning: No session data found while doing' .
                               " an all session information query.\n";

$_WRN['SITE_WARN']    [$_lg] = 'This site is protected by DB_eSession. Care'  .
                               ' is taken to secure privacy. Do not give or'  .
                               ' email someone a URL/Link from this site that'.
                               " contains your personal session information.\n";

$_WRN['CLOSEDB_FAIL'] [$_lg] = "Could not close MySQL database: %s\n";



// Can put another language Error message definitions here (i.e. fr = French)
$_lg = 'fr';

$_ERR['BAD_ALGO']     [$_lg] = "N'a pas pu assigner l'algorithme de chiffrage".
                               " %s - Il n'est pas soutenu.  Placez à" .
                               " autre chose.\n";

$_ERR['BAD_ENC_MODE'] [$_lg] = ".............................................";

//.........

$_ERR['DEC_UNKNOWN']  [$_lg] = ".............................................";


// Can put another language Warning message definitions here (i.e. fr = French)
$_WRN['NOT_ARRAY']    [$_lg] = "Avertissement:  le paramètre passé à la" .
                               " classe n'est pas rangée.  Ignorant la valeur".
                               " passée et allant à employez les défauts à la".
                               " place.\n";

$_WRN['SESS_LENGTH']  [$_lg] = ".............................................";

//.........

$_WRN['CLOSEDB_FAIL'] [$_lg] = ".............................................";



return 'LOAD_OK';   // Leave this here (do not remove)
// Make sure there are no whitespaces after the '>' character on the last line.
?>