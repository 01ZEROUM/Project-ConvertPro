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
        window.location.href = '/login';
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

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg);
      color: var(--fg);
      padding: 40px 20px;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
    }

    h1 {
      font-size: 28px;
      font-weight: 800;
      letter-spacing: -0.02em;
    }

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

    .btn-new:hover {
      background: #c43d1f;
    }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }

    th {
      background: #f5f5f7;
      padding: 16px;
      font-size: 12px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      border-bottom: 1px solid var(--border);
    }

    td {
      padding: 16px;
      border-bottom: 1px solid var(--border);
      font-size: 14px;
    }

    .source-url {
      max-width: 300px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      color: var(--muted);
    }

    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 600;
    }

    .badge-completed {
      background: #e6f4ea;
      color: #137333;
    }

    .badge-processing {
      background: #fef7e0;
      color: #b06000;
    }

    .badge-failed {
      background: #fce8e6;
      color: #c5221f;
    }

    .actions {
      display: flex;
      gap: 8px;
    }

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

    .btn-action:hover {
      opacity: 0.85;
    }

    .btn-download {
      background: var(--brand-soft);
      color: var(--brand);
      cursor: pointer;
    }

    .btn-delete {
      background: #fce8e6;
      color: #c5221f;
    }

    .btn-action.disabled {
      opacity: 0.5;
      cursor: not-allowed;
      pointer-events: none;
    }

    .empty-state {
      padding: 40px;
      text-align: center;
      color: var(--muted);
    }
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
            <th>Nome do Arquivo</th>
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

      if (!token) return;

      async function loadHistory() {
        try {
          const res = await fetch('/api/v1/conversions', {
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

      function renderTable(conversions) {
        if (conversions.length === 0) {
          tableBody.innerHTML = `<tr><td colspan="4" class="empty-state">Você ainda não possui conversões geradas.</td></tr>`;
          return;
        }

        tableBody.innerHTML = '';

        conversions.forEach(conversion => {
          let badgeClass = 'badge-processing';
          if (conversion.status === 'completed') badgeClass = 'badge-completed';
          if (conversion.status === 'failed') badgeClass = 'badge-failed';

          const isReady = conversion.status === 'completed';

          const row = document.createElement('tr');
          row.innerHTML = `
    <td>
        <strong>${conversion.file_path ?? 'N/A'}</strong>
    </td>

    <td>
        <div class="source-url" title="${conversion.source}">
            ${conversion.source}
        </div>
    </td>

    <td>
        <strong>${(conversion.target_format ?? 'MP3').toUpperCase()}</strong>
    </td>

    <td>
        <span class="badge ${badgeClass}">
            ${conversion.status.toUpperCase()}
        </span>
    </td>

    <td>
        <div class="actions">
            <button
                class="btn-action btn-download ${isReady ? '' : 'disabled'}"
                data-id="${conversion.id}"
                data-filename="${conversion.file_path ?? 'download'}"
            >
                Baixar
            </button>

            <button
                class="btn-action btn-delete"
                data-id="${conversion.id}"
            >
                Excluir
            </button>
        </div>
    </td>
`;
          tableBody.appendChild(row);
        });

        setupDownloadButtons();
        setupDeleteButtons();
      }

      function setupDownloadButtons() {
        document.querySelectorAll('.btn-download').forEach(button => {
          button.addEventListener('click', async (e) => {

            const id = e.target.getAttribute('data-id');

            try {

              const res = await fetch(`/api/v1/download/${id}/file`, {
                method: 'GET',
                headers: {
                  'Authorization': `Bearer ${token}`
                }
              });

              if (!res.ok) {
                alert('Erro ao baixar arquivo');
                return;
              }

              const blob = await res.blob();

              const downloadUrl = window.URL.createObjectURL(blob);

              const a = document.createElement('a');
              a.href = downloadUrl;

              const disposition = res.headers.get('Content-Disposition');

              let filename = 'arquivo';

              if (disposition && disposition.includes('filename=')) {
                filename = disposition
                  .split('filename=')[1]
                  .replace(/"/g, '');
              }

              a.download = filename;

              document.body.appendChild(a);
              a.click();

              a.remove();

              window.URL.revokeObjectURL(downloadUrl);

            } catch (error) {
              console.error(error);
              alert('Erro ao baixar arquivo');
            }

          });
        });
      }

      function setupDeleteButtons() {
        document.querySelectorAll('.btn-delete').forEach(button => {
          button.addEventListener('click', async (e) => {
            const id = e.target.getAttribute('data-id');

            if (!confirm("Tem certeza que deseja deletar este histórico?")) return;

            try {
              const res = await fetch(`/api/v1/conversions/${id}`, {
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

      loadHistory();
    });
  </script>

</body>

</html>