<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Download — ConvertPro</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --brand: #e84d2c;
      --brand-soft: #fff0ec;
      --brand-dark: #c43d1f;
      --gradient-brand: linear-gradient(135deg, #e84d2c, #c43d1f);
      --shadow-glow: 0 10px 30px -10px rgba(232, 77, 44, 0.45);
      --shadow-elegant: 0 20px 50px -20px rgba(30, 30, 50, 0.15);
      --radius: 0.875rem;
      --bg: #ffffff;
      --fg: #0f0f1a;
      --muted: #6b6b7b;
      --border: #e8e8ef;
      --card: #ffffff;
      --muted-bg: #f5f5f7;
    }
    * {      margin: 0;      padding: 0;      box-sizing: border-box;    }
    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      background: var(--bg);
      color: var(--fg);
      line-height: 1.5;
      min-height: 100vh;
    }
    a { text-decoration: none; color: inherit; }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }
    /* Header */
    header {
      border-bottom: 1px solid var(--border);
      backdrop-filter: blur(8px);
      background: rgba(255,255,255,0.8);
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .header-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 64px;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .logo-icon {
      width: 36px;
      height: 36px;
      border-radius: 12px;
      background: var(--gradient-brand);
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow-glow);
    }
    .logo-icon svg {
      width: 20px;
      height: 20px;
      fill: white;
    }
    .logo-text {
      font-weight: 700;
      font-size: 18px;
      letter-spacing: -0.02em;
    }
    .logo-text span { color: var(--brand); }
    .back-link {
      font-size: 14px;
      color: var(--muted);
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s;
    }
    .back-link:hover { color: var(--fg); }
    .back-link svg {
      width: 16px;
      height: 16px;
    }
    /* Main */
    main {
      padding: 64px 0;
    }
    .page {
      max-width: 640px;
      margin: 0 auto;
    }
    .text-center { text-align: center; }
    .badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 999px;
      background: var(--brand-soft);
      color: var(--brand);
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 24px;
    }
    .badge svg { width: 14px; height: 14px; }
    h1 {
      font-size: 40px;
      font-weight: 800;
      letter-spacing: -0.03em;
      line-height: 1.1;
    }
    .subtitle {
      margin-top: 12px;
      font-size: 16px;
      color: var(--muted);
    }
    /* Card */
    .card {
      margin-top: 40px;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 24px;
      box-shadow: var(--shadow-elegant);
    }
    .file-row {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .file-icon {
      width: 64px;
      height: 64px;
      border-radius: 16px;
      background: var(--brand-soft);
      color: var(--brand);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .file-icon svg { width: 28px; height: 28px; }
    .file-info {
      flex: 1;
      min-width: 0;
    }
    .file-name {
      font-weight: 700;
      font-size: 16px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .file-source {
      font-size: 14px;
      color: var(--muted);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      margin-top: 2px;
    }
    /* Progress */
    .progress-wrap {
      margin-top: 12px;
    }
    .progress-bar {
      height: 8px;
      border-radius: 999px;
      background: var(--muted-bg);
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      border-radius: 999px;
      background: var(--gradient-brand);
      width: 0%;
      transition: width 0.15s ease;
    }
    .progress-text {
      font-size: 12px;
      color: var(--muted);
      margin-top: 6px;
    }
    /* Buttons */
    .actions {
      margin-top: 24px;
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
    }
    .btn {
      height: 48px;
      padding: 0 28px;
      border-radius: 14px;
      font-family: inherit;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: opacity 0.2s;
      border: none;
      flex: 1;
      min-width: 140px;
    }
    .btn-primary {
      background: var(--gradient-brand);
      color: white;
      box-shadow: var(--shadow-glow);
      text-decoration: none;
    }
    .btn-primary:hover:not(:disabled) { opacity: 0.95; }
    .btn-primary.disabled {
      opacity: 0.6;
      cursor: not-allowed;
      pointer-events: none; /* Desativa o clique no link HTML */
    }
    .btn-outline {
      background: transparent;
      color: var(--fg);
      border: 1px solid var(--border);
    }
    .btn-outline:hover { background: var(--muted-bg); }
    .btn svg { width: 16px; height: 16px; }
    .expire-note {
      text-align: center;
      font-size: 12px;
      color: var(--muted);
      margin-top: 24px;
    }
    /* Toast */
    .toast {
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%) translateY(100px);
      background: var(--fg);
      color: white;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 500;
      opacity: 0;
      transition: all 0.3s ease;
      pointer-events: none;
      z-index: 100;
    }
    .toast.show {
      transform: translateX(-50%) translateY(0);
      opacity: 1;
    }
    @media (max-width: 640px) {
      h1 { font-size: 28px; }
      .actions { flex-direction: column; }
      .btn { width: 100%; }
    }
  </style>
</head>
<body>
  <header>
    <div class="container header-inner">
      <a href="/" class="logo">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.38.55A3.02 3.02 0 0 0 .5 6.19 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.81 3.02 3.02 0 0 0 2.12 2.14c1.88.55 9.38.55 9.38.55s7.5 0 9.38-.55a3.02 3.02 0 0 0 2.12-2.14A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.81zM9.55 15.5V8.5l6.27 3.5-6.27 3.5z"/></svg>
        </div>
        <span class="logo-text">Convert<span>Pro</span></span>
      </a>
      <a href="/" class="back-link">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
        Nova conversão
      </a>
    </div>
  </header>

  <main class="container">
    <div class="page">
      <div class="text-center">
        <div class="badge" id="statusBadge">Processando seu arquivo...</div>
        <h1 id="title">Convertendo...</h1>
        <p class="subtitle" id="subtitle">Segure as pontas — isso leva apenas alguns segundos.</p>
      </div>

      <div class="card">
        <div class="file-row">
          <div class="file-icon" id="fileIcon">
            </div>
          <div class="file-info">
            <div class="file-name" id="fileName">{{ $conversion->file_path ?? 'youtube-video.' . $conversion->target_format }}</div>
            <div class="file-source" id="fileSource">{{ $conversion->source }}</div>
            <div class="progress-wrap">
              <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
              </div>
              <div class="progress-text" id="progressText">0%</div>
            </div>
          </div>
        </div>

        <div class="actions">
          <a href="{{ route('download.arquivo', $conversion->id) }}" class="btn btn-primary disabled" id="downloadBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span id="btnText">Preparando...</span>
          </a>
          <a href="/" class="btn btn-outline">Converter outro</a>
        </div>
      </div>

      <p class="expire-note">Os links expiram após 1 hora. Por favor, respeite os direitos autorais ao baixar conteúdos.</p>
    </div>
  </main>

  <div class="toast" id="toast"></div>

  <script>
    // Dados injetados direto do Blade do Laravel para o JavaScript
    const conversionId = "{{ $conversion->id }}";
    const format = "{{ $conversion->target_format }}";
    const initialStatus = "{{ $conversion->status }}";

    const isAudio = format === 'mp3';

    // Ícones SVG
    const filmIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>`;
    const musicIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>`;
    const checkIcon = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>`;

    // Define elemento visual de ícone inicial
    document.getElementById('fileIcon').innerHTML = isAudio ? musicIcon : filmIcon;

    // Elementos do DOM
    const fill = document.getElementById('progressFill');
    const text = document.getElementById('progressText');
    const badge = document.getElementById('statusBadge');
    const title = document.getElementById('title');
    const subtitle = document.getElementById('subtitle');
    const btn = document.getElementById('downloadBtn');
    const btnText = document.getElementById('btnText');
    const nameDisplay = document.getElementById('fileName');

    let currentProgress = 0;

    function updateUI(status, progress, fileName = null) {
      // Faz a barra visual acompanhar o progresso real do banco
      fill.style.width = progress + '%';
      text.textContent = progress + '%';

      if (status === 'completed') {
        fill.style.width = '100%';
        text.textContent = 'Pronto';
        badge.innerHTML = checkIcon + ' Conversão concluída';
        title.textContent = 'Seu arquivo está pronto!';
        subtitle.textContent = 'Clique no botão abaixo para iniciar o download.';
        
        btn.classList.remove('disabled'); // Libera o link estilo botão
        btnText.textContent = 'Baixar ' + format.toUpperCase();

        if(fileName) {
            nameDisplay.textContent = fileName;
        }
      } else if (status === 'failed') {
        badge.textContent = 'Erro';
        title.textContent = 'Falha na conversão';
        subtitle.textContent = 'Ocorreu um problema ao processar este vídeo do YouTube.';
        text.textContent = 'Falhou';
        fill.style.backgroundColor = '#ef4444';
      }
    }

    // Função de verificação contínua (Polling) baseada no seu ConversionController@status
    function checkStatus() {
        const interval = setInterval(async () => {
            try {
                // Ajuste a rota para bater com o método status() do seu ConversionController
                const res = await fetch(`/api/v1/conversions/${conversionId}`);
                const data = await res.json();

                // Atualiza progresso incremental na tela de forma limpa
                updateUI(data.status, data.progress ?? 50, data.file_path);

                if (data.status === 'completed' || data.status === 'failed') {
                    clearInterval(interval);
                }
            } catch (err) {
                console.error("Erro ao checar status:", err);
            }
        }, 2000); // Verifica a cada 2 segundos
    }

    // Inicializa a checagem ou libera direto se já veio pronto do backend
    if (initialStatus === 'completed') {
        updateUI('completed', 100);
    } else if (initialStatus === 'failed') {
        updateUI('failed', 0);
    } else {
        // Se estiver "pending" ou "processing", inicia a checagem em tempo real
        checkStatus();
    }

    // Efeito visual do Toast de Download
    btn.addEventListener('click', () => {
      if(!btn.classList.contains('disabled')) {
          const toast = document.getElementById('toast');
          toast.textContent = 'Baixando seu arquivo ' + format.toUpperCase() + '...';
          toast.classList.add('show');
          setTimeout(() => toast.classList.remove('show'), 4000);
      }
    });

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // 1. Pega o token salvo no bolso do navegador
        const token = localStorage.getItem('convertpro_token');
        const downloadBtn = document.getElementById('downloadFileBtn');

        // Pegamos o ID da conversão direto da URL do navegador
        // Exemplo: se a URL é /download/15, o split pega o "15"
        const urlParts = window.location.pathname.split('/');
        const conversionId = urlParts[urlParts.length - 1];

        if (downloadBtn && token) {
            // 2. Modifica o link do botão para injetar a rota da API + o Token de Segurança
            downloadBtn.href = `/api/v1/download/${conversionId}/file?token=${token}`;
        } else {
            // Se o cara tentar acessar sem token guardado, mandamos ele logar
            alert("Sessão expirada. Por favor, faça login novamente.");
            window.location.href = '/login';
        }
    });
  </script>
</body>
</html>