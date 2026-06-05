<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversão Concluída</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:40px 20px;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#e84d2c;padding:35px 20px;">
                            <h1 style="margin:0;color:#ffffff;font-size:32px;">
                                ▶ ConvertPro
                            </h1>

                            <p style="margin-top:10px;color:#ffe5df;font-size:16px;">
                                Sua conversão foi concluída com sucesso!
                            </p>
                        </td>
                    </tr>

                    <!-- Conteúdo -->
                    <tr>
                        <td style="padding:40px;">

                            <h2 style="color:#111827;margin-top:0;">
                                Olá, {{ $user->name ?? 'Usuário' }} 👋
                            </h2>

                            <p style="color:#4b5563;line-height:1.8;">
                                Seu arquivo foi processado e já está disponível para download.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin:25px 0;background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;">
                                <tr>
                                    <td style="padding:20px;">

                                        <p style="margin:0;color:#6b7280;font-size:12px;font-weight:bold;">
                                            NOME DO ARQUIVO
                                        </p>

                                        <p style="margin-top:8px;font-size:16px;color:#111827;font-weight:bold;">
                                            {{ $file->file_name }}
                                        </p>

                                        <hr style="border:none;border-top:1px solid #e5e7eb;margin:15px 0;">

                                        <p style="margin:0;color:#6b7280;font-size:12px;font-weight:bold;">
                                            FORMATO
                                        </p>

                                        <p style="margin-top:8px;font-size:16px;color:#111827;">
                                            {{ strtoupper($file->conversion->target_format ?? '') }}
                                        </p>

                                    </td>
                                </tr>
                            </table>

                            <p style="color:#4b5563;line-height:1.8;">
                                O arquivo permanecerá disponível em sua conta por
                                <strong>7 dias</strong>.
                            </p>

                            <div style="text-align:center;margin-top:35px;">

                                <a href="{{ config('app.url') }}/convertedfiles"
                                    style="
                                    display:inline-block;
                                    background:#e84d2c;
                                    color:#ffffff;
                                    text-decoration:none;
                                    padding:14px 30px;
                                    border-radius:8px;
                                    font-weight:bold;
                                    font-size:15px;">
                                    Ver Meus Arquivos
                                </a>

                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background:#f9fafb;padding:25px;border-top:1px solid #e5e7eb;">

                            <p style="margin:0;color:#6b7280;font-size:13px;">
                                ConvertPro © {{ date('Y') }}
                            </p>

                            <p style="margin-top:8px;color:#9ca3af;font-size:12px;">
                                Este é um e-mail automático enviado pelo sistema ConvertPro.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>