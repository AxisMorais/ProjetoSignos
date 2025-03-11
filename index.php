
<?php include('layouts/header.php'); ?>

<main> <!--Criação da sessão principal section main-->
    <p class="formatacaoParagrafo animated fadeInUp"> Portal dos Signos </p> 
    <hr>
    <div class = "container">
        <p>Informe abaixo a  data de nascimento: </p>
        <form form method="get" action="show_zodiac_sign.php">
            <input type="texto" id="inputData" placeholder="Ex: 15/02/2002 " name="dataNascimento">
            <button type="submit" id="botao">Enviar </button> 
        </form>
        
    </div> 
    
</main>
