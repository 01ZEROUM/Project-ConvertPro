# 🎬 ConvertPro API

API RESTful desenvolvida em Laravel para conversão de vídeos do YouTube em **MP3** e **MP4**, utilizando processamento assíncrono com filas.

---

## 🚀 Tecnologias utilizadas

* PHP (Laravel)
* MySQL
* Laravel Queue
* yt-dlp
* FFmpeg
* REST API

---

## 📌 Sobre o projeto

O **ConvertPro** permite que usuários enviem uma URL de vídeo do YouTube e escolham o formato de saída (MP3 ou MP4).

A conversão é feita de forma **assíncrona**, garantindo melhor performance e escalabilidade.

---

## ⚙️ Funcionalidades

* ✅ Conversão de vídeos para MP3 e MP4
* ✅ Processamento em background (Jobs + Queue)
* ✅ Controle de status (pending, processing, completed, failed)
* ✅ Retry de conversão
* ✅ Download de arquivos convertidos
* ✅ Expiração automática de arquivos
* ✅ Logs de erro

---

## 🧩 Estrutura do projeto

### 🔹 Models

* `Conversion` → representa a solicitação de conversão
* `ConvertedFile` → representa o arquivo gerado

---

### 🔹 Controllers

* `ConversionController`
* `DownloadController`

---

### 🔹 Jobs

* `ProcessConversionJob` → responsável pela conversão do vídeo

---

## 🛠️ Instalação

### 1. Clonar o projeto

```bash
git clone https://github.com/seu-usuario/convertpro.git
cd convertpro
```

---

### 2. Instalar dependências

```bash
composer install
```

---

### 3. Configurar ambiente

```bash
cp .env.example .env
php artisan key:generate
```

---

### 4. Configurar banco de dados

No `.env`:

```env
DB_DATABASE=nome_do_banco
DB_USERNAME=root
DB_PASSWORD=
```

---

### 5. Rodar migrations

```bash
php artisan migrate
```

---

### 6. Criar pasta de arquivos

```bash
mkdir storage/app/converted
```

---

### 7. Iniciar servidor

```bash
php artisan serve
```

---

### 8. Rodar fila (ESSENCIAL)

```bash
php artisan queue:work
```

---

## ⚠️ Dependências externas

Instale no seu sistema:

### 🔹 yt-dlp

```bash
pip install yt-dlp
```

---

### 🔹 FFmpeg

Baixe em:
https://ffmpeg.org/download.html

---

## 🔌 Endpoints da API

### 🔹 Criar conversão

```http
POST /api/conversions
```

Body:

```json
{
  "source": "https://youtube.com/...",
  "target_format": "mp3"
}
```

---

### 🔹 Listar conversões

```http
GET /api/conversions
```

---

### 🔹 Ver uma conversão

```http
GET /api/conversions/{id}
```

---

### 🔹 Status da conversão

```http
GET /api/conversions/{id}/status
```

---

### 🔹 Retry de conversão

```http
POST /api/conversions/{id}/retry
```

---

### 🔹 Download do arquivo

```http
GET /api/download/{id}
```

---

## 🔄 Fluxo do sistema

```text
Cliente envia URL
        ↓
API cria conversão (pending)
        ↓
Job é disparado
        ↓
Processamento (yt-dlp + ffmpeg)
        ↓
Arquivo gerado
        ↓
Status atualizado (completed)
        ↓
Disponível para download
```

---

## 🧠 Arquitetura

O projeto segue boas práticas:

* Separação de responsabilidades
* Uso de Jobs para tarefas pesadas
* API RESTful
* Código limpo e organizado

---

## 🚨 Possíveis melhorias

* Autenticação com JWT
* Upload para AWS S3
* Webhooks ou notificações
* Dashboard frontend
* Rate limiting

---

## 👨‍💻 Autor

Desenvolvido por ZEROUM.
---

## 📄 Licença

Este projeto está sob a licença MIT.
