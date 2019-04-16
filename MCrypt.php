<?php 
/*Kriptiranje podataka i spremanje u session varijable*/
session_start(); ?>
<?php
include ("upload_file.php")
//Ključ za enkripciju
$key = md5('jed4n j4k0 v3l1k1 kljuc');

//Podaci za enkripciju
$data = $_FILES['file']['tmp_name'], $targetfolder;

//Otvori cipher Rijndael 256 u CBC modu
$m = mcrypt_module_open('rijndael-256', '', 'cbc', '');

//Stvori IV sa ispravnom dužinom
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($m), MCRYPT_DEV_RANDOM);

//Inicijalizacija enkripcije
mcrypt_generic_init($m, $key, $iv);

//Kriptiraj podatke
$data = mcrypt_generic($m, $data);

//Zatvori handler za enkripciju
mcrypt_generic_deinit($m);

//Zatvori cipher
mcrypt_module_close($m);

//Spremi podatke
$_SESSION['podaci'] = base64_encode($data);
$_SESSION['iv'] = base64_encode($iv);

//Ispiši kriptirane podatke
echo '<p>Kriptirani podaci su ' . base64_encode($data) . '.</p>';

?>