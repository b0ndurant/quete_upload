<?php

$isupload = true;

if (isset($_POST['envoyer'])) {
    for ($i = 0; $i < count($_FILES['monfichier']['name']); $i++) {
        $tmpFilepath = $_FILES['monfichier']['tmp_name'][$i];
        $types = array("image/png", "image/gif","image/jpg");

        if ($_FILES['monfichier']['size'][$i] > 1000000) {
            echo "fichier trop gros";
        }
        elseif (!in_array($_FILES['monfichier']['type'][$i], $types)){
            echo "mauvais format ";
        }
        else {
            $fileName = "uploads/" . 'image' . rand() . '.' . pathinfo($_FILES['monfichier']['name'][$i], PATHINFO_EXTENSION);
            move_uploaded_file($tmpFilepath, $fileName);
        }
    }
    if ($isupload)
        echo "ficier envoyer";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>laisse pas trainer ton file</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Latest compiled and minified Bootstrap CSS files -->
</head>
<body>
<section>
    <form enctype="multipart/form-data" action="" method="post">
        <p>
            Formulaire d'envoi de fichier :<br/>
            <input type="file" name="monfichier[]" multiple="multiple" /><br/>
            <input type="submit" name="envoyer" value="envoyer" />
        </p>
    </form>
</section>
<section>



    <div class="row">
        <?php
        $allImages = scandir('uploads/');
        $images = array_diff($allImages, array('.','..'));

        if (!empty($_GET['image'])) {
            if (file_exists('uploads/'.$_GET['image'])) {
                $deleteResult = unlink('uploads/'.$_GET['image']);
                header('Location: index.php');
            }
        }

        foreach ($images as $image): ?>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="<?= 'uploads/'.$image ?>" alt="<?= $image ?>">
                    <div class="caption">
                        <h3><?= $image ?></h3>
                        <p><a href="?image=<?= $image ?>" class="btn btn-danger" role="button">Supprimer</a></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</section>
</html>
