<?php
require_once("templates/header.php");
require_once("dao/acomodacaoDao.php");
require_once("models/message.php");
include_once("models/hospital.php");
include_once("dao/hospitalDao.php");

$acomodacaoDao = new acomodacaoDAO($conn, $BASE_URL);
$hospital_geral = new hospitalDAO($conn, $BASE_URL);
$hospitals = $hospital_geral->findGeral();

// Receber id do usuário
$id_acomodacao = filter_input(INPUT_GET, "id_acomodacao");

if (empty($id_acomodacao)) {

    if (!empty($userData)) {

        $id = $userData->id_acomodacao;
    } else {

        //$message->setMessage("Usuário não encontrado!", "error", "index.php");
    }
} else {

    $userData = $userDao->findById($id_acomodacao);

    // Se não encontrar usuário
    if (!$userData) {
        $message->setMessage("acomodacao não encontrada!", "error", "index.php");
    }
}

?>
<div id="main-container" class="container-fluid">
    <div class="row">
        <h1 class="page-title">Cadastrar acomodacao</h1>
        <p class="page-description">Adicione informações sobre a acomodacao</p>
        <form class="formulario" action="<?= $BASE_URL ?>process_acomodacao.php" id="add-acomodacao-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create">

            <div class="form-group row">
                <div class="form-group col-sm-2">
                    <label class="control-label" for="fk_hospital">Hospital</label>
                    <select class="form-control" id="fk_hospital" name="fk_hospital">
                        <option value=""></option>
                        <?php foreach ($hospitals as $hospital) : ?>
                            <option value="<?= $hospital["id_hospital"] ?>"><?= $hospital["nome_hosp"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">

                    <div class="form-group col-sm-2">
                        <label class="control-label" for="acomodacao_aco">Acomodação</label>
                        <select class="form-control" id="acomodacao_aco" name="acomodacao_aco">
                            <option value=""></option>
                            <option value="UTI">UTI</option>
                            <option value="Semi">Semi</option>
                            <option value="Apto">Apto</option>
                            <option value="Enfermaria">Enfermaria</option>
                            <option value="Uco">Uco</option>
                            <option value="Maternidade">Maternidade</option>
                            <option value="Berçário">Berçário</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="valor_aco">Valor Diária</label>
                        <!-- <input type="text" class="form-control" id="valor_aco" onKeyPress="return(moeda(this,'.',',',event))" name="valor_aco" placeholder="Digite o valor diária"> -->
                        <input type="text" class="form-control" id="valor_aco" name="valor_aco" placeholder="Digite o valor diária">
                    </div>

                </div>
                <br>
                <div>

                    <button style="margin:10px" type="submit" class="btn-sm btn-info">Cadastrar</button>
                </div>
                <br>
            </div>
        </form>
    </div>
    <!-- <script language="javascript">
        function moeda(a, e, r, t) {
            let n = "",
                h = j = 0,
                u = tamanho2 = 0,
                l = ajd2 = "",
                o = window.Event ? t.which : t.keyCode;
            if (13 == o || 8 == o)
                return !0;
            if (n = String.fromCharCode(o),
                -1 == "0123456789".indexOf(n))
                return !1;
            for (u = a.value.length,
                h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
            ;
            for (l = ""; h < u; h++)
                -
                1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
            if (l += n,
                0 == (u = l.length) && (a.value = ""),
                1 == u && (a.value = "0" + r + "0" + l),
                2 == u && (a.value = "0" + r + l),
                u > 2) {
                for (ajd2 = "",
                    j = 0,
                    h = u - 3; h >= 0; h--)
                    3 == j && (ajd2 += e,
                        j = 0),
                    ajd2 += l.charAt(h),
                    j++;
                for (a.value = "",
                    tamanho2 = ajd2.length,
                    h = tamanho2 - 1; h >= 0; h--)
                    a.value += ajd2.charAt(h);
                a.value += r + l.substr(u - 2, u)
            }
            return !1
        }
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <?php
    require_once("templates/footer1.php");
    ?>