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
    <!-- HEADER -->
    <header class="header">
        <div class="container header-inner">
            <a href="#" class="logo">
                <div class="logo-icon">▶</div>
                <span>Convert<span class="brand-accent">Pro</span></span>
            </a>
            <nav class="nav">
                <a href="#">Recursos</a>
                <a href="#">Como funciona</a>
                <a href="#">FAQ</a>
            </nav>
            <div class="auth-buttons">
                <a href="#" class="login-btn">Entrar</a>
                <a href="#" class="register-btn">Registrar</a>
            </div>
        </div>
    </header>

    <!-- HERO -->
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

        <p class="terms">Projeto criado por ZEROUM.</p>
    </main>

    <div id="toast" class="toast"></div>

    <script>
        const form = document.getElementById("converterForm");
        const btn = document.getElementById("convertBtn");
        const toast = document.getElementById("toast");

        function showToast(message, type = "info") {
            toast.textContent = message;
            toast.className = `toast ${type}`;
            toast.style.display = "flex";
            setTimeout(() => toast.style.display = "none", 5000);
        }

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

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
                    headers: { "Content-Type": "application/json", "Accept": "application/json" },
                    body: JSON.stringify({ source: url, target_format: format })
                });

                const data = await response.json();

                if (response.ok && data.id) {
                    showToast("Conversão iniciada! Aguarde...", "success");
                    checkStatus(data.id);
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

        function checkStatus(id) {
            const interval = setInterval(async () => {
                try {
                    const res = await fetch(`/api/v1/conversions/${id}`);
                    const data = await res.json();

                      if (data.status === "completed") {
                          clearInterval(interval);
                          showToast("Conversão concluída! Redirecionando...", "success");
                          
                          setTimeout(() => {
                              window.location.href = `api/v1/download/${id}`;   // Vai para página com botão
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
</body>
</html>