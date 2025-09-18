# ProjetoPSI 🚀

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](http://makeapullrequest.com)

> Um super projeto integrado que combina aplicação Android, API robusta e aplicação web moderna em um ecossistema completo.

## 📋 Sobre o Projeto

O **ProjetoPSI** é uma solução tecnológica abrangente que integra três componentes principais em uma arquitetura moderna e escalável. Este projeto demonstra a implementação de um sistema completo end-to-end, combinando desenvolvimento mobile, backend e frontend em uma única plataforma coesa.

### 🎯 Componentes Principais

1. **📱 Aplicação Android** - App mobile nativo com interface moderna e intuitiva
2. **🔧 API REST** - Backend robusto com arquitetura RESTful 
3. **🌐 Aplicação Web** - Frontend responsivo e interativo

## ✨ Características

- **Arquitetura Modular**: Componentes independentes e bem definidos
- **Integração Completa**: Comunicação seamless entre todas as partes
- **Design Responsivo**: Interface adaptável para diferentes dispositivos
- **Segurança**: Implementação de boas práticas de segurança
- **Escalabilidade**: Preparado para crescimento e expansão
- **Documentação**: Código bem documentado e estruturado

## 🛠️ Stack Tecnológica

### Mobile (Android)
- Java
- Android SDK
- Material Design

### Backend (API)
- YII2
- PHP

### Frontend (Web)
- HTML5, CSS3, JavaScript ES6+
- YII2

## 📁 Estrutura do Projeto

```
ProjetoPSI/
├── android/              # Aplicação Android
│   ├── app/
│   ├── gradle/
│   └── README.md
├── api/                  # Backend API
│   ├── src/
│   ├── tests/
│   ├── docs/
│   └── README.md
├── web/                  # Aplicação Web
│   ├── src/
│   ├── public/
│   ├── tests/
│   └── README.md
├── docs/                 # Documentação do projeto
├── docker-compose.yml    # Configuração Docker
└── README.md
```

## 🚀 Instalação e Configuração

### Pré-requisitos

- Android Studio
- Git
- Docker (opcional)

### Configuração do Ambiente

1. **Clone o repositório**
   ```bash
   git clone https://github.com/Rikzim/ProjetoPSI.git
   cd ProjetoPSI
   ```

2. **Configure a API**
   ```bash
   cd api
   npm install
   cp .env.example .env
   # Configure as variáveis de ambiente
   npm run dev
   ```

3. **Configure a aplicação Web**
   ```bash
   cd ../web
   npm install
   npm start
   ```

4. **Configure a aplicação Android**
   - Abra o Android Studio
   - Importe o projeto da pasta `android/`
   - Sincronize o Gradle
   - Execute no emulador ou device

### 🐳 Usando Docker

```bash
# Execute todo o ambiente com Docker Compose
docker-compose up -d

# Para desenvolvimento
docker-compose -f docker-compose.dev.yml up
```

## 📖 Como Usar

### API Endpoints

```
GET    /api/v1/health      # Status da API
POST   /api/v1/auth/login  # Autenticação
GET    /api/v1/users       # Listar usuários
POST   /api/v1/users       # Criar usuário
```

### Aplicação Web

Acesse `http://localhost:3000` após iniciar o servidor de desenvolvimento.

### Aplicação Android

Instale o APK gerado ou execute através do Android Studio.

## 🔄 Fluxo de Desenvolvimento

1. **Planejamento**: Definição de features e requisitos
2. **Desenvolvimento**: Implementação em paralelo dos componentes
3. **Integração**: Testes de integração entre componentes
4. **Deploy**: Publicação em ambiente de produção

## 🧪 Testes

```bash
# Testes da API
cd api && npm test

# Testes da aplicação Web
cd web && npm test

# Testes Android
./gradlew test
```

## 📚 Documentação

- [Documentação da API](./docs/api.md)
- [Guia do Desenvolvedor Android](./docs/android.md)
- [Guia do Desenvolvedor Web](./docs/web.md)
- [Arquitetura do Sistema](./docs/architecture.md)

## 🤝 Como Contribuir

1. Faça um Fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

### 📋 Padrões de Código

- Siga as convenções de código de cada linguagem
- Escreva testes para novas funcionalidades
- Mantenha a documentação atualizada
- Use commits semânticos

## 📜 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 👥 Equipe

- **Desenvolvedor Principal**: [Rikzim](https://github.com/Rikzim)

## 📞 Contato

- **GitHub**: [@Rikzim](https://github.com/Rikzim)
- **Email**: [contato@projetopsi.com](mailto:contato@projetopsi.com)

## 🙏 Agradecimentos

- Comunidade open source
- Contribuidores do projeto
- Ferramentas e frameworks utilizados

---

<div align="center">
  <strong>ProjetoPSI</strong> - Unindo mobile, web e API em uma solução completa! ⭐
</div>
