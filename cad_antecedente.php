<?php

//teste/s
require_once("templates/header.php");
require_once("dao/antecedenteDao.php");
require_once("models/message.php");

$antecedenteDao = new antecedenteDAO($conn, $BASE_URL);

// Receber id do usuário
$id_antecedente = filter_input(INPUT_GET, "id_antecedente");

if (empty($id_antecedente)) {

    if (!empty($userData)) {

        $id = $userData->id_antecedente;
    } else {

        //$message->setMessage("Usuário não encontrado!", "error", "index.php");
    }
} else {

    $userData = $userDao->findById($id_antecedente);

    // Se não encontrar usuário
    if (!$userData) {
        $message->setMessage("antecedente não encontrada!", "error", "index.php");
    }
}

?>
<div id="main-container" class="container-fluid">
    <div class="row">
        <h1 class="page-title">Cadastrar antecedente</h1>
        <p class="page-description">Adicione informações sobre a antecedente</p>
        <form class="formulario" action="<?= $BASE_URL ?>process_antecedente.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">
            <div class="form-group row">
                <div class="form-group col-sm-4">
                    <label for="antecedente_ant">Patologia</label>
                    <input type="text" class="form-control" id="antecedente_ant" name="antecedente_ant" placeholder="Digite o nome do usuário" required>
                </div>
            </div>

            <br>
            <button style="margin:10px" type="submit" class="btn-sm btn-info">Cadastrar</button>
            <br>
    </div>
    </form>
    <?php if ($cad_usuario->rowCount()) {
        unset($dados);
        $_SESSION['msg'] =  "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
        header("Location: index.php");
    } else {
        echo "<p style='color: #f00;'>Erro: Usuário não cadastrado com sucesso!</p>";
    } ?>

</div>

<script>
    function mascara(i) {

        var v = i.value;

        if (isNaN(v[v.length - 1])) { // impede entrar outro caractere que não seja número
            i.value = v.substring(0, v.length - 1);
            return;
        }

        i.setAttribute("maxlength", "14");
        if (v.length == 3 || v.length == 7) i.value += ".";
        if (v.length == 11) i.value += "-";

    }
</script>
<script>
    function mascara(i, t) {

        var v = i.value;

        if (isNaN(v[v.length - 1])) {
            i.value = v.substring(0, v.length - 1);
            return;
        }

        if (t == "data") {
            i.setAttribute("maxlength", "10");
            if (v.length == 2 || v.length == 5) i.value += "/";
        }

        if (t == "cpf") {
            i.setAttribute("maxlength", "14");
            if (v.length == 3 || v.length == 7) i.value += ".";
            if (v.length == 11) i.value += "-";
        }

        if (t == "cnpj") {
            i.setAttribute("maxlength", "18");
            if (v.length == 2 || v.length == 6) i.value += ".";
            if (v.length == 10) i.value += "/";
            if (v.length == 15) i.value += "-";
        }

        if (t == "cep") {
            i.setAttribute("maxlength", "9");
            if (v.length == 5) i.value += "-";
        }

        if (t == "tel") {
            if (v[0] == 12) {

                i.setAttribute("maxlength", "10");
                if (v.length == 5) i.value += "-";
                if (v.length == 0) i.value += "(";

            } else {
                i.setAttribute("maxlength", "9");
                if (v.length == 4) i.value += "-";
            }
        }
    }

    function mascaraTelefone(event) {
        let tecla = event.key;
        let telefone = event.target.value.replace(/\D+/g, "");

        if (/^[0-9]$/i.test(tecla)) {
            telefone = telefone + tecla;
            let tamanho = telefone.length;

            if (tamanho >= 12) {
                return false;
            }

            if (tamanho > 10) {
                telefone = telefone.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
            } else if (tamanho > 5) {
                telefone = telefone.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
            } else if (tamanho > 2) {
                telefone = telefone.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
            } else {
                telefone = telefone.replace(/^(\d*)/, "($1");
            }

            event.target.value = telefone;
        }

        if (!["Backspace", "Delete"].includes(tecla)) {
            return false;
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<?php
require_once("templates/footer1.php");
?>