<?php
    require_once "components/topo.php";
    require_once "db/conexao.php";
    require_once "util/funcao.php";

    $id = mysqli_escape_string($conn, $_GET["id"]);

    $sqlConsulta = "SELECT m.nome nomemedico, m.crm crmmedico, c.id idconsulta, c.dt_consulta, c.hr_consulta,
                    e.especialidade, p.nome nomepaciente, p.cpf cpfpaciente
                    FROM tbconsulta c
                    INNER JOIN tbmedico m ON m.id = c.medico_id
                    INNER JOIN tbpaciente p ON p.id = c.paciente_id
                    INNER JOIN tbespecialidade e ON e.id = c.especialidade_id
                    WHERE c.id = " . $id;

    $resultSetConsulta = $conn->query($sqlConsulta);
    if(mysqli_num_rows($resultSetConsulta) != 1){
        $conn->close();
        header("location: buscar-consulta.php?m=" . base64_encode("Consulta não encontrada"));
    }

    $consulta = mysqli_fetch_array($resultSetConsulta);
?>

<link href="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/css/suneditor.min.css" rel="stylesheet">
<!-- <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/assets/css/suneditor.css" rel="stylesheet"> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/suneditor@latest/assets/css/suneditor-contents.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/suneditor@latest/dist/suneditor.min.js"></script>

    <h1>Sistema Médico de Consultas - Realizar Consulta</h1>

    <p id="detalhes">
        <form action="realizar-consulta-save.php" method="post">
            <input type="hidden" name="idconsulta" value="<?=$consulta["idconsulta"]?>">
            <div>
                <label class="form-label">Paciente:</label>
                <?=$consulta["nomepaciente"] . "/" . $consulta["cpfpaciente"]?>
            </div>
            <div>
                <label class="form-label">Médico:</label>
                <?=$consulta["nomemedico"] . "/" . $consulta["crmmedico"] . "/" . $consulta["especialidade"]?>
            </div>
            <div>
                <label class="form-label">Data da consulta:</label>
                <?=convertDate($consulta["dt_consulta"], "-", "/")?>
            </div>
            <div>
                <label class="form-label">Hora da consulta:</label>
                <?=$consulta["hr_consulta"]?>
            </div>
            <div>
                <label class="form-label">Consulta médica</label>
                <textarea name="consulta_medica" id="consulta_medico" class="form-control"></textarea>
            </div>
            <input type="submit" value="Salvar consulta" class="btn btn-save">
        </form>
    </p>

<script>
    const editor = SUNEDITOR.create((document.getElementById('consulta_medico') || 'consulta_medico'),{
        font : [
            'Arial',
            'tohoma',
            'Courier New, Courier'
        ],
        fontSize : [
            8, 10, 14, 18, 24, 36
        ],
        colorList : [
            ['#ccc', '#dedede', 'OrangeRed', 'Orange', 'RoyalBlue', 'SaddleBrown'],
            ['SlateGray', 'BurlyWood', 'DeepPink', 'FireBrick', 'Gold', 'SeaGreen'],
        ],
        buttonList : [
            ['font', 'fontSize', 'formatBlock',
            'bold', 'underline', 'italic', 'strike', 'subscript', 'superscript',
            'fontColor', 'hiliteColor', 'textStyle'],
        ],
    });

    editor.onChange = function(e, core){
        document.getElementById("consulta_medico").value = e
    }

</script>

<?php require_once "components/rodape.php"; ?>