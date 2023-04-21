<?php require_once "components/topo.php"; ?>

    <h1>Sistema Médico de Consultas - Médico</h1>

    <?php require_once "components/message.php"; ?>

    <form action="medico-save.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id">
        <div>
            <label>CRM</label>
            <input type="text" name="crm" id="crm" class="form-control">
        </div>
        <div id="telamedico" style="display: none">
            <div>
                <label class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control">
            </div>
            <div>
                <label class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>

            <?php 
                require_once "db/conexao.php";

                $sql = "SELECT id, especialidade FROM tbespecialidade";
                $rsEspecialidade = $conn->query($sql);
                if(mysqli_num_rows($rsEspecialidade) > 0){
                    while($especialidade = mysqli_fetch_assoc($rsEspecialidade)){
                ?>
                    <div>
                        <input type="checkbox" name="especialidades" id="especialidade<?=$especialidade["id"]?>"
                            value="<?=$especialidade["id"]?>">
                            <label for="especialidade<?=$especialidade["id"]?>"><?=$especialidade["especialidade"]?></label>
                    </div>
                <?php
                    }
                }
            ?>

            <input type="submit" value="Salvar" class="btn btn-save">
        </div>
    </form>

    <script>
        document.getElementById("crm").addEventListener("blur", (event) => {
            let valueCrm = event.target.value
            let nome = document.getElementById("nome")
            let id = document.getElementById("id")

            nome.value = "";
            id.value = "";

            if(valueCrm != ''){

                let = formData = new FormData()
                formData.append("crm", valueCrm)

                fetch('buscar-crm.php', {
                    method : 'POST',
                    body : formData
                })
                .then( result => result.json())
                .then(result => {
                    if(result.status == "ok"){
                        nome.value = result.medico.nome
                        id.value = result.medico.id
                    }else{
                        alert(result.message);
                    }
                })
                .catch(erro => {
                    console.log(erro)
                    document.getElementById("telamedico").style.display = "none"
                })

                document.getElementById("telamedico").style.display = "block"
            }else{
                document.getElementById("telamedico").style.display = "none"
            }
        })
    </script>

<?php require_once "components/rodape.php"; ?>