<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>ConvertPro — YouTube para MP4 e MP3</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/app.css">

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
      ✓ Conversões ilimitadas · Conectado ao backend
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

    <!-- CONVERTER FORM -->
    <form class="converter" id="converterForm">

      <div class="select-wrapper">

        <select class="format-select" id="format">
          <option value="mp4">MP4</option>
          <option value="mp3">MP3</option>
        </select>

      </div>

      <div class="url-wrapper">

        <input
          type="text"
          class="url-input"
          id="urlInput"
          placeholder="Cole o link do YouTube aqui..."
        >

      </div>

      <button class="convert-btn" type="submit" id="convertBtn">
        Converter
      </button>

    </form>

    <p class="terms">
      Projeto criado por ZEROUM.
    </p>

  </main>

  <!-- SCRIPT INTEGRAÇÃO BACKEND -->
  <script>
    const form = document.getElementById("converterForm");
    const btn = document.getElementById("convertBtn");

    form.addEventListener("submit", async (e) => {
      e.preventDefault();

      const url = document.getElementById("urlInput").value;
      const format = document.getElementById("format").value;

      if (!url) {
        alert("Cole uma URL primeiro");
        return;
      }

      btn.innerText = "Convertendo...";
      btn.disabled = true;

      try {
            const response = await fetch("http://127.0.0.1:8000/api/v1/conversions", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        source: url,
        target_format: format
    })
    });

    const data = await response.json();

    console.log("Resposta Laravel:", data);

    if (data.id) {
    checkStatus(data.id);
    } else {
    alert("Erro ao iniciar conversão");
    }

    if (data.id) {
    checkStatus(data.id);
    } else {
    alert("Erro ao iniciar conversão");
    }

      } catch (error) {
        console.error(error);
        alert("Erro ao conectar com o servidor");
      }

      btn.innerText = "Converter";
      btn.disabled = false;
    });

    function checkStatus(id) {

      const interval = setInterval(async () => {

        const res = await fetch(`http://127.0.0.1:8000/api/v1/conversions/${id}`);
        const data = await res.json();

        console.log("Status:", data.status);

        if (data.status === "completed") {
          clearInterval(interval);

          alert("Conversão pronta!");

          window.location.href =
            `http://127.0.0.1:8000/api/v1/download/${id}`;
        }

        if (data.status === "failed") {
          clearInterval(interval);
          alert("Erro na conversão");
        }

      }, 3000);
    }
  </script>

</body>
</html>