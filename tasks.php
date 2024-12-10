<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Adicionar tarefa (vulnerável a SQL Injection)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $task = $_POST['task']; // Entrada não sanitizada

    try {
        $query = "INSERT INTO tasks (user_id, task, priority, due_date) 
                  VALUES ('$user_id', '$task', 'Média', NULL)";
        $pdo->query($query); // Consulta direta vulnerável
    } catch (PDOException $e) {
        die("Erro ao adicionar tarefa: " . $e->getMessage());
    }
}

// Remover tarefa (vulnerável a SQL Injection)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_task_id'])) {
    $task_id = $_POST['delete_task_id']; // Entrada não sanitizada

    try {
        $query = "DELETE FROM tasks WHERE id = $task_id"; // Consulta direta vulnerável
        $pdo->query($query); // Exclusão sem validação de usuário
    } catch (PDOException $e) {
        die("Erro ao remover tarefa: " . $e->getMessage());
    }
}

// Listar tarefas (vulnerável a XSS)
try {
    $query = "SELECT * FROM tasks WHERE user_id = $user_id"; // Entrada direta na consulta SQL
    $tasks = $pdo->query($query)->fetchAll(); // Resultado exibido sem sanitização
} catch (PDOException $e) {
    die("Erro ao listar tarefas: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Minhas Tarefas</title>
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

        input[type="text"] {
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
        <div class="logo">Minhas Tarefas</div>
        <div class="header-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Sair</a>
        </div>
    </header>

    <div class="content-container">
        <h2>Minhas Tarefas</h2>

        <!-- Formulário para adicionar tarefa -->
        <form method="POST">
            <input type="text" name="task" placeholder="Digite uma nova tarefa" required>
            <button type="submit">Adicionar Tarefa</button>
        </form>

        <!-- Lista de tarefas -->
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <!-- Vulnerável a XSS -->
                    <?php echo $task['task']; ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="delete_task_id" value="<?php echo $task['id']; ?>">
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
