<?php


define(TRANSLATIONS_PATH, '/path/to/translations/directory/');

// :: CZECH ::
$cs = array(
	'log in' => 'Přihlásit se',
	'' => '',

);


// :: ENGLISH ::
$en = array(
	'log in' => 'Log in',
	'' => '',
);



$cs = (object) $cs;
$fh = fopen(TRANSLATIONS_PATH . 'cs.trs', 'w');
if(fwrite($fh, json_encode($cs)))
	echo 'CS vygenerovan<br>';

$en = (object) $en;
$fh = fopen(TRANSLATIONS_PATH . 'en.trs', 'w');
if(fwrite($fh, json_encode($en)))
	echo 'EN vygenerovan<br>';
	
	
die('Pokud chces prekladat, navstiv zdrojak tohoto scriptu.');