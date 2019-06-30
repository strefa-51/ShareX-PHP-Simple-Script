<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$target_dir = "";
if ( $_GET["sekret"] == "twoje_haslo" )
{
$target_dir = "twoj_katalog/";
}
else 
{
  die("ACCESS DENIED: Dostęp tylko do uprawnionych osób!");
}

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}



$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


$errors = "";
$headers = apache_request_headers();

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $errors = $errors . "Błąd 1: To jest nie prawidłowy obrazek";
    }
}


if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $uploadOk = 0;
    $errors = $errors . "Błąd 2: Format pliku nie prawidłowy dozwolone: JPG,PNG,JPEG,GIF";
} else {
    $formatimage = 1;
}


if ($uploadOk == 0) {
    header('Content-Type: application/json');
    $data = new stdClass(); 
    $data->status = "0";
    $data->message = "Lista błędów: " . $errors;
     

    $json = json_encode($data);
    echo $json;
    die();
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $data = new stdClass(); 
    header('Content-Type: application/json');
        $data->status = "1";
        $data->url = "https://" . $headers['Host'] . "/" . $target_dir . $_FILES["fileToUpload"]["name"];
        $data->del_url = "https://" . $headers['Host'] . "/sharex_delete.php?sekret=".$_GET["sekret"]."&filename=". $_FILES["fileToUpload"]["name"];
    $json = json_encode($data);
    echo $json;

    } else {
    $data = new stdClass(); 
    header('Content-Type: application/json');
    $data->status = "0";
    $data->message = "Nieznany błąd";
    
    $json = json_encode($data);
    echo $json;

    die();
    }
}
}
else
{
   die("POST ONLY");
}



?>
