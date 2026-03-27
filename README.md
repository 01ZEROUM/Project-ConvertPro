# ConvertPro

O **ConvertPro** é uma API RESTful de alto desempenho construída em **Laravel**, projetada para resolver o problema de conversão de arquivos de mídia de forma totalmente assíncrona. O foco do projeto é permitir que usuários extraiam áudio ou convertam vídeos do YouTube sem precisar manter a aba do navegador aberta, delegando o processamento pesado para filas em segundo plano.

---

## Motivação

A ideia surgiu da necessidade de uma ferramenta que não apenas convertesse arquivos, mas que gerasse um fluxo de trabalho confiável para o usuário. Muitas soluções atuais falham ao travar a interface do cliente durante o upload ou processamento. O ConvertPro separa a **solicitação** da **execução**, garantindo escalabilidade e uma experiência de uso fluida através de um sistema assíncrono.

---

## Funcionalidades Principais

* **Conversão do YouTube:** Suporta a entrada de URLs do YouTube para conversão direta em MP4 ou MP3.
* **Processamento Assíncrono:** Utiliza sistema de filas para processar arquivos em background, liberando o usuário imediatamente após o envio.
* **Notificações Inteligentes:** Disparo automático de e-mails para informar sobre o recebimento, conclusão da conversão e alertas de expiração de arquivos.
* **Gestão de Armazenamento:** Um bot integrado realiza a limpeza periódica de arquivos expirados (após 7 dias) para otimizar o espaço em disco.
* **Segurança e Autenticação:** Controle de acesso via tokens de API e integração com provedores externos como Google, Apple e Firebase.
* **Sistema de Log:** Registro detalhado de uploads, conversões, erros de sistema e downloads efetuados.

---

## Tecnologias Utilizadas

* **Framework:** Laravel (PHP).
* **Banco de Dados:** Estrutura relacional para gestão de usuários, conversões e metadados de arquivos.
* **Processamento de Filas:** Redis / Database Driver para processamento assíncrono.
* **Storage:** Suporte para armazenamento Local ou AWS S3.
* **Autenticação:** API Tokens e Socialite (Google, Apple, Firebase).

---

## Instalação e Configuração

Para rodar o projeto localmente, siga os passos abaixo:

1. **Clone o repositório:**
   ```bash
   git clone [https://github.com/01ZEROUM/Project-ConvertPro.git](https://github.com/01ZEROUM/Project-ConvertPro.git)
   cd Project-ConvertPro
