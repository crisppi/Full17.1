<?php

require_once("globals.php");
require_once("db.php");
require_once("models/antecedente.php");
require_once("models/message.php");
require_once("dao/usuarioDao.php");
require_once("dao/antecedenteDao.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$antecedenteDao = new antecedenteDAO($conn, $BASE_URL);

// Resgata o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// Resgata dados do usuário

if ($type === "create") {

    // Receber os dados dos inputs
    $antecedente_ant = filter_input(INPUT_POST, "antecedente_ant");


    $antecedente = new antecedente();

    // Validação mínima de dados
    if (!empty($antecedente_ant)) {

        $antecedente->antecedente_ant = $antecedente_ant;

        //$antecedente->id_antecedente = $userData->id_antecedente;

        // Upload de imagem do filme ****** nao usaar if para imagem *******
        /* if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checando tipo da imagem
            if (in_array($image["type"], $imageTypes)) {

                // Checa se imagem é jpg
                if (in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                // Gerando o antecedente_ant da imagem
                $imageName = $movie->imageGenerateName();

                imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                $movie->image = $imageName;
            } else {

                $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
            }
        }
*/
        $antecedenteDao->create($antecedente);
    } else {

        $message->setMessage("Você precisa adicionar pelo menos: antecedente_ant do antecedente!", "error", "back");
    }/*
} else if ($type === "delete") {
    // Recebe os dados do form
    $id_antecedente = filter_input(INPUT_POST, "id_antecedente");

    $antecedenteDao = new antecedenteDAO($conn, $BASE_URL);

    $antecedente = $antecedenteDao->findById($id_antecedente);

    if ($antecedente) {

        $antecedenteDao->destroy($id_antecedente);
    } else {

        //$message->setMessage("Informações inválidas!", "error", "index.php");
    }*/
} else if ($type === "update") {

    $antecedenteDao = new antecedenteDAO($conn, $BASE_URL);

    // Receber os dados dos inputs
    $id_antecedente = filter_input(INPUT_POST, "id_antecedente");
    $antecedente_ant = filter_input(INPUT_POST, "antecedente_ant");

    $antecedenteData = $antecedenteDao->findById($id_antecedente);

    $antecedenteData->id_antecedente = $id_antecedente;
    $antecedenteData->antecedente_ant = $antecedente_ant;

    $antecedenteDao->update($antecedenteData);

    include_once('list_antecedente.php');
}
//$type = "delete";
//$type = filter_input(INPUT_POST, "type");

if ($type === "delete") {
    // Recebe os dados do form
    $id_antecedente = filter_input(INPUT_GET, "id_antecedente");

    $antecedenteDao = new antecedenteDAO($conn, $BASE_URL);

    $antecedente = $antecedenteDao->findById($id_antecedente);

    echo $antecedente;
    if ($antecedente) {

        $antecedenteDao->destroy($id_antecedente);

        include_once('list_antecedente.php');
    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");
    }
}
