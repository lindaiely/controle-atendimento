<?php require_once "components/topo.php"; ?>

    <h1>Sistema Médico de Consultas - Buscar Usuários</h1>

    <form action="">
        <div class="w-33">
            <label class="form-label">Tipo de usuário</label>
            <select name="tipo" id="tipo" class="form-control">
                <option value="">Todos</option>
                <option value="PACIENTE">Paciente</option>
                <option value="MEDICO">Médico</option>
            </select>
        </div>
        <div class="w-33">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control">
        </div>
        <div class="w-33">
            <label class="form-label">CPF/CRM:</label>
            <input type="text" name="cpf_crm" id="cpf_crm" class="form-control">
        </div>

        <div class="clear">
            <input type="submit" value="Buscar" class="btn btn-find" id="buscarUsuario">
        </div>

    </form>

    <div id="resultado" style="display: none">
        <table id="myTable" class="my-table">
            <thead>
                <tr>
                    <th>USUÁRIO</th>
                    <th>NOME</th>
                    <th>CPF/CRM</th>
                    <th>FOTO</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <script>
        document.getElementById("buscarUsuario").addEventListener("click", (event) => {
            let resultado = document.getElementById("resultado")
            let nome = document.getElementById("nome")
            let tipo = document.getElementById("tipo")
            let cpf_crm = document.getElementById("cpf_crm")

            let formData = new FormData()
            formData.append("nome", nome.value)
            formData.append("tipo", tipo.value)
            formData.append("cpf_crm", cpf_crm.value)

            fetch('buscar-usuario-ajax.php', {
                method : 'POST',
                body : formData
            })
            .then(result => result.json())
            .then(result => {
                resultado.style.display = "block";
                document.querySelector("#myTable tbody").innerHTML = ''
                if(result.usuarios.length > 0){
                    result.usuarios.forEach((valor, index) => {
                        document.querySelector("#myTable tbody").innerHTML += 
                        `<tr>
                            <td>${ valor.tipo }</td>
                            <td>${ valor.nome }</td>
                            <td>${ valor.cpfcrm }</td>
                            <td><a href='${ valor.foto }' target='_blank'>
                                <img src='${ valor.foto }' class='imggrid'></a></td>
                        </tr>`
                    })
                }else{
                    resultado.style.display = "none";
                }
            })
            .catch(error => {
                resultado.style.display = "none";
                console.log(error)
                alert("Consulta não realizada")
            })

            event.preventDefault()
        })
    </script>

<?php require_once "components/rodape.php"; ?>