<?php
$errors=[];

if($_SERVER["REQUEST_METHOD"] === "POST" ){ 
    if(isset($_POST["user_name"]) || trim($_POST['user_name']) === ''){
        $errors[] = 'Le nom est obligatoire';
    }
    if(isset($_POST["user_firstname"]) || trim($_POST['user_firstname']) === ''){
        $errors[] = 'Le prénom est obligatoire';
    }
    $uploadDir = 'public/uploads/';
    
    $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
    
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg','png', 'gif', 'webp'];

    $maxFileSize = 1000000;

    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Png ou gif ou webp !';
    }

    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
    $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    if(empty($errors))
    {
        $uniqueFileName = uniqid('avatar') . '.' .$extension;
        $uploadFile = $uploadDir . $uniqueFileName;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
    }
    if(!empty($errors))
    {
        echo "Prénom :" . " " . ($_POST["user_firstname"]) . '</br>' . "Nom :" . " " . ($_POST["user_name"]) . '</br>';
        print_r($uploadFile);
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <label for="name">Nom :</label>
            <input type="text" name="user_name" id="name">
        </fieldset>
        <fieldset>
        <label for="firstname">Prénom :</label>
            <input type="text" name="user_firstname" id="firstname">
        </fieldset>
        <fieldset>
        <label for="imageUpload">Télécharge ta photo</label>
        <input type="file" name="avatar" id="imageUpload">
        <button name="send">Envoi</button>
        </fieldset>
    </form>
</body>
</html>