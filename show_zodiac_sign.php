<?php include('layouts/header.php');?>

<div class="container mt-5">
    <h1> Resultados </h1>
    
    <?php
         /* Paso 1 - Garatir que tenha valores no campo de data de nascimento
            Na condicional IF temos a função isset, ela serve para verificar se  a 
            data de nascimento foi definida caso tenha uma data ela retorna True. 
            Já o !empty verifica se não está vazio
         */
          if (isset($_GET['dataNascimento']) && !empty($_GET['dataNascimento'])) {
            $dataNascimento = $_GET['dataNascimento'];
            echo "Data de nascimento informada: $dataNascimento <br>";

           //Passo 2 - Carregar os arquivos XMl 
           $signos = simplexml_load_file("signos.xml");
             
       
            /* Passo 3 - Manipular a variável data utilizando o  DateTime::createFromFormat()
               DateTime::createFromFormat() é um método estático da classe DateTime em PHP,
               utilizado para criar um objeto DateTime a partir de uma string de data fornecida, 
               com base no formato especificado, É a classe que fornece métodos 
               para manipulação de datas e horas em PHP.. 
            
              Os 4 pontinhos ::  É chamado de  Operador de Resolução de Escopo
              O operador :: é utilizado para chamar métodos estáticos ou acessar propriedades estáticas 
              de uma classe. No caso, o método createFromFormat() é estático, então ele é chamado 
              diretamente pela classe DateTime, sem a necessidade de criar uma instância da classe. 

            */
            //Passo 3.1  Padronizando os formatos. 
            $dataNascimento = DateTime::createFromFormat('d/m/Y', $dataNascimento);
            $dataNascimentoFormatada = $dataNascimento->format('d/m');

            /*Passo 4 Criar variáveis para rececer as datas início e fim do xml e compará-las 
             com o que foi informado pelo usuário; 
             */
            $signoEncontrado = false;
            foreach ($signos->signo as $signo) {
                $dataInicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio);
                $dataFim = DateTime::createFromFormat('d/m', (string)$signo->dataFim);
                echo " $signo->descricao <br> ";

              // Passo 5 Verificar se a data de nascimento está dentro do intervalo do signo
              if (($dataNascimentoFormatada >= $dataInicio->format('d/m')) && ($dataNascimentoFormatada <= $dataFim->format('d/m'))) {
                echo "<p>Seu signo é: " . $signo->descricao . "</p>";
                $signoEncontrado = true;
                break;
            }
        }



          }else {
            echo "<p>Não foi possível determinar o seu signo. Verifique a data informada.</p>";
          }
    ?>
   
 
</div>

<?php include('layouts/footer.php'); ?>

