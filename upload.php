<?php 
/*Kriptiranje podataka i spremanje u session varijable*/
session_start(); ?>

<?php

 $targetfolder = "testupload/";

 $targetfolder = $targetfolder . basename( $_FILES['file']['name']) ;

 $ok=1;

$file_type=$_FILES['file']['type'];

if ($file_type=="application/pdf" || $file_type=="image/png" || $file_type=="image/jpeg") {

 if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder))

 {
//Ključ za enkripciju
$key = md5('jed4n j4k0 v3l1k1 kljuc');

//Podaci za enkripciju
$data = $_FILES['file']['tmp_name'];

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

if (isset($_SESSION['podaci'], $_SESSION['iv'])) {

	//Stvori ključ
	$key = md5('jed4n j4k0 v3l1k1 kljuc');
	
	//Otvori cipher Rijndael 256 u CBC modu
	$m = mcrypt_module_open('rijndael-256', '', 'cbc', '');
	
	//Dekodiraj IV
	$iv = base64_decode($_SESSION['iv']);
	
	//Inicijalizacija enkripcije
	mcrypt_generic_init($m, $key, $iv);
	
	// Dekriptiraj podatke:
	$data = mdecrypt_generic($m, base64_decode($_SESSION['podaci']));
	
	//Zatvori handler za enkripciju
	mcrypt_generic_deinit($m);
	
	//Zatvori cipher
	mcrypt_module_close($m);
	
	//Ispiši podatke
	echo '<p>Dekriptirani podaci su "' . trim($data) . '".</p>';

} else {
	echo '<p>Nema podataka.</p>';
}

 echo "The file ". basename( $_FILES['file']['name']). " is uploaded";

 }

 else {

 echo "Problem uploading file";

 }

}

else {

 echo "You may only upload PDFs, JPEGs or GIF files.<br>";

}

?>