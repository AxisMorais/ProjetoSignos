<?php include('layouts/header.php'); ?>

<div class="container mt-5">
    <h1>Resultados</h1>

    <?php
    // Verifica se a data foi informada
    if (isset($_GET['dataNascimento']) && !empty($_GET['dataNascimento'])) {
        $dataNascimento = trim($_GET['dataNascimento']);

        echo "Data de nascimento informada: $dataNascimento <br>";

        // Carrega o XML dos signos
        $signos = simplexml_load_file("signos.xml");

        // Converte a data para um objeto DateTime
        $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);

        // Se a conversão falhar, exibe erro
        if (!$dataNascimentoObj) {
            echo "Erro: Data inválida! Certifique-se de usar o formato correto (DD/MM/AAAA).";
            exit;
        }

        // Formata a data de nascimento para dia/mês
        $dataNascimentoFormatada = $dataNascimentoObj->format('d/m');
        $diaNascimentoUsuario = (int) $dataNascimentoObj->format('d');
        $mesNascimentoUsuario = (int) $dataNascimentoObj->format('m');

        echo "Data formatada: $dataNascimentoFormatada <br>";

        // Variável para armazenar o signo correspondente
        $signoEncontrado = "Desconhecido";

        // Percorre o XML e verifica em qual intervalo a data de nascimento se encaixa
        foreach ($signos->signo as $signo) {
            // Obtém os intervalos de início e fim do signo no formato dia/mês
            $dataInicio = DateTime::createFromFormat('d/m', trim($signo->dataInicio));
            $dataFim = DateTime::createFromFormat('d/m', trim($signo->dataFim));

            // Verifica se as datas foram convertidas corretamente
            if (!$dataInicio || !$dataFim) {
                echo "Erro ao converter as datas do XML.";
                exit;
            }

            // Converte os dias e meses em inteiros para comparar
            $diaInicio = (int) $dataInicio->format('d');
            $mesInicio = (int) $dataInicio->format('m');
            $diaFim = (int) $dataFim->format('d');
            $mesFim = (int) $dataFim->format('m');

            // Verifica se a data de nascimento está dentro do intervalo do signo
            if (
                ($mesNascimentoUsuario == $mesInicio && $diaNascimentoUsuario >= $diaInicio) ||
                ($mesNascimentoUsuario == $mesFim && $diaNascimentoUsuario <= $diaFim) ||
                ($mesNascimentoUsuario > $mesInicio && $mesNascimentoUsuario < $mesFim)
            ) {
                $signoEncontrado = trim($signo->descricao);
                break; // Sai do loop ao encontrar o signo correto
            }
        }

        // Exibe o signo correspondente
        echo "<h2>Seu signo é: $signoEncontrado</h2>";
    } else {
        echo "<p>Não foi possível determinar o seu signo. Verifique a data informada.</p>";
    }
    ?>

</div>

<?php include('layouts/footer.php'); ?>
