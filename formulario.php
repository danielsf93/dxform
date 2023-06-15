<!DOCTYPE html>
<html>
<head>
    <title>Formulário SW</title>
    <script>
        function preencherDataEHoraAtual() {
            var dataEHoraAtual = new Date().toLocaleString().split(", ");
            document.getElementById("data").value = dataEHoraAtual[0];
            document.getElementById("horario").value = dataEHoraAtual[1];
        }
    </script>
</head>
<body onload="preencherDataEHoraAtual()">
    <h1>Formulário SW</h1>

    <form method="POST">
        <label for="horario">Horário:</label>
        <input type="text" name="horario" id="horario" required>
        <br>
        <label for="data">Data:</label>
        <input type="text" name="data" id="data" required>
        <br>
        <label for="local">Local:</label>
        <input type="text" name="local" id="local" required>
        <br>
        <label for="frequencia">Frequência:</label>
        <input type="text" name="frequencia" id="frequencia" required>
        <br>
        <label for="equipamento">Equipamento:</label>
        <input type="text" name="equipamento" id="equipamento" required>
        <br>
        <label for="emissora">Emissora:</label>
        <input type="text" name="emissora" id="emissora">
        <br>
        <label for="idioma">Idioma:</label>
        <input type="text" name="idioma" id="idioma">
        <br>
        <label for="observacao">Observação:</label>
        <input type="text" name="observacao" id="observacao">
        <br>
        <label for="pais">País:</label>
        <input type="text" name="pais" id="pais">
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
            $mensagem = 'Horário: ' . $_POST['horario'] . '<br>';
            $mensagem .= 'Data: ' . $_POST['data'] . '<br>';
            $mensagem .= 'Local: ' . $_POST['local'] . '<br>';
            $mensagem .= 'Frequência: ' . $_POST['frequencia'] . '<br>';
            $mensagem .= 'Equipamento: ' . $_POST['equipamento'] . '<br>';
            $mensagem .= 'Emissora: ' . (!empty($_POST['emissora']) ? $_POST['emissora'] : 'S/I') . '<br>';
            $mensagem .= 'Idioma: ' . (!empty($_POST['idioma']) ? $_POST['idioma'] : 'S/I') . '<br>';
            $mensagem .= 'Observação: ' . (!empty($_POST['observacao']) ? $_POST['observacao'] : 'S/I') . '<br>';
            $mensagem .= 'País: ' . (!empty($_POST['pais']) ? $_POST['pais'] : 'S/I') . '<br>';

            // Adicionar a nova mensagem ao array de mensagens na sessão
            array_unshift($_SESSION['mensagens'], $mensagem);
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

        echo '<a href="' . $fileName . '" download="' . $fileName . '">Salvar Mensagens</a>'; // Link para download do arquivo

        file_put_contents($filePath, $fileContent); // Salva o conteúdo no arquivo .txt
    }

    // Botão "Limpar"
    if (isset($_GET['limpar']) && $_GET['limpar'] === 'true') {
        $_SESSION['mensagens'] = array(); // Limpa o array de mensagens na sessão
        header("Location: {$_SERVER['PHP_SELF']}"); // Redireciona para a mesma página
        exit; // Encerra o script
    }
    ?>
    <form method="GET">
    <input type="hidden" name="limpar" value="true">
    <button type="submit">Limpar Mensagens</button>
</form>

</body>
</html>

