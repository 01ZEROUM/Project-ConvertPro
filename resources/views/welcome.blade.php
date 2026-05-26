<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ConvertPro — YouTube para MP4 e MP3</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>

    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root{
      --brand: #ef4444;
      --brand-soft: #fef2f2;
      --brand-gradient-start: #f97316;
      --brand-gradient-end: #dc2626;

      --background: #ffffff;
      --foreground: #111827;

      --card: #ffffff;
      --muted: #f3f4f6;
      --muted-foreground: #6b7280;

      --border: #e5e7eb;

      --shadow-glow: 0 10px 30px -10px rgba(239,68,68,0.45);
      --shadow-elegant: 0 20px 50px -20px rgba(0,0,0,0.15);

      --radius: 16px;

      --font-sans: 'Inter', sans-serif;
    }

    body{
      font-family: var(--font-sans);
      background: var(--background);
      color: var(--foreground);
      line-height: 1.5;
      -webkit-font-smoothing: antialiased;
    }

    a{
      text-decoration: none;
      color: inherit;
    }

    .container{
      width: 100%;
      max-width: 1200px;
      margin: auto;
      padding: 0 24px;
    }

    /* HEADER */

    .header{
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(229,231,235,0.6);
    }

    .header-inner{
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .logo{
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 1.2rem;
      font-weight: 800;
    }

    .logo-icon{
      width: 42px;
      height: 42px;
      border-radius: 14px;

      background: linear-gradient(
        135deg,
        var(--brand-gradient-start),
        var(--brand-gradient-end)
      );

      display: flex;
      align-items: center;
      justify-content: center;

      color: white;
      font-size: 1rem;

      box-shadow: var(--shadow-glow);
    }

    .brand-accent{
      color: var(--brand);
    }

    .nav{
      display: flex;
      gap: 32px;
      color: var(--muted-foreground);
      font-size: .95rem;
      font-weight: 500;
    }

    .nav a{
      transition: .2s;
    }

    .nav a:hover{
      color: var(--foreground);
    }

    /* AUTH */

    .auth-buttons{
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .login-btn{
      color: var(--muted-foreground);
      font-size: .95rem;
      font-weight: 600;
      transition: .2s;
    }

    .login-btn:hover{
      color: var(--foreground);
    }

    .register-btn{
      padding: 12px 20px;
      border-radius: 14px;

      background: linear-gradient(
        135deg,
        var(--brand-gradient-start),
        var(--brand-gradient-end)
      );

      color: white;
      font-weight: 700;
      font-size: .92rem;

      box-shadow: var(--shadow-glow);

      transition: .2s;
    }

    .register-btn:hover{
      transform: translateY(-2px);
      opacity: .95;
    }

    /* HERO */

    .hero{
      text-align: center;
      padding: 90px 0 100px;
    }

    .badge{
      display: inline-flex;
      align-items: center;
      gap: 8px;

      background: var(--brand-soft);
      color: var(--brand);

      padding: 8px 16px;
      border-radius: 999px;

      font-size: .8rem;
      font-weight: 600;

      margin-bottom: 28px;
    }

    .hero h1{
      font-size: 4.5rem;
      line-height: 1.05;
      font-weight: 800;
      letter-spacing: -3px;
    }

    .hero h1 span{
      color: var(--brand);
    }

    .hero p{
      margin-top: 22px;

      font-size: 1.15rem;
      color: var(--muted-foreground);
    }

    /* CONVERTER */

    .converter{
      max-width: 850px;
      margin: 50px auto 0;

      background: white;

      border: 1px solid var(--border);
      border-radius: 24px;

      padding: 10px;

      display: flex;
      gap: 10px;

      box-shadow: var(--shadow-elegant);
    }

    .select-wrapper{
      position: relative;
    }

    .format-select{
      appearance: none;

      height: 60px;
      min-width: 130px;

      border: none;
      border-radius: 18px;

      background: var(--muted);

      padding: 0 45px 0 18px;

      font-weight: 700;
      font-size: .95rem;

      cursor: pointer;
      font-family: inherit;
    }

    .select-arrow{
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;

      color: var(--muted-foreground);
      pointer-events: none;
    }

    .url-wrapper{
      flex: 1;
      position: relative;
    }

    .url-input{
      width: 100%;
      height: 60px;

      border: none;
      border-radius: 18px;

      padding: 0 18px 0 50px;

      font-size: 1rem;
      font-family: inherit;
    }

    .url-input:focus,
    .format-select:focus{
      outline: 2px solid var(--brand);
    }

    .url-icon{
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);

      width: 18px;
      color: var(--muted-foreground);
    }

    .convert-btn{
      height: 60px;

      border: none;
      border-radius: 18px;

      padding: 0 34px;

      background: linear-gradient(
        135deg,
        var(--brand-gradient-start),
        var(--brand-gradient-end)
      );

      color: white;
      font-weight: 700;
      font-size: .95rem;

      cursor: pointer;

      box-shadow: var(--shadow-glow);

      transition: .2s;
    }

    .convert-btn:hover{
      transform: translateY(-2px);
      opacity: .95;
    }

    .terms{
      margin-top: 18px;

      color: var(--muted-foreground);
      font-size: .82rem;
    }

    /* FEATURES */

    .features{
      margin-top: 90px;
    }

    .features-grid{
      display: grid;
      grid-template-columns: repeat(4,1fr);
      gap: 22px;
    }

    .feature-card{
      background: white;

      border: 1px solid var(--border);
      border-radius: 24px;

      padding: 28px;

      transition: .25s;
    }

    .feature-card:hover{
      transform: translateY(-5px);

      box-shadow: var(--shadow-elegant);

      border-color: rgba(239,68,68,0.3);
    }

    .feature-icon{
      width: 54px;
      height: 54px;

      border-radius: 16px;

      background: var(--brand-soft);
      color: var(--brand);

      display: flex;
      align-items: center;
      justify-content: center;

      font-size: 1.3rem;

      margin-bottom: 18px;
    }

    .feature-title{
      font-size: 1rem;
      font-weight: 700;

      margin-bottom: 8px;
    }

    .feature-desc{
      color: var(--muted-foreground);
      font-size: .92rem;
      line-height: 1.6;
    }

    /* FOOTER */

    .footer{
      margin-top: 90px;

      border-top: 1px solid rgba(229,231,235,0.6);

      padding: 36px 0;

      text-align: center;

      color: var(--muted-foreground);
      font-size: .92rem;
    }

    /* RESPONSIVO */

    @media (max-width: 1024px){

      .features-grid{
        grid-template-columns: repeat(2,1fr);
      }

    }

    @media (max-width: 768px){

      .nav{
        display: none;
      }

      .hero h1{
        font-size: 3rem;
      }

      .converter{
        flex-direction: column;
      }

      .features-grid{
        grid-template-columns: 1fr;
      }

      .header-inner{
        gap: 10px;
      }

      .register-btn{
        padding: 10px 14px;
        font-size: .85rem;
      }

      .login-btn{
        font-size: .85rem;
      }

    }

  </style>
</head>

<body>

  <!-- HEADER -->

  <header class="header">

    <div class="container header-inner">

      <a href="#" class="logo">

        <div class="logo-icon">
          ▶
        </div>

        <span>
          Convert<span class="brand-accent">Pro</span>
        </span>

      </a>

      <nav class="nav">
        <a href="#">Recursos</a>
        <a href="#">Como funciona</a>
        <a href="#">FAQ</a>
      </nav>

      <div class="auth-buttons">

        <a href="#" class="login-btn">
          Entrar
        </a>

        <a href="#" class="register-btn">
          Registrar
        </a>

      </div>

    </div>

  </header>

  <!-- HERO -->

  <main class="container hero">

    <div class="badge">
      ✓ Conversoes limitadas · Faça seu cadastro!
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

    <!-- CONVERTER -->

    <form class="converter">

      <div class="select-wrapper">

        <select class="format-select">
          <option>MP4</option>
          <option>MP3</option>
        </select>

        <svg class="select-arrow"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2">

          <path d="m6 9 6 6 6-6"/>
        </svg>

      </div>

      <div class="url-wrapper">

        <svg class="url-icon"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2">

          <path d="M10 13a5 5 0 0 0 7.54.54l3-3"/>
        </svg>

        <input
          type="text"
          class="url-input"
          placeholder="Cole o link do YouTube aqui..."
        >

      </div>

      <button class="convert-btn">
        Converter
      </button>

    </form>

    <p class="terms">
      Projeto criado por ZEROUM.
    </p>

    <!-- FEATURES -->

    <section class="features">

      <div class="features-grid">

        <div class="feature-card">

          <div class="feature-icon">
            🎵
          </div>

          <div class="feature-title">
            Áudio MP3
          </div>

          <div class="feature-desc">
            Extraia músicas e áudios em alta qualidade.
          </div>

        </div>

        <div class="feature-card">

          <div class="feature-icon">
            🎬
          </div>

          <div class="feature-title">
            Vídeo MP4
          </div>

          <div class="feature-desc">
            Baixe vídeos mantendo a qualidade original.
          </div>

        </div>

        <div class="feature-card">

          <div class="feature-icon">
            ⚡
          </div>

          <div class="feature-title">
            Conversão Rápida
          </div>

          <div class="feature-desc">
            Conversões otimizadas em poucos segundos.
          </div>

        </div>

        <div class="feature-card">

          <div class="feature-icon">
            🔒
          </div>

          <div class="feature-title">
            Seguro e Gratuito
          </div>

          <div class="feature-desc">
            Com total privacidade.
          </div>

        </div>

      </div>

    </section>

  </main>

  <!-- FOOTER -->

  <footer class="footer">
    © 2026 ConvertPro — Desenvolvido pela ZEROUM.
  </footer>

</body>
</html>