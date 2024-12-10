<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        /* Reset básico */
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
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        p {
            font-size: 16px;
            color: #555555;
            line-height: 1.5;
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

        .dashboard-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        .dashboard-links a {
            padding: 10px 20px;
            background-color: #d4a5ff; /* Roxo claro */
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .dashboard-links a:hover {
            background-color: #b580d1; /* Roxo mais escuro */
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="logo">Netglobe</div>
        <div class="header-links">
            <a href="logout.php">Sair</a>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <div class="content-container">
        <h2>Bem-vindo ao Dashboard!</h2>
        <p>
            Aqui você pode gerenciar suas tarefas, abrir chamados e acessar relatórios detalhados
            sobre suas atividades no sistema.
        </p>
        <div class="dashboard-links">
            <a href="tasks.php">Tarefas</a>
            <a href="tickets.php">Tickets</a>
            <a href="reports.php">Relatórios</a>
        </div>
    </div>

    <!-- Rodapé -->
    <footer>
        Todos os direitos Netglobe 2024
    </footer>
</body>
</html>
