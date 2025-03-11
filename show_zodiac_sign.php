<?php include('layouts/header.php');?>

<div class="container mt-5">
     <h1> Características do seu signo </h1>
    
     <?php
     
     $data_nascimento = $_POST['data_nascimento'];
     $signos = simplexml_load_file("signos.xml");
     $data_nascimento = new DateTime($data_nascimento);
     $signo_encontrado = false;

     foreach ($signos -> signo as signos){
        
        $data_inicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio);
        $data_Fim = DateTimeTime::createFromFormat('d/m', (string)$signo->dataFim);

        $data_inicio->setDate($data_nascimento->format('y'), $data_inicio->format('m'),$data_inicio->format('d'));
        $data_Fim ->setDate($data_nascimento->format('y'), $data_Fim->format('m'),$data_Fim->format('d'));

        if($data_inicio > $data_Fim){
            $data_Fim-modify('+1 year');

            if($data_nascimento < $data_inicio && $data_nascimento > $data_Fim){
                continue;
            }
        }
     }

        if($data_nascimento >= $data_inicio && $data_nascimento <= $data_Fim){
            echo "<h2> Signo: </h2> <BR>";
            echo "<h2>{$signo->descricao}</h2>";
            $signo_encontrado = true;
            break;
        }
        if (! $signo_encontrado){
            echo " <p> Não foi possível encontrar o signo, Verifique a data informada. </p>"
        }

     ?>
     <a href="index.php" class"btn btn-secondery mt-3"> Voltar </a>
        
</div>

<?php include('layouts/footer.php')

