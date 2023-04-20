<?php require_once "components/topo.php"; ?>

    <h1>Sistema Médico de Consultas - Especialidades</h1>

    <form action="especialidade-save.php" method="post">
        <div>
            <label for="">Especialidade:</label>
            <input type="text" name="especialidade" id="especialidade">
        </div>
        <input type="submit" value="Salvar" class="btn btn-save">
    </form>

    <table class="my-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ESPECIALIDADE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>-</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>

<?php require_once "components/rodape.php"; ?>