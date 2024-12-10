<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Adicionar ticket (vulnerável a SQL Injection e Path Traversal)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['description'], $_POST['severity'])) {
    $title = $_POST['title']; // Entrada não sanitizada
    $description = $_POST['description']; // Entrada vulnerável a Path Traversal
    $severity = $_POST['severity']; // Entrada não sanitizada

    // Vulnerabilidade de Path Traversal
    if (strpos($description, '../') !== false) { 
        $filePath = realpath(__DIR__ . '/' . $description); // Resolve o caminho absoluto
        echo "Tentando acessar: " . $filePath; // Depuração para verificar o caminho
    
        if (file_exists($filePath)) { // Verifica se o arquivo existe
            $fileContent = file_get_contents($filePath); // Lê o conteúdo do arquivo
            $description .= "\n[Conteúdo do Arquivo]:\n" . $fileContent; // Adiciona o conteúdo na descrição
        } else {
            echo "Arquivo não encontrado ou caminho inválido.";
        }
    }    

    try {
        // Consulta vulnerável a SQL Injection
        $query = "INSERT INTO tickets (user_id, title, description, severity, status) 
                  VALUES ('$user_id', '$title', '$description', '$severity', 'Aberto')";
        $pdo->query($query); // Consulta direta vulnerável
    } catch (PDOException $e) {
        die("Erro ao adicionar ticket: " . $e->getMessage());
    }
}

// Remover ticket (vulnerável a SQL Injection)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ticket_id'])) {
    $ticket_id = $_POST['delete_ticket_id']; // Entrada não sanitizada

    try {
        $query = "DELETE FROM tickets WHERE id = $ticket_id"; // Exclusão vulnerável a SQL Injection
        $pdo->query($query); // Exclusão sem validação de usuário
    } catch (PDOException $e) {
        die("Erro ao remover ticket: " . $e->getMessage());
    }
}

// Listar tickets (vulnerável a XSS)
try {
    $query = "SELECT * FROM tickets WHERE user_id = $user_id"; // Entrada direta na consulta SQL
    $tickets = $pdo->query($query)->fetchAll(); // Resultado exibido sem sanitização
} catch (PDOException $e) {
    die("Erro ao listar tickets: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Meus Tickets</title>
    <style>
        /* Estilo básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            height: 100vh;
        }

        header {
            width: 100%;
            background-color: #8039AA; /* Cor roxa */
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .header-links {
            display: flex;
            gap: 15px;
        }

        .header-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
        }

        .header-links a:hover {
            color: #d4a5ff; /* Roxo claro ao passar o mouse */
        }

        .content-container {
            margin: 0 auto;
            margin-top: 80px; /* Espaço abaixo do cabeçalho */
            width: 80%;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #d4a5ff; /* Roxo claro */
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #b580d1; /* Roxo mais escuro */
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border: 1px solid #cccccc;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .delete-button {
            background-color: #ff4d4d; /* Vermelho */
            border: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #cc0000; /* Vermelho escuro */
        }

        footer {
            width: 100%;
            background-color: #8039AA; /* Cor roxa */
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Meus Tickets</div>
        <div class="header-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Sair</a>
        </div>
    </header>

    <div class="content-container">
        <h2>Meus Tickets</h2>

        <!-- Formulário para adicionar ticket -->
        <form method="POST">
            <input type="text" name="title" placeholder="Título do ticket" required>
            <textarea name="description" rows="4" placeholder="Descrição do problema" required></textarea>
            <select name="severity" required>
                <option value="Baixa">Baixa</option>
                <option value="Média" selected>Média</option>
                <option value="Alta">Alta</option>
                <option value="Crítica">Crítica</option>
            </select>
            <button type="submit">Adicionar Ticket</button>
        </form>

        <!-- Lista de tickets -->
        <ul>
            <?php foreach ($tickets as $ticket): ?>
                <li>
                    <!-- Vulnerável a XSS -->
                    <strong>Título:</strong> <?php echo $ticket['title']; ?><br>
                    <strong>Status:</strong> <?php echo $ticket['status']; ?><br>
                    <strong>Descrição:</strong> <?php echo $ticket['description']; ?><br>
                    <strong>Gravidade:</strong> <?php echo $ticket['severity']; ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="delete_ticket_id" value="<?php echo $ticket['id']; ?>">
                        <button type="submit" class="delete-button">Remover</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <footer>
        Todos os direitos Netglobe 2024
    </footer>
</body>
</html>
