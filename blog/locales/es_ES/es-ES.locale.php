<?php
/**
 * Locale definition
 *
 * IMPORTANT: Try to keep the locale names short, they take away valuable space on the screen!
 *
 * Documentation of the keys:
 *  - 'messages': The directory where the locale's files are. (may seem redundant but allows to have fr-FR and fr-CA
 *                tap into the same language file.)
 *  - 'charset':  Character set of the locale's messages files.
 */
$locale_defs['es-ES'] = array(
		'name' => NT_('Spanish (ES) utf8'),
		'charset' => 'utf-8',
		'datefmt' => 'd.m.y',
		'timefmt' => 'H:i:s',
		'startofweek' => 1,
		'messages' => 'es_ES',
	);
?>