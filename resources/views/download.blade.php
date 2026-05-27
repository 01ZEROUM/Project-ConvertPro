<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Download do seu Arquivo</title>
    <link rel="stylesheet" href="{{ asset('css/download.css') }}">
</head>
<body>
    <div class="container" style="text-align: center; margin-top: 100px;">
        <h2>Seu arquivo foi convertido com sucesso!</h2>
        <p>Formato original: <strong>{{ strtoupper($conversion->target_format) }}</strong></p>
        
        <a href="{{ route('download.arquivo', $conversion->id) }}" class="btn-download" style="display: inline-block; padding: 15px 30px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 18px;">
            Baixar Arquivo Agora
        </a>

        <br><br>
        <a href="/" style="color: #666;">Converter outro link</a>
    </div>
</body>
</html>