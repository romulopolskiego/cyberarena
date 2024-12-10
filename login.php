<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Entrada não sanitizada
    $password = $_POST['password']; // Entrada não sanitizada

    try {
        // Vulnerabilidade de SQL Injection
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $pdo->query($query); // Consulta vulnerável

        if ($user = $result->fetch()) {
            // Login bem-sucedido
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            // Mensagem genérica para força bruta
            $error = "Credenciais inválidas. Tente novamente.";
        }
    } catch (PDOException $e) {
        die("Erro no login: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

        .login-container {
            margin: 0 auto;
            margin-top: 100px; /* Espaço abaixo do cabeçalho */
            width: 300px;
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

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
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

        .error {
            color: red;
            margin-top: 10px;
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
        <div class="logo">Minha Empresa</div>
        <div class="header-links">
            <a href="register.php">Registrar-se</a>
            <a href="about.php">Sobre a Plataforma</a>
        </div>
    </header>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

    <footer>
        Todos os direitos Netglobe 2024
    </footer>
</body>
</html>
