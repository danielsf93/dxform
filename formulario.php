<!DOCTYPE html>
<html>
<head>
    <title>Formulário DX</title>
    <style>
        .download-button {
            display: inline-block;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            background-color: #EE872A;
            color: #FFFFFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .download-button:hover {
            background-color: #FFA940;
        }
    </style>
    <script>
        function preencherDataEHoraAtual() {
            var dataEHoraAtual = new Date().toLocaleString().split(", ");
            document.getElementById("data").value = dataEHoraAtual[0];
            document.getElementById("horario").value = dataEHoraAtual[1];
        }
    </script>
</head>

<body onload="preencherDataEHoraAtual()">
    <font size="6" color="black" face="serif">"Formulário DX"</font></p>
    <form method="GET">
        <input type="hidden" name="limpar" value="true">
        <button type="submit">Limpar Ocorrências</button>
        <a href="mensagens.txt" download class="download-button">Baixar arquivo .txt</a>
    </form>
    <div style="margin-top:30px;width:360px;height:310px;padding:20px;border-radius:10px;border:10px solid #EE872A;font-size:120%;">
    <form method="POST">
        <label for="horario">Horário*:</label>
        <input type="text" name="horario" id="horario" required>
        <br>
        <label for="data">Data*:</label>
        <input type="text" name="data" id="data" required>
        <br>
        <label for="local">Local*:</label>
        <input type="text" name="local" id="local" required>
        <br>
        <label for="frequencia">Frequência*:</label>
        <input type="number" name="frequencia" id="frequencia" required>
        <br>
        <label for="emissora">Emissora:</label>
        <input type="text" name="emissora" id="emissora">
        <br>
        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" id="idioma">
        <br>
        <label for="pais">País:</label>
        <input type="text" name="pais" id="pais">
        <br>
        <label for="equipamento">Equipamento*:</label>
        <input type="text" name="equipamento" id="equipamento" required>
        <br>
        <label for="antena">Antena:</label>
        <input type="text" name="antena" id="antena">
        <br>
        <label for="observacao">Observação:</label>
        <input type="text" name="observacao" id="observacao">
        <br>
        <label for="distancia">Distância:</label>
        <input type="text" name="distancia" id="distancia">
        <br>
        <label for="alvo">Alvo:</label>
        <input type="text" name="alvo" id="alvo">
        <br>
        
        <button type="submit">Salvar</button> 
    </form>

    <?php
    session_start(); // Inicia a sessão

    // Verifica se existe um array de mensagens na sessão
    if (!isset($_SESSION['mensagens'])) {
        $_SESSION['mensagens'] = array(); // Se não existir, cria um novo array
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar se os campos obrigatórios estão presentes e não estão vazios
        $campos_obrigatorios = array('horario', 'data', 'local', 'frequencia', 'equipamento');
        $campos_preenchidos = true;

        foreach ($campos_obrigatorios as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $campos_preenchidos = false;
                break;
            }
        }

        if ($campos_preenchidos) {
            // Criar a mensagem com os campos preenchidos
            $mensagem = 'Horário: ' . $_POST['horario'] . ' ';
            $mensagem .= 'Data: ' . $_POST['data'] . '<br>';
            $mensagem .= 'Local: ' . $_POST['local'] . '<br>';
            $mensagem .= 'Frequência: ' . $_POST['frequencia'] . ' KHz' . '<br>';
            $mensagem .= 'Emissora: ' . (!empty($_POST['emissora']) ? $_POST['emissora'] : 'S/I') . '<br>';
            $mensagem .= 'Idioma: ' . (!empty($_POST['idioma']) ? $_POST['idioma'] : 'S/I') . ' ';
            $mensagem .= 'País: ' . (!empty($_POST['pais']) ? $_POST['pais'] : 'S/I') . '<br>';
            $mensagem .= 'Equipamento: ' . $_POST['equipamento'] . '<br>';
            $mensagem .= 'Antena: ' . (!empty($_POST['antena']) ? $_POST['antena'] : 'S/I') . '<br>';
            $mensagem .= 'Observação: ' . (!empty($_POST['observacao']) ? $_POST['observacao'] : 'S/I') . '<br>';
            $mensagem .= 'Distância: ' . (!empty($_POST['distancia']) ? $_POST['distancia'] : 'S/I') . '<br>';
            $mensagem .= 'Alvo: ' . (!empty($_POST['alvo']) ? $_POST['alvo'] : 'S/I') . '<br>';
            
            // Função para obter os metros correspondentes à frequência
            function obterMetros($frequencia) {
                if ($frequencia >= 1800 && $frequencia <= 2000) {
                    return '160m - Utilizada por radioamadores';
                } elseif ($frequencia >= 2300 && $frequencia <= 2495) {
                    return '120m - Onda tropical';
                } elseif ($frequencia >= 3200 && $frequencia <= 3400) {
                    return '90m - Onda tropical';
                } elseif ($frequencia >= 3900 && $frequencia <= 4000) {
                    return '75m - Utilizada por radioamadores em 75/80m';
                } elseif ($frequencia >= 4750 && $frequencia <= 5060) {
                    return '60m - Onda tropical';
                } elseif ($frequencia >= 5900 && $frequencia <= 6200) {
                    return '49m - Uma das mais utilizadas nas Américas';
                } elseif ($frequencia >= 7100 && $frequencia <= 7350) {
                    return '40m/41m - Utilizada por radioamadores em 40m';
                } elseif ($frequencia >= 9400 && $frequencia <= 9900) {
                    return '31m - Uma das mais usadas no mundo';
                } elseif ($frequencia >= 11600 && $frequencia <= 12100) {
                    return '25m';
                } elseif ($frequencia >= 13570 && $frequencia <= 13870) {
                    return '22m - Bastante usada na Ásia e na Europa';
                } elseif ($frequencia >= 15100 && $frequencia <= 15800) {
                    return '19m';
                } elseif ($frequencia >= 17480 && $frequencia <= 17900) {
                    return '16m';
                } elseif ($frequencia >= 18900 && $frequencia <= 19020) {
                    return '15m - Utilizada em transmissão DRM';
                } elseif ($frequencia >= 21450 && $frequencia <= 21850) {
                    return '13m';
                } elseif ($frequencia >= 25600 && $frequencia <= 26100) {
                    return '11m - Utilizada em transmissão DRM local';
                } elseif ($frequencia >= 26805 && $frequencia <= 27999) {
                    return '11m - Utilizada para Faixa do Cidadão';
                } elseif ($frequencia >= 28000 && $frequencia <= 29700) {
                    return '10m - Utilizada por radioamadores';
                } else {
                    return 'S/I';
                }
            }
            
            $frequencia = isset($_POST['frequencia']) ? intval($_POST['frequencia']) : 0;
            $metros = obterMetros($frequencia);
            
            // Adicionar a informação dos metros à mensagem
            $mensagem .= 'Faixa: ' . $metros . '<br>';

            // Adicionar a mensagem ao array de mensagens na sessão
            $_SESSION['mensagens'][] = $mensagem;

            // Redirecionar para a mesma página para evitar reenvio do formulário
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Exibir as mensagens acumuladas
    foreach ($_SESSION['mensagens'] as $mensagem) {
        echo '<p>' . $mensagem . '</p>';
    }

    // Botão "Salvar"
    if (!empty($_SESSION['mensagens'])) {
        $mensagensText = implode("\n\n", $_SESSION['mensagens']); // Concatena as mensagens em um único texto separado por duas quebras de linha
        $fileContent = "Mensagens:\n\n" . $mensagensText; // Conteúdo do arquivo .txt
        
        $fileName = 'mensagens.txt';
        $filePath = __DIR__ . '/' . $fileName; // Caminho completo para o arquivo .txt

        echo '<a href="' . $fileName . '" download="' . $fileName . '">Baixar arquivo .txt</a>'; // Link para download do arquivo

        file_put_contents($filePath, $fileContent); // Salva o conteúdo no arquivo .txt
    }

    // Botão "Limpar"
    if (isset($_GET['limpar']) && $_GET['limpar'] === 'true') {
        $_SESSION['mensagens'] = array(); // Limpa o array de mensagens na sessão
        header("Location: {$_SERVER['PHP_SELF']}"); // Redireciona para a mesma página
        exit; // Encerra o script
    }
    ?>
   

</body>
</html>

