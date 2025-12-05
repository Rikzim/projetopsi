# Documentação da API - MaisLusitânia

API RESTful para gestão de locais culturais (Museus e Monumentos), notícias, eventos, reservas e avaliações em Portugal.

**Base URL:** `http://172.22.21.218/projetopsi/maislusitania/backend/web/api`

---

## Índice

- [Autenticação](#autenticação)
- [Locais Culturais](#locais-culturais)
- [Eventos](#eventos)
- [Notícias](#notícias)
- [Perfil do Utilizador](#perfil-do-utilizador)
- [Favoritos](#favoritos)
- [Reservas e Bilhetes](#reservas-e-bilhetes)
- [Avaliações](#avaliações)
- [Códigos de Status HTTP](#códigos-de-status-http)

---

## Autenticação

A API utiliza **tokens de acesso** para autenticar utilizadores. O token deve ser enviado como parâmetro de query `access-token` ou no header `Authorization: Bearer {token}`.

### POST `/login-form`

Autentica um utilizador e retorna um token de acesso.

**Parâmetros (Body JSON):**

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `username` | string | Sim | Nome de utilizador |
| `password` | string | Sim | Password (PlainText) |

**Exemplo de Request:**

```json
POST /login-form
Content-Type: application/json
{
  "username": "user",
  "password": "12345678"
}
```

**Exemplo de Response (200 OK):**

```json
{
  "username": "admin",
  "user_id": 8,
  "auth_key": "MhmeNGvy7wibfDGcik_kfq2RW8Tjx5bN"
}
```

---

### POST `/signup-form`

Regista um novo utilizador na plataforma.

**Parâmetros (Body JSON):**

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `username` | string | Sim | Nome de utilizador único |
| `email` | string | Sim | Email válido |
| `password` | string | Sim | Password (PlainText) |
| `primeiro_nome` | string | Sim | Password (PlainText) |
| `ultimo_nome` | string | Sim | Password (PlainText) |

**Exemplo de Request:**

```json
POST /register
Content-Type: application/json
{
  "username": "mari123",
  "email": "maria@gmail.com",
  "password": "12345678",
  "primeiro_nome": "ana",
  "ultimo_nome": "maria"
}
```

**Exemplo de Response (201 Created):**

```json
{
  "success": true,
  "message": "Utilizador criado com sucesso!"
}
```

---

## Locais Culturais

### GET `/local-culturals`

Lista todos os locais culturais ativos.

**Parâmetros de Query (Opcionais):**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| `tipo` | string | Filtrar por tipo de local (ex: "Museu", "Monumento") |
| `distrito` | string | Filtrar por distrito (ex: "Lisboa", "Porto") |

**Exemplo de Request:**

```http
GET /locais-culturais
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id":	1,
    "nome":	"Museu Nacional de Arte Antiga",
    "morada": "Rua das Janelas Verdes, 1249-017 Lisboa",
    "distrito":	"Lisboa",
    "descricao":	"O mais importante museu de arte antiga em Portugal, com coleções de pintura, escultura, artes decorativas e desenho.",
    "imagem":	"http://localhost/projetopsi/maislusitania/frontend/web/uploads/local_693176e91dd34.jpg",
    "avaliacao_media":	4
  }
]
```

---

### GET `/local-culturals/distrito`

Lista todos os locais culturais ativos.

**Parâmetros de Query (Opcionais):**

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| `tipo` | string | Filtrar por tipo de local (ex: "Museu", "Monumento") |
| `distrito` | string | Filtrar por distrito (ex: "Lisboa", "Porto") |

**Exemplo de Request:**

```http
GET /locais-culturais
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id":	1,
    "nome":	"Museu Nacional de Arte Antiga",
    "morada": "Rua das Janelas Verdes, 1249-017 Lisboa",
    "distrito":	"Lisboa",
    "descricao":	"O mais importante museu de arte antiga em Portugal, com coleções de pintura, escultura, artes decorativas e desenho.",
    "imagem":	"http://localhost/projetopsi/maislusitania/frontend/web/uploads/local_693176e91dd34.jpg",
    "avaliacao_media":	4
  }
]
```

---

### GET `/local-culturals/{id}`

Obtém detalhes completos de um local cultural específico, incluindo notícias, eventos, avaliações, bilhetes e horários.

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |

**Exemplo de Request:**

```http
GET /locais-culturais/61
```

**Exemplo de Response (200 OK):**

```json
{
  "id": 61,
  "nome": "Museu Nacional de Arte Antiga",
  "tipo": "Museu",
  "distrito": "Lisboa",
  "imagem": "https://picsum.photos/500/300?random=61",
  "morada": "R. das Janelas Verdes, Lisboa",
  "descricao": "O Museu Nacional de Arte Antiga é o mais importante museu de arte em Portugal...",
  "horario_funcionamento": "Terça a Domingo: 10h00-18h00. Encerrado às segundas-feiras.",
  "contacto_telefone": "+351 213 912 800",
  "contacto_email": "mnarteantiga@mnaa.dgpc.pt",
  "website": "http://www.museudearteantiga.pt",
  "ativo": true,
  "latitude": 38.7069,
  "longitude": -9.1604,
  "avaliacoes": [
    {
      "id": 1,
      "utilizador": "João Silva",
      "classificacao": 4.8,
      "comentario": "Espaço incrível com obras imperdíveis...",
      "data_avaliacao": "2024-02-12",
      "ativo": true
    }
  ],
  "noticias": [
    {
      "id": 1,
      "titulo": "Nova exposição de arte flamenga chega a Lisboa",
      "descricao": "O Museu Nacional de Arte Antiga inaugura uma nova mostra...",
      "data_inicio": "2024-10-10",
      "data_fim": "2024-11-11",
      "imagem": "https://picsum.photos/500/300?random=101"
    }
  ],
  "eventos": [
    {
      "id": 1,
      "titulo": "Concerto de Música Barroca",
      "descricao": "Apresentação especial com a Orquestra Clássica de Lisboa...",
      "data_inicio": "2024-12-05T18:00:00",
      "data_fim": "2024-12-05T20:00:00",
      "imagem": "https://picsum.photos/500/300?random=201"
    }
  ],
  "tipos_bilhete": [
    {
      "id": 1,
      "nome": "Bilhete Adulto",
      "preco": "10€",
      "ativo": true
    }
  ],
  "horarios": [
    {
      "id": 1,
      "segunda": "10:00-18:00",
      "terca": "10:00-18:00",
      "quarta": "10:00-18:00",
      "quinta": "10:00-18:00",
      "sexta": "10:00-18:00",
      "sabado": "10:00-18:00",
      "domingo": "10:00-18:00"
    }
  ]
}
```

---

## 📅 Eventos

### GET `/locais-culturais/{id}/eventos`

Lista todos os eventos relacionados a um local cultural específico.

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |

**Exemplo de Request:**

```http
GET /locais-culturais/61/eventos
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id": 1,
    "titulo": "Concerto de Música Barroca",
    "data_inicio": "2024-12-05T18:00:00",
    "imagem": "https://picsum.photos/500/300?random=201"
  }
]
```

---

### GET `/locais-culturais/{id}/eventos/{evento_id}`

Obtém detalhes completos de um evento específico.

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |
| `evento_id` | integer | Sim | ID do evento |

**Exemplo de Request:**

```http
GET /locais-culturais/61/eventos/1
```

**Exemplo de Response (200 OK):**

```json
{
  "id": 1,
  "titulo": "Concerto de Música Barroca",
  "descricao": "Apresentação especial com a Orquestra Clássica de Lisboa no auditório do museu.",
  "data_inicio": "2024-12-05T18:00:00",
  "data_fim": "2024-12-05T20:00:00",
  "imagem": "https://picsum.photos/500/300?random=201"
}
```

---

### GET `/eventos`

Lista todos os eventos ativos da plataforma.

**Exemplo de Request:**

```http
GET /eventos
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id": 1,
    "titulo": "Concerto de Música Barroca",
    "descricao": "Apresentação especial com a Orquestra Clássica de Lisboa...",
    "data_inicio": "2024-12-05T18:00:00",
    "data_fim": "2024-12-05T20:00:00",
    "imagem": "https://picsum.photos/500/300?random=201"
  }
]
```

---

## 📰 Notícias

### GET `/locais-culturais/{id}/noticias`

Lista todas as notícias relacionadas a um local cultural.

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |

**Exemplo de Request:**

```http
GET /locais-culturais/61/noticias
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id": 1,
    "titulo": "Nova exposição de arte flamenga chega a Lisboa",
    "resumo": "Nova mostra dedicada à pintura flamenga",
    "imagem": "https://picsum.photos/500/300?random=101",
    "data_publicacao": "2024-10-10T09:00:00",
    "ativo": true,
    "local_id": 61
  }
]
```

---

### GET `/locais-culturais/{id}/noticias/{noticia_id}`

Obtém detalhes completos de uma notícia específica.

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |
| `noticia_id` | integer | Sim | ID da notícia |

**Exemplo de Request:**

```http
GET /locais-culturais/61/noticias/1
```

**Exemplo de Response (200 OK):**

```json
{
  "id": 1,
  "titulo": "Nova exposição de arte flamenga chega a Lisboa",
  "conteudo": "O Museu Nacional de Arte Antiga inaugura...",
  "resumo": "Nova mostra dedicada à pintura flamenga",
  "imagem": "https://picsum.photos/500/300?random=101",
  "data_publicacao": "2024-10-10T09:00:00",
  "ativo": true,
  "local_id": 61,
  "destaque": 1
}
```

---

### GET `/noticias`

Lista todas as notícias ativas da plataforma.

**Exemplo de Request:**

```http
GET /noticias
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id": 1,
    "titulo": "Nova exposição de arte flamenga chega a Lisboa",
    "resumo": "Nova mostra dedicada à pintura flamenga",
    "imagem": "https://picsum.photos/500/300?random=101",
    "data_publicacao": "2024-10-10T09:00:00",
    "ativo": true,
    "local_id": 61
  }
]
```

---

## 👤 Perfil do Utilizador

### GET `/profile`

Obtém informações pessoais do utilizador autenticado.

**Autenticação:** Requerida

**Parâmetros de Query:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `access-token` | string | Sim | Token de autenticação |

**Exemplo de Request:**

```http
GET /profile?access-token=123456
```

**Exemplo de Response (200 OK):**

```json
{
  "username": "maria102",
  "email": "maria@gmail.com",
  "primeiro_nome": "Maria",
  "ultimo_nome": "Mendes",
  "imagem_perfil": "/upload/uhf39239vw.png"
}
```

---

## ⭐ Favoritos

### GET `/profile/favoritos`

Lista todos os locais culturais marcados como favoritos pelo utilizador.

**Autenticação:** Requerida

**Exemplo de Request:**

```http
GET /profile/favoritos?access-token=123456
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "local_id": 1,
    "local_nome": "Museu Alegre",
    "local_tipo": "Museu",
    "local_imagem": "/upload/2049329dasdf.png",
    "local_distrito": "Viseu",
    "local_morada": "Rua das Flores 123"
  }
]
```

---

### POST `/profile/favoritos`

Adiciona um local cultural aos favoritos do utilizador.

**Autenticação:** Requerida

**Parâmetros (Body JSON):**

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `local_id` | integer | Sim | ID do local a adicionar |

**Exemplo de Request:**

```json
POST /profile/favoritos?access-token=123456789876543
Content-Type: application/json

{
  "local_id": 2
}
```

**Exemplo de Response (201 Created):**

```json
{
  "success": true,
  "message": "Local adicionado aos favoritos com sucesso!",
  "data": {
    "id": 1,
    "utilizador_id": 15,
    "local_id": 2,
    "local_nome": "Museu Nacional de Arte Antiga",
    "data_adicao": "2024-11-06T15:30:00"
  }
}
```

---

### DELETE `/profile/favoritos/{id}`

Remove um local dos favoritos do utilizador.

**Autenticação:** Requerida

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do favorito a remover |

**Exemplo de Request:**

```http
DELETE /profile/favoritos/1?access-token=123456789876543
```

**Exemplo de Response (200 OK):**

```json
{
  "success": true,
  "message": "Local removido dos favoritos com sucesso!"
}
```

---

## 🎫 Reservas e Bilhetes

### GET `/profile/bilhetes`

Lista todas as reservas e bilhetes do utilizador autenticado.

**Autenticação:** Requerida

**Exemplo de Request:**

```http
GET /profile/bilhetes?access-token=12345678
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id": 1,
    "local_id": 61,
    "local_nome": "Museu Nacional de Arte Antiga",
    "data_visita": "2024-11-15",
    "preco_total": 25.00,
    "estado": "confirmada"
  }
]
```

---

### GET `/profile/bilhetes/{id}`

Obtém detalhes completos de uma reserva/bilhete específico.

**Autenticação:** Requerida

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do bilhete |

**Exemplo de Request:**

```http
GET /profile/bilhetes/1?access-token=12345678
```

**Exemplo de Response (200 OK):**

```json
{
  "id": 1,
  "utilizador_nome": "Maria Santos",
  "local_id": 61,
  "local_nome": "Museu Nacional de Arte Antiga",
  "data_visita": "2024-11-15",
  "preco_total": 25.00,
  "estado": "confirmada",
  "data_criacao": "2024-11-01T14:30:00",
  "bilhetes": [
    {
      "tipo": "Adulto",
      "quantidade": 2,
      "preco_unitario": 10.00,
      "subtotal": 20.00
    },
    {
      "tipo": "Criança",
      "quantidade": 1,
      "preco_unitario": 5.00,
      "subtotal": 5.00
    }
  ]
}
```

---

## ⭐ Avaliações

### GET `/locais-culturais/{id}/avaliacoes`

Lista todas as avaliações de um local cultural.

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |

**Exemplo de Request:**

```http
GET /locais-culturais/61/avaliacoes
```

**Exemplo de Response (200 OK):**

```json
[
  {
    "id": 1,
    "utilizador": "João Silva",
    "classificacao": 4.8,
    "comentario": "Espaço incrível com obras imperdíveis como o Painel de São Vicente. Atendimento simpático e ótima organização.",
    "data_avaliacao": "2024-02-12",
    "ativo": true
  }
]
```

---

### POST `/locais-culturais/{id}/avaliacoes`

Cria uma nova avaliação para um local cultural.

**Autenticação:** Requerida

**Parâmetros (Body JSON):**

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `local_id` | integer | Sim | ID do local cultural |
| `classificacao` | float | Sim | Classificação de 0 a 5 |
| `comentario` | string | Não | Comentário da avaliação |

**Exemplo de Request:**

```json
POST /locais-culturais/61/avaliacoes?access-token=123456
Content-Type: application/json

{
  "local_id": 61,
  "classificacao": 4.3,
  "comentario": "Muito bom!"
}
```

**Exemplo de Response (201 Created):**

```json
{
  "success": true,
  "message": "Avaliação criada com sucesso!",
  "id": 1,
  "user_id": 2,
  "local_id": 61,
  "classificacao": 4.3,
  "comentario": "Muito bom!",
  "data_avaliacao": "2024-10-10",
  "ativo": true
}
```

---

### PUT `/locais-culturais/{id}/avaliacoes/{avaliacao_id}`

Atualiza uma avaliação existente (apenas o autor pode atualizar).

**Autenticação:** Requerida

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |
| `avaliacao_id` | integer | Sim | ID da avaliação |

**Parâmetros (Body JSON):**

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `classificacao` | float | Não | Nova classificação |
| `comentario` | string | Não | Novo comentário |

**Exemplo de Request:**

```json
PUT /locais-culturais/61/avaliacoes/2?access-token=123456
Content-Type: application/json

{
  "classificacao": 4.5,
  "comentario": "Muito bom, vale a pena visitar!"
}
```

**Exemplo de Response (200 OK):**

```json
{
  "success": true,
  "message": "Avaliação alterada com sucesso",
  "id": 2,
  "classificacao": 4.5,
  "comentario": "Muito bom, vale a pena visitar!",
  "data_avaliacao": "2024-10-10"
}
```

---

### DELETE `/locais-culturais/{id}/avaliacoes/{avaliacao_id}`

Remove uma avaliação (apenas o autor pode remover).

**Autenticação:** Requerida

**Parâmetros de Path:**

| Parâmetro | Tipo | Obrigatório | Descrição |
|-----------|------|-------------|-----------|
| `id` | integer | Sim | ID do local cultural |
| `avaliacao_id` | integer | Sim | ID da avaliação |

**Exemplo de Request:**

```http
DELETE /locais-culturais/61/avaliacoes/2?access-token=123456
```

**Exemplo de Response (200 OK):**

```json
{
  "success": true,
  "message": "Avaliação removida com sucesso!"
}
```

---

## 📊 Códigos de Status HTTP

| Código | Descrição |
|--------|-----------|
| `200` | **OK** - Pedido bem-sucedido |
| `201` | **Created** - Recurso criado com sucesso |
| `400` | **Bad Request** - Parâmetros inválidos |
| `401` | **Unauthorized** - Autenticação necessária ou token inválido |
| `403` | **Forbidden** - Sem permissão para aceder ao recurso |
| `404` | **Not Found** - Recurso não encontrado |
| `422` | **Unprocessable Entity** - Erro de validação |
| `500` | **Internal Server Error** - Erro no servidor |

---

**Versão:** 1.0.0  
**Última Atualização:** Outubro 2025