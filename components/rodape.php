</section>
        <footer id="rodape">
            <p>Todos os direitos reservados - <?=date('Y')?></p>
        </footer>
    </div>
    <script>
        window.addEventListener("load", () =>{
            setTimeout(() => {
                let divMsg = document.getElementById("message")
                if(divMsg != null){
                    divMsg.classList.add("elem-hidden")
                }
            }, 3000);
        })
    </script>
</body>
</html>