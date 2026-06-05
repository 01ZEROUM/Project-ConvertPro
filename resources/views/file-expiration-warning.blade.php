<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Arquivo Expirando - ConvertPro</title>
</head>

<body style="margin:0;padding:0;background-color:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

```
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">
    <tr>
        <td align="center">

            <table width="650" cellpadding="0" cellspacing="0"
                style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08);">

                <!-- HEADER -->
                <tr>
                    <td style="background:#0f172a;padding:35px;text-align:center;">
                        <h1 style="margin:0;color:#ffffff;font-size:32px;">
                            Convert<span style="color:#e84d2c;">Pro</span>
                        </h1>

                        <p style="margin-top:10px;color:#cbd5e1;font-size:14px;">
                            Conversão rápida, segura e profissional
                        </p>
                    </td>
                </tr>

                <!-- CONTEÚDO -->
                <tr>
                    <td style="padding:45px;">

                        <h2 style="margin-top:0;color:#111827;">
                            ⚠️ Seu arquivo expirará em breve
                        </h2>

                        <p style="color:#4b5563;font-size:16px;line-height:1.7;">
                            Olá,
                        </p>

                        <p style="color:#4b5563;font-size:16px;line-height:1.7;">
                            Estamos enviando este aviso para informar que um dos seus arquivos convertidos
                            será removido automaticamente do sistema em breve.
                        </p>

                        <div style="
                            background:#fff7ed;
                            border:1px solid #fdba74;
                            border-left:5px solid #ea580c;
                            border-radius:10px;
                            padding:20px;
                            margin:30px 0;
                        ">

                            <p style="margin:0 0 15px 0;color:#111827;">
                                <strong>Arquivo:</strong>
                            </p>

                            <p style="
                                margin:0;
                                color:#374151;
                                word-break:break-word;
                            ">
                                {{ $file->file_name }}
                            </p>

                            <hr style="margin:20px 0;border:none;border-top:1px solid #fed7aa;">

                            <p style="margin:0;color:#111827;">
                                <strong>Data de expiração:</strong>
                            </p>

                            <p style="margin-top:8px;color:#ea580c;font-weight:bold;">
                                {{ \Carbon\Carbon::parse($file->expires_at)->format('d/m/Y H:i') }}
                            </p>

                        </div>

                        <p style="color:#4b5563;font-size:16px;line-height:1.7;">
                            Após essa data, o arquivo será removido permanentemente dos servidores
                            do ConvertPro e não poderá ser recuperado.
                        </p>

                        <p style="color:#4b5563;font-size:16px;line-height:1.7;">
                            Recomendamos que você realize o download antes da expiração para evitar a perda do arquivo.
                        </p>

                        <div style="text-align:center;margin-top:40px;">

                            <a href="{{ config('app.url') }}"
                                style="
                                    background:#e84d2c;
                                    color:#ffffff;
                                    text-decoration:none;
                                    padding:15px 35px;
                                    border-radius:10px;
                                    font-weight:bold;
                                    display:inline-block;
                                ">
                                Acessar ConvertPro
                            </a>

                        </div>

                    </td>
                </tr>

                <!-- RODAPÉ -->
                <tr>
                    <td style="background:#f8fafc;padding:30px;text-align:center;">

                        <p style="margin:0;color:#6b7280;font-size:13px;">
                            Este é um e-mail automático enviado pelo ConvertPro.
                        </p>

                        <p style="margin-top:10px;color:#9ca3af;font-size:12px;">
                            © {{ date('Y') }} ConvertPro. Todos os direitos reservados.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>
```

</body>

</html>
