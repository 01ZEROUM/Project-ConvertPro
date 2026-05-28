<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meus Arquivos — ConvertPro</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <script>
    (function() {
        const token = localStorage.getItem('convertpro_token');
        if (!token) {
            alert("Acesso restrito. Por favor, faça login para acessar seu histórico.");
            window.location.href = '/login'; // Ajuste para a URL da sua tela de login
        }
    })();
  </script>
  
  <style>
    :root {
      --brand: #e84d2c;
      --brand-soft: #fff0ec;
      --bg: #f9f9fb;
      --card: #ffffff;
      --fg: #0f0f1a;
      --muted: #6b6b7b;
      --border: #e8e8ef;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--fg);
      padding: 40px 20px;
    }

    .container { max-width: 1000px; margin: 0 auto; }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
    }

    h1 { font-size: 28px; font-weight: 800; letter-spacing: -0.02em; }

    .btn-new {
      background: var(--brand);
      color: white;
      padding: 10px 20px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      transition: background 0.2s;
    }
    .btn-new:hover { background: #c43d1f; }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    table { width: 100%; border-collapse: collapse; text-align: left; }

    th {
      background: #f5f5f7;
      padding: 16px;
      font-size: 12px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      border-bottom: 1px solid var(--border);
    }

    td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 14px; }

    .source-url {
      max-width: 300px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      color: var(--muted);
    }

    /* Badges de Status */
    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 600;
    }
    .badge-completed { background: #e6f4ea; color: #137333; }
    .badge-processing { background: #fef7e0; color: #b06000; }
    .badge-failed { background: #fce8e6; color: #c5221f; }

    /* Botões de Ação */
    .actions { display: flex; gap: 8px; }

    .btn-action {
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      text-decoration: none;
      transition: opacity 0.2s;
    }
    .btn-action:hover { opacity: 0.85; }

    .btn-download { background: var(--brand-soft); color: var(--brand); }
    .btn-delete { background: #fce8e6; color: #c5221f; }
    
    /* Estado desativado caso o arquivo ainda esteja processando */
    .btn-action.disabled { opacity: 0.5; cursor: not-allowed; pointer-events: none; }

    .empty-state { padding: 40px; text-align: center; color: var(--muted); }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <h1>Meus Arquivos Convertidos</h1>
      <a href="/" class="btn-new">+ Nova Conversão</a>
    </div>

    <div class="card">
      <table>
        <thead>
          <tr>
            <th>Link Original</th>
            <th>Formato</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="convertedFilesTable">
          <tr>
            <td colspan="4" class="empty-state">Carregando seu histórico...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", () => {
      const token = localStorage.getItem('convertpro_token');
      const tableBody = document.getElementById('convertedFilesTable');

      if (!token) return; // Segurança redundante caso passe da trava do head

      /**
       * BUSCA AS CONVERSÕES DA API
       */
      async function loadHistory() {
          try {
              const res = await fetch('/api/v1/files', {
                  method: 'GET',
                  headers: {
                      'Accept': 'application/json',
                      'Authorization': `Bearer ${token}`
                  }
              });

              if (!res.ok) throw new Error("Erro ao carregar dados.");

              const conversions = await res.json();
              renderTable(conversions);

          } catch (err) {
              tableBody.innerHTML = `<tr><td colspan="4" class="empty-state" style="color: #c5221f;">Não foi possível carregar seu histórico.</td></tr>`;
              console.error(err);
          }
      }

      /**
       * REDENRIZA AS LINHAS DA TABELA DINAMICAMENTE
       */
      function renderTable(files) {
          if (files.length === 0) {
              tableBody.innerHTML = `<tr><td colspan="4" class="empty-state">Você ainda não possui conversões geradas.</td></tr>`;
              return;
          }

          tableBody.innerHTML = '';

          files.forEach(file => {
              // Ajustando as classes CSS para os status vindos do banco
              let badgeClass = 'badge-processing';
              if (file.status === 'completed' || file.status === 'success') badgeClass = 'badge-completed';
              if (file.status === 'failed' || file.status === 'error') badgeClass = 'badge-failed';

              const isReady = file.status === 'completed' || file.status === 'success';
              const downloadUrl = `/api/v1/download/${file.id}/file?token=${token}`;

              const row = document.createElement('tr');
              row.innerHTML = `
                  <td>
                      <div class="source-url" title="${file.source}">
                          ${file.source}
                      </div>
                  </td>
                  <td><strong>${(file.target_format ?? 'MP3').toUpperCase()}</strong></td>
                  <td><span class="badge ${badgeClass}">${file.status.toUpperCase()}</span></td>
                  <td>
                      <div class="actions">
                          <a href="${downloadUrl}" class="btn-action btn-download ${isReady ? '' : 'disabled'}">
                              Baixar
                          </a>
                          <button class="btn-action btn-delete" data-id="${file.id}">
                              Excluir
                          </button>
                      </div>
                  </td>
              `;
              tableBody.appendChild(row);
          });

          setupDeleteButtons();
      }

      /**
       * CONFIGURA OS EVENTOS DOS BOTÕES DE EXCLUSÃO
       */
      function setupDeleteButtons() {
          document.querySelectorAll('.btn-delete').forEach(button => {
              button.addEventListener('click', async (e) => {
                  const id = e.target.getAttribute('data-id');
                  
                  if (!confirm("Tem certeza que deseja deletar este histórico?")) return;

                  try {
                      const res = await fetch(`/api/v1/files/${id}`, {
                          method: 'DELETE',
                          headers: {
                              'Accept': 'application/json',
                              'Authorization': `Bearer ${token}`
                          }
                      });

                      if (res.ok) {
                          alert("Conversão excluída com sucesso!");
                          loadHistory();
                      } else {
                          alert("Erro ao tentar excluir.");
                      }
                  } catch (err) {
                      console.error("Erro ao deletar:", err);
                  }
              });
          });
      }

      // Inicializa a listagem automaticamente
      loadHistory();
  });
  </script>

</body>
</html>