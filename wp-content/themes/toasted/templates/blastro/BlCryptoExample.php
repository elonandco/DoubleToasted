<?php

require_once('BlCrypto.php');

$crypto = new BlCrypto();
$crypto->setKey(pack('H*', 'a1f74cc7e95c9b27b0051fe125d07317'));

$show_sku = 'doubletoasted_20140629';

$token = 'dt:' . $crypto->encryptObject(array(
	'show_sku' => $show_sku,
	'user_id' => 1234, // Fill in with wordpress user id or username
	'client_ip' => $_SERVER['REMOTE_ADDR'],
	'expires' => time() + 86400
));

$embed_url = 'http://www.blastro.com/embed/' . urlencode($show_sku) . '.html?token=' . urlencode($token);

var_dump($embed_url);

// Decryption example to make sure it works
var_dump($crypto->decryptObject(substr($token, 3)));
