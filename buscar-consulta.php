<?php
    require_once "components/topo.php";
    require_once "db/conexao.php";
?>

    <h1>Sistema Médico de Consultas - Buscar Consulta</h1>

    <form action="" method="post">
        <div class="w-33">
            <label for="data" class="form-label">Data</label>
            <input type="text" class="form-control data-form" name="data" id="data" data-mask="99/99/9999">
        </div>
        <div class="w-33">
            <label for="medico" class="form-label">Médico</label>
            <select name="medico" id="medico" class="form-control">
                <option value=""></option>
                <?php
                    $sql = "SELECT id, nome, crm FROM tbmedico ORDER BY nome";
                    $resultSetMedico = $conn->query($sql);
                    if(mysqli_num_rows($resultSetMedico) > 0){
                        while($medico = mysqli_fetch_assoc($resultSetMedico)){
                            echo "<option value ='".$medico["id"]."'>" . $medico["nome"] . " - " . $medico["crm"] . "</option>";
                        }
                    }
                ?>
            </select>
        </div>
        <div class="w-33">
            <label for="paciente" class="form-label">CPF do paciente</label>
            <input type="text" class="form-control" name="cpf" id="cpf" data-mask="999.999.999-99">
        </div>
        <div class="clear"></div>
        <input type="submit" value="Consultar" class="btn btn-save" id="btnfind">
    </form>

    <div id="resultado" style="display: none">
        <table id="myTable" class="my-table">
            <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>MÉDICO</th>
                    <th>ESPECIALIDADE</th>
                    <th>DATA / HORA</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <script src="js/mascara.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.7/dayjs.min.js" integrity="sha512-hcV6DX35BKgiTiWYrJgPbu3FxS6CsCjKgmrsPRpUPkXWbvPiKxvSVSdhWX0yXcPctOI2FJ4WP6N1zH+17B/sAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.7/plugin/customParseFormat.min.js" integrity="sha512-FM59hRKwY7JfAluyciYEi3QahhG/wPBo6Yjv6SaPsh061nFDVSukJlpN+4Ow5zgNyuDKkP3deru35PHOEncwsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        dayjs.extend(window.dayjs_plugin_customParseFormat)
    </script>
    <script src="js/validar.js"></script>

    <script>
        document.getElementById("btnfind").addEventListener('click', (event) => {
            event.preventDefault()
            document.querySelector("#myTable tbody").innerHTML = ""
            document.querySelector("#resultado").style.display = 'none'

            let cpf = document.getElementById("cpf").value
            let medico = document.getElementById("medico").value
            let data = document.getElementById("data").value

            let formData = new FormData()
            formData.append("cpf", cpf)
            formData.append("medico", medico)
            formData.append("data", data)

            fetch(`buscar-consulta-ajax.php`, {
                method: 'POST',
                body : formData
            })
            .then(result => result.json())
            .then(result => {
                if(result.status == "ok"){
                    if(result.dados.length > 0){
                        document.querySelector("#resultado").style.display = 'block'
                        result.dados.forEach((value, index) => {
                            document.querySelector("#myTable tbody").innerHTML += 
                            `<tr>
                                <td>${value.nomepaciente}</td>
                                <td>${value.nomemedico}</td>
                                <td>${value.especialidade}</td>
                                <td>${value.dt_consulta} ${value.hr_consulta}</td>
                                <td>${value.status}</td>
                            </tr>`
                        })
                    }
                }
            })
            .catch(error => {
                console.log(error)
                alert("Consulta não realizada.")
            })
        })
    </script>

<?php require_once "components/rodape.php"; ?>