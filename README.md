# ConvertPro - API Backend 🚀

[cite_start]O **ConvertPro** é uma API RESTful de alto desempenho construída em **Laravel**, projetada para resolver o problema de conversão de arquivos de mídia de forma totalmente assíncrona[cite: 13, 14]. [cite_start]O foco do projeto é permitir que usuários extraiam áudio ou convertam vídeos do YouTube sem precisar manter a aba do navegador aberta, delegando o processamento pesado para filas em segundo plano[cite: 13, 59].

---

## 💡 Motivação

[cite_start]A ideia surgiu da necessidade de uma ferramenta que não apenas convertesse arquivos, mas que gerasse um fluxo de trabalho confiável para o usuário[cite: 13]. Muitas soluções atuais falham ao travar a interface do cliente durante o upload ou processamento. [cite_start]O ConvertPro separa a **solicitação** da **execução**, garantindo escalabilidade e uma experiência de uso fluida através de um sistema assíncrono[cite: 58, 59].

---

## 🛠️ Funcionalidades Principais

* [cite_start]**Conversão do YouTube:** Suporta a entrada de URLs do YouTube para conversão direta em MP4 ou MP3[cite: 13, 18, 82].
* [cite_start]**Processamento Assíncrono:** Utiliza sistema de filas para processar arquivos em background, liberando o usuário imediatamente após o envio[cite: 62].
* [cite_start]**Notificações Inteligentes:** Disparo automático de e-mails para informar sobre o recebimento, conclusão da conversão e alertas de expiração de arquivos[cite: 46, 47, 48].
* [cite_start]**Gestão de Armazenamento:** Um bot integrado realiza a limpeza periódica de arquivos expirados (após 7 dias) para otimizar o espaço em disco[cite: 53, 54, 75].
* [cite_start]**Segurança e Autenticação:** Controle de acesso via tokens de API e integração com provedores externos como Google, Apple e Firebase[cite: 86, 88].
* [cite_start]**Sistema de Log:** Registro detalhado de uploads, conversões, erros de sistema e downloads efetuados[cite: 65, 66].

---

## 🚀 Tecnologias Utilizadas

* [cite_start]**Framework:** Laravel (PHP)[cite: 13].
* [cite_start]**Banco de Dados:** Estrutura relacional para gestão de usuários, conversões e metadados de arquivos[cite: 15, 27, 39].
* [cite_start]**Processamento de Filas:** Redis / Database Driver para processamento assíncrono[cite: 22, 58].
* [cite_start]**Storage:** Suporte para armazenamento Local ou AWS S3[cite: 34].
* [cite_start]**Autenticação:** API Tokens e Socialite (Google, Apple, Firebase)[cite: 86, 88].

---

## ⚙️ Instalação e Configuração

Para rodar o projeto localmente, siga os passos abaixo:

1. **Clone o repositório:**
   ```bash
   git clone [https://github.com/01ZEROUM/Project-ConvertPro.git](https://github.com/01ZEROUM/Project-ConvertPro.git)
   cd Project-ConvertPro
