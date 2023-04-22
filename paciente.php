<?php require_once "components/topo.php"; ?>

    <h1>Sistema Médico de Consultas - Paciente</h1>

    <?php require_once "components/message.php"; ?>

    <form action="paciente-save.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome">
        </div>
        <div>
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" name="cpf" id="cpf">
        </div>
        <div>
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control">
        </div>

        <input type="submit" value="Salvar" class="btn btn-save">

    </form>

<?php require_once "components/rodape.php"; ?>