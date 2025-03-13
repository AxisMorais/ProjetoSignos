<?php include('layouts/header.php'); ?>

<div class="container mt-5">
    <h1>Resultados</h1> <BR>

    <?php
    // Passo 1 - Verifica se a data foi informada
    if (isset($_GET['dataNascimento']) && !empty($_GET['dataNascimento'])) {
        $dataNascimento = trim($_GET['dataNascimento']);

       

        //Passo 2 -  Carrega o XML dos signos
        $signos = simplexml_load_file("signos.xml");

        // Passo 3 - Converte a data para um objeto DateTime
        $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);

        // Passo 3.1 Se a conversão falhar, exibe erro
        if (!$dataNascimentoObj) {
            echo "Erro: Data inválida! Certifique-se de usar o formato correto (DD/MM/AAAA).";
            exit;
        }

        //Passo 4 - Formatar a data de nascimento utilizando apenas dia e mês
        $dataNascimentoFormatada = $dataNascimentoObj->format('d/m');
        $diaNascimentoUsuario = (int) $dataNascimentoObj->format('d');
        $mesNascimentoUsuario = (int) $dataNascimentoObj->format('m');

       
        //Passo 5 -  Criar uma variável para armazenar o signo correspondente
        $signoEncontrado = "Desconhecido";
        $elementoEncontrado = "Não identificado";
       
        //Passo 6 -  Percorrer o arquivo XML e verifica em qual intervalo a data de nascimento se encaixa
        foreach ($signos->signo as $signo) {
            // Passo 6.1 - Obtém os valores nos intervalos de início e fim do signo no formato dia/mês
            $dataInicio = DateTime::createFromFormat('d/m', trim($signo->dataInicio));
            $dataFim = DateTime::createFromFormat('d/m', trim($signo->dataFim));
           
            // Passo 6.2 Verifica se as datas foram convertidas corretamente
            if (!$dataInicio || !$dataFim) {
                echo "Erro ao converter as datas do XML.";
                exit;
            }

            //Passo 6.3  Converte os dias e meses em inteiros para comparar
            $diaInicio = (int) $dataInicio->format('d');
            $mesInicio = (int) $dataInicio->format('m');
            $diaFim = (int) $dataFim->format('d');
            $mesFim = (int) $dataFim->format('m');

            //Passo 7 - Verifica se a data de nascimento está dentro do intervalo do signo
            if (
                ($mesNascimentoUsuario == $mesInicio && $diaNascimentoUsuario >= $diaInicio) ||
                ($mesNascimentoUsuario == $mesFim && $diaNascimentoUsuario <= $diaFim) ||
                ($mesNascimentoUsuario > $mesInicio && $mesNascimentoUsuario < $mesFim)
            ) {
                $signoEncontrado = trim($signo->descricao);
                $elementoEncontrado = trim($signo->elemento);
                break; // Sai do loop ao encontrar o signo correto
            }
        }

        // Passo 8 - Exibe o signo correspondente
        echo "<h2>Signo: $signoEncontrado</h2> <br>";
        echo "<h2>Elemento $elementoEncontrado</h2>";
    } else {
        echo "<p>Não foi possível determinar o seu signo. Verifique a data informada.</p>";
    }
    ?>

</div>
<?php include('layouts/footer.php'); ?>
