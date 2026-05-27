<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ConvertPro — YouTube para MP4 e MP3</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
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
            min-width: 280px;
            display: none;
            align-items: center;
            gap: 12px;
        }
        .toast.success { background: #10b981; }
        .toast.error   { background: #ef4444; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container header-inner">
            <a href="/" class="logo">
                <div class="logo-icon">▶</div>
                <span>Convert<span class="brand-accent">Pro</span></span>
            </a>
            <nav class="nav">
                <a href="#">Recursos</a>
                <a href="#">Como funciona</a>
                <a href="#">FAQ</a>
            </nav>
            <div class="auth-buttons" id="authWrapper">
                <a href="/login" class="login-btn">Entrar</a>
                <a href="/login?mode=register" class="register-btn">Registrar</a>
            </div>
        </div>
    </header>

    <main class="container hero">
        <div class="badge">
            ✓ Conversões limitadas - Cadastre-se!
        </div>
        <h1>
            YouTube para
            <span>MP4 e MP3</span>
            <br>
            em segundos.
        </h1>
        <p>
            Cole o link, escolha o formato e faça o download.
        </p>

        <form class="converter" id="converterForm">
            <div class="select-wrapper">
                <select class="format-select" id="format">
                    <option value="mp4">MP4</option>
                    <option value="mp3">MP3</option>
                </select>
            </div>
            <div class="url-wrapper">
                <input type="text" class="url-input" id="urlInput" placeholder="Cole o link do YouTube aqui..." required>
            </div>
            <button class="convert-btn" type="submit" id="convertBtn">Converter</button>     
        </form>

        <p class="terms">por ZEROUM.</p>
    </main>

    <div id="toast" class="toast"></div>

    <script>
        const form = document.getElementById("converterForm");
        const btn = document.getElementById("convertBtn");
        const toast = document.getElementById("toast");
        const authWrapper = document.getElementById("authWrapper");

        function showToast(message, type = "info") {
            toast.textContent = message;
            toast.className = `toast ${type}`;
            toast.style.display = "flex";
            setTimeout(() => toast.style.display = "none", 5000);
        }

        // =========================================================
        // 1. AO CARREGAR A HOME: Verifica se o usuário já está logado
        // =========================================================
        document.addEventListener("DOMContentLoaded", async () => {
            const token = localStorage.getItem('convertpro_token');

            if (token) {
                try {
                    const response = await fetch('/api/v1/me', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    });

                    if (response.ok) {
                        const user = await response.json();
                        
                        // Altera os botões do Header para exibir o nome do usuário logado
                        authWrapper.innerHTML = `
                            <span style="font-size: 14px; color: #71717a; margin-right: 16px; font-weight: 500;">
                                Olá, ${user.name}
                            </span>
                            <a href="#" id="logoutBtn" class="login-btn" style="text-decoration: none;">Sair</a>
                        `;

                        document.getElementById('logoutBtn').addEventListener('click', (e) => {
                            e.preventDefault();
                            realizarLogout(token);
                        });
                    } else {
                        // Token corrompido ou expirado no backend, removemos para evitar falhas
                        localStorage.removeItem('convertpro_token');
                    }
                } catch (error) {
                    console.error("Erro ao validar sessão:", error);
                }
            }
        });

        // Função de Logout Limpo
        async function realizarLogout(token) {
            try {
                await fetch('/api/v1/logout', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
            } catch (e) {
                console.error(e);
            } finally {
                localStorage.removeItem('convertpro_token');
                window.location.reload();
            }
        }

        // =========================================================
        // 2. DISPARO DO FORMULÁRIO COM VALIDAÇÃO E TOKEN INJETADO
        // =========================================================
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            // CAPTURA O TOKEN ATUAL DO NAVEGADOR
            const token = localStorage.getItem('convertpro_token');

            // BARREIRA DO DEV SÊNIOR: Se não tiver logado, barra na hora!
            if (!token) {
                showToast("Atenção: Você precisa fazer login ou se registrar para converter!", "error");
                setTimeout(() => {
                    window.location.href = "/login";
                }, 2000);
                return;
            }

            const url = document.getElementById("urlInput").value.trim();
            const format = document.getElementById("format").value;

            if (!url) {
                showToast("Por favor, cole um link do YouTube.", "error");
                return;
            }

            btn.innerText = "Convertendo...";
            btn.disabled = true;

            try {
                const response = await fetch("/api/v1/conversions", {
                    method: "POST",
                    headers: { 
                        "Content-Type": "application/json", 
                        "Accept": "application/json",
                        "Authorization": `Bearer ${token}` // <-- INJETADO O CRUCIAL CRAC-HÁ DO SANCTUM AQUI
                    },
                    body: JSON.stringify({ source: url, target_format: format })
                });

                const data = await response.json();

                if (response.ok && data.id) {
                    showToast("Conversão iniciada! Aguarde...", "success");
                    checkStatus(data.id, token); // Passa o token adiante para o polling
                } else {
                    showToast(data.message || "Erro ao iniciar conversão", "error");
                }
            } catch (error) {
                showToast("Erro de conexão com o servidor.", "error");
            } finally {
                btn.innerText = "Converter";
                btn.disabled = false;
            }
        });

        // =========================================================
        // 3. MONITORAMENTO DO PROGRESSO (POLLING)
        // =========================================================
        function checkStatus(id, token) {
            const interval = setInterval(async () => {
                try {
                    const res = await fetch(`/api/v1/conversions/${id}/status`, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    });
                    const data = await res.json();

                    if (data.status === "completed") {
                        clearInterval(interval);
                        showToast("Conversão concluída! Redirecionando...", "success");
                        
                        setTimeout(() => {
                            window.location.href = `/download/${id}`; 
                        }, 1500);
                    }

                    if (data.status === "failed") {
                        clearInterval(interval);
                        showToast("Falha na conversão.", "error");
                    }
                } catch (err) {
                    console.error(err);
                }
            }, 3000);
        }
    </script>