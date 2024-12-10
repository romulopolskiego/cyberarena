<!DOCTYPE html>
<html>
<head>
    <title>Sobre o Sistema</title>
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
            justify-content: space-between;
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
            margin: auto;
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

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header>
        <div class="logo">Minha Empresa</div>
        <div class="header-links">
            <a href="login.php">Login</a>
            <a href="register.php">Registrar-se</a>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main>
        <div class="content-container">
            <h2>Sobre o Sistema</h2>
            <p>
                Este sistema foi desenvolvido para simplificar a gestão de tarefas e chamados. 
                Com uma interface intuitiva e recursos robustos, ele permite que os usuários:
            </p>
            <ul style="text-align: left; margin: 20px auto; max-width: 500px;">
                <li>Gerenciem tarefas diárias com facilidade.</li>
                <li>Abram e acompanhem chamados de suporte.</li>
                <li>Visualizem relatórios detalhados sobre suas atividades.</li>
            </ul>
            <p>
                Criado com tecnologias modernas e foco na segurança, este sistema é a solução ideal para
                organizações que buscam eficiência e praticidade no dia a dia.
            </p>
        </div>
    </main>

    <!-- Rodapé -->
    <footer>
        Todos os direitos Netglobe 2024
    </footer>
</body>
</html>
