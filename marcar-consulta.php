<?php require_once "components/topo.php"; ?>

    <h1>Sistema Médico de Consultas - Marcar Consulta</h1>

    <?php
        require_once "components/message.php";
        require_once "db/conexao.php";
    ?>

    <div id="resultError"></div>
    <form action="marcar-consulta-save.php" method="post" id="my-form">
        <input type="hidden" name="idpaciente" value="" id="idpaciente">
        <div>
            <label class="form-label">Informe o CPF do paciente:</label>
            <input type="text" name="cpf" id="cpf" class="form-control">
        </div>
        <div id="resultado-paciente"></div>
        <div id="detalhes-consulta" style="display: none">
            <div class="w-50">
                <label class="form-label">Especialidade:</label>
                <select name="especialidade" id="especialidade" class="form-control">
                    <option value=""></option>
                    <?php

                        $sqlEspecialidade = "SELECT id, especialidade FROM tbespecialidade";
                        $rsEspecialidade = $conn->query($sqlEspecialidade);
                        if(mysqli_num_rows($rsEspecialidade) > 0){
                            while($especialidade = mysqli_fetch_assoc($rsEspecialidade)){
                    ?>
                        <option value="<?=$especialidade["id"]?>"><?=$especialidade["especialidade"]?></option>

                        <?php
                            }
                        }
                        ?>
                </select>
            </div>
            <div class="w-50">
                <label class="form-label">Médico:</label>
                <select name="medico" id="medico" class="form-control">
                    <option value=""></option>
                </select>
            </div>
            <div class="w-50">
                <label class="form-label">Data da consulta:</label>
                <input type="text" name="dt_consulta" id="dt_consulta" class="form-control" data-mask="99/99/9999">
            </div>
            <div class="w-50">
                <label class="form-label">Hora da consulta:</label>
                <input type="text" name="hr_consulta" id="hr_consulta" class="form-control" data-mask="99:99">
            </div>

            <input type="submit" value="Marcar consulta" class="btn btn-save salvar-consulta">
        </div>
    </form>

    <script src="js/mascara.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.7/dayjs.min.js" integrity="sha512-hcV6DX35BKgiTiWYrJgPbu3FxS6CsCjKgmrsPRpUPkXWbvPiKxvSVSdhWX0yXcPctOI2FJ4WP6N1zH+17B/sAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.7/plugin/customParseFormat.min.js" integrity="sha512-FM59hRKwY7JfAluyciYEi3QahhG/wPBo6Yjv6SaPsh061nFDVSukJlpN+4Ow5zgNyuDKkP3deru35PHOEncwsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        dayjs.extend(window.dayjs_plugin_customParseFormat)
    </script>
    <script>
        function limpar(){
            document.getElementById("idpaciente").value = ""
            document.getElementById("detalhes-consulta").style.display = 'none'
            document.getElementById("resultado-paciente").innerHTML = ""
        }

        document.getElementById("especialidade").addEventListener('change', (event) => {
            let value = event.target.value
            let comboMedico = document.getElementById("medico")
            comboMedico.length = 1
            if(value != ""){
                fetch(`marcar-consulta-medico.php?idespecialidade=${value}`)
                .then(result => result.json())
                .then(result => {
                    if(result.status == "ok"){
                        result.medicos.forEach((value, index) => {
                            let option = document.createElement("option")
                            option.value = value.id
                            option.text = value.nome

                            comboMedico.add(option)
                        })
                    }else{

                    }
                })
                .catch(error => {
                    alert("Erro ao marcar consulta")
                    console.log(error)
                })
            }else{

            }
        })

        document.getElementById("cpf").addEventListener("blur", (event) => {
            let cpf = event.target.value
            if(cpf != ""){
                fetch(`marcar-consulta-paciente.php?cpf=${cpf}`)
                .then(result => result.json())
                .then(result => {
                    if(result.status == "ok"){
                        document.getElementById("idpaciente").value = result.paciente.id
                        document.getElementById("detalhes-consulta").style.display = 'block'
                        document.getElementById("resultado-paciente").innerHTML = `Paciente: ${result.paciente.nome}
                            Preencha os campos para a consulta`
                    }else{
                        limpar()
                        document.getElementById("resultado-paciente").innerHTML = "Paciente não encontrado"
                    }
                })
                .catch(error => {
                    alert("Erro ao marcar consulta")
                    limpar()
                    console.log(error)
                })
            }else{
                limpar()
            }
        })

        document.getElementById("dt_consulta").addEventListener("blur", (event) => {
            let valor = event.target.value
            let dateValid = dayjs(valor, 'DD/MM/YYYY', true).isValid()

            if(!dateValid){
                event.target.value = ""
                alert("Preencha uma data válida")
            }
        })

        document.getElementById("hr_consulta").addEventListener("blur", (event) => {
            let valor = event.target.value
            let dateValid = dayjs(valor, 'HH:mm', true).isValid()

            if(!dateValid){
                event.target.value = ""
                alert("Preencha um horário válido")
            }
        })

        document.querySelector(".salvar-consulta").addEventListener('click', async (event) => {
            document.getElementById("resultError").innerHTML = ""
            document.getElementById("resultError").classList.remove("error")

            let idpaciente = document.getElementById("idpaciente").value
            let especialidade = document.getElementById("especialidade").value
            let medico = document.getElementById("medico").value
            let dt_consulta = document.getElementById("dt_consulta").value
            let hr_consulta = document.getElementById("hr_consulta").value

            console.log(`${idpaciente} ${especialidade} ${medico} ${dt_consulta} ${hr_consulta}`)
            let msgErro = ""

            if(idpaciente == ""){
                msgErro += "Informe um paciente.<br>"
            }

            if(especialidade == ""){
                msgErro += "Informe uma especialidade.<br>"
            }

            if(medico == ""){
                msgErro += "Informe um médico.<br>"
            }

            if(dt_consulta == ""){
                msgErro += "Informe uma data.<br>"
            }

            if(hr_consulta == ""){
                msgErro += "Informe um horário.<br>"
            }

            if(msgErro != ""){
                document.getElementById("resultError").innerHTML = msgErro
                document.getElementById("resultError").classList.add("error")
                event.preventDefault()
                return;
            }

            let formData = new FormData();
            formData.append("idpaciente", idpaciente)
            formData.append("especialidade", especialidade)
            formData.append("medico", medico)
            formData.append("dt_consulta", dt_consulta)
            formData.append("hr_consulta", hr_consulta)

            event.preventDefault() // cancelando o envio do formulario -- nao vai disparar o submit do formulario

            // executa o fetch passando os dados
            let result = await fetch('marcar-consulta-validar-ajax.php', {
                method : 'POST',
                body : formData
            })

            let dados = await result.json() // recupera o json

            // se o status do json for invalido, imprime o erro
            if(dados.status == "invalid"){
                document.getElementById("resultError").innerHTML = dados.message
                document.getElementById("resultError").classList.add("error")
            }else{
                //envia o formulário apenas se o status do json for valido 
                document.querySelector("#my-form").submit()
            }
           
        })

    </script>

<?php require_once "components/rodape.php"; ?>