<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConvertPro — Entrar / Registrar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
            color: #0f0f1a;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: #ffffff;
            border: 1px solid #e8e8ef;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        .auth-logo {
            font-size: 24px;
            font-weight: 800;
            text-decoration: none;
            color: #0f0f1a;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .logo-icon { color: #e84d2c; }
        .brand-accent { color: #e84d2c; }
        
        .auth-card h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .auth-card p {
            color: #71717a;
            font-size: 14px;
            margin-bottom: 24px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #4b4b57;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            border-radius: 10px;
            border: 1px solid #e8e8ef;
            font-family: inherit;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .form-input:focus {
            border-color: #e84d2c;
        }
        .auth-btn {
            width: 100%;
            height: 46px;
            background: #0f0f1a;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 8px;
        }
        .auth-btn:hover { background: #1a1a2e; }
        .auth-btn:disabled { opacity: 0.6; cursor: not-allowed; }

        .switch-form {
            margin-top: 20px;
            font-size: 13px;
            color: #71717a;
        }
        .switch-form a {
            color: #e84d2c;
            text-decoration: none;
            font-weight: 600;
        }
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 16px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none;
        }
        .toast.error { background: #ef4444; }
        .toast.success { background: #10b981; }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <a href="/" class="auth-logo">
                <div class="logo-icon">▶</div>
                <span>Convert<span class="brand-accent">Pro</span></span>
            </a>

            <div id="authContent">
                <h2 id="authTitle">Acesse sua conta</h2>
                <p id="authSubtitle">Faça login para converter seus vídeos favoritos.</p>

                <form id="authForm">
                    <div class="form-group" id="nameGroup" style="display: none;">
                        <label for="nameInput">Nome Completo</label>
                        <input type="text" id="nameInput" class="form-input" placeholder="Seu nome">
                    </div>

                    <div class="form-group">
                        <label for="emailInput">E-mail</label>
                        <input type="email" id="emailInput" class="form-input" placeholder="seu@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="passwordInput">Senha</label>
                        <input type="password" id="passwordInput" class="form-input" placeholder="••••••••" required>
                    </div>

                    <button type="submit" id="submitBtn" class="auth-btn">Entrar</button>
                </form>

                <div class="switch-form">
                    <span id="switchText">Não tem uma conta?</span>
                    <a href="#" id="switchLink">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>

    <div id="toast" class="toast"></div>

    <script>
        let isLoginMode = true;
        const authForm = document.getElementById('authForm');
        const submitBtn = document.getElementById('submitBtn');
        const nameGroup = document.getElementById('nameGroup');
        const nameInput = document.getElementById('nameInput');
        const emailInput = document.getElementById('emailInput');
        const passwordInput = document.getElementById('passwordInput');
        const switchLink = document.getElementById('switchLink');
        
        // Elementos de texto dinâmicos
        const authTitle = document.getElementById('authTitle');
        const authSubtitle = document.getElementById('authSubtitle');
        const switchText = document.getElementById('switchText');
        const toast = document.getElementById('toast');

        function showToast(message, type = "success") {
            toast.textContent = message;
            toast.className = `toast ${type}`;
            toast.style.display = "block";
            setTimeout(() => toast.style.display = "none", 4000);
        }

        // Alterna dinamicamente entre a tela de Login e a de Cadastro
        switchLink.addEventListener('click', (e) => {
            e.preventDefault();
            isLoginMode = !isLoginMode;

            if (isLoginMode) {
                authTitle.textContent = "Acesse sua conta";
                authSubtitle.textContent = "Faça login para converter seus vídeos favoritos.";
                submitBtn.textContent = "Entrar";
                switchText.textContent = "Não tem uma conta?";
                switchLink.textContent = "Cadastre-se";
                nameGroup.style.display = "none";
                nameInput.removeAttribute('required');
            } else {
                authTitle.textContent = "Crie sua conta";
                authSubtitle.textContent = "Cadastre-se para liberar conversões ilimitadas.";
                submitBtn.textContent = "Criar Conta";
                switchText.textContent = "Já tem uma conta?";
                switchLink.textContent = "Faça Login";
                nameGroup.style.display = "block";
                nameInput.setAttribute('required', 'required');
            }
        });

        // Envio dos dados para a API do Laravel Sanctum
        authForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.textContent = isLoginMode ? "Entrando..." : "Criando...";

            const endpoint = isLoginMode ? '/api/v1/login' : '/api/v1/register';
            
            const payload = {
                email: emailInput.value.trim(),
                password: passwordInput.value
            };

            if (!isLoginMode) {
                payload.name = nameInput.value.trim();
            }

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();
                console.log(data);

                if (response.ok && data.access_token) {
                    // SALVA O TOKEN NO NAVEGADOR
                    localStorage.setItem('convertpro_token', data.access_token);
                    
                    showToast(isLoginMode ? "Login efetuado com sucesso!" : "Cadastro realizado com sucesso!", "success");
                    
                    // Redireciona o usuário para a página inicial logado
                    setTimeout(() => {
                        window.location.href = '/'; 
                    }, 1000);
                } else {
                    showToast(data.message || "Erro ao processar requisição.", "error");
                }
            } catch (error) {
                showToast("Erro de conexão com o servidor.", "error");
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = isLoginMode ? "Entrar" : "Criar Conta";
            }
        });

        // 1. O navegador olha para a URL e procura por "?mode=..."
        const parametrosUrl = new URLSearchParams(window.location.search);

        // 2. Se ele encontrar o texto "register", ele força o clique no link de mudar a tela!
        if (parametrosUrl.get('mode') === 'register') {
            // switchLink é a variável que criamos que aponta para o link "Cadastre-se"
            if (typeof switchLink !== 'undefined') {
                switchLink.click();
            }
        }
    </script>
</body>
</html>