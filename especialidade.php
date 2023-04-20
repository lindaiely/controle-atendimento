<?php require_once "components/topo.php"; ?>

    <h1>Sistema Médico de Consultas - Especialidades</h1>

    <?php require_once "components/message.php"; ?>

    <form action="especialidade-save.php" method="post">
        <div>
            <label for="">Especialidade:</label>
            <input type="text" name="especialidade" id="especialidade">
        </div>
        <input type="submit" value="Salvar" class="btn btn-save">
    </form>

    <?php
        require_once "db/conexao.php";

        $sql = "SELECT id, especialidade FROM tbespecialidade";
        $rsEspecialidade = $conn->query($sql);
        if(mysqli_num_rows($rsEspecialidade) > 0){
    ?>

    <table class="my-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ESPECIALIDADE</th>
            </tr>
        </thead>
        <tbody>
            <?php while($especialidade = mysqli_fetch_assoc($rsEspecialidade)){ ?>
                <tr>
                    <td><?=$especialidade["id"]?></td>
                    <td><?=$especialidade["especialidade"]?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php } ?>

<?php require_once "components/rodape.php"; ?>