<?php
$target_dir = "";
if ( $_GET["sekret"] == "twoje_haslo" )
{
$target_dir = "twoj_katalog/";
}
else 
{
  die("ACCESS DENIED: Dostęp tylko do uprawnionych osób!");
}

$target_file = $target_dir . $_GET["filename"];

if (file_exists($target_file)) {
    unlink($target_file);
    die("Plik został usunięty pomyślnie !");
}
else
{
   die("Błąd");
}

?>
