# Projeto Star Wars - Sistema de Filmes

Este projeto foi desenvolvido para exibir uma lista de filmes do universo Star Wars. O sistema foi desenvolvido sem o uso de frameworks, com código totalmente personalizado.

## Requisitos

Antes de executar o projeto, certifique-se de ter os seguintes requisitos instalados:

- **PHP** (versão 7.4 ou superior)
- **MySQL** ou **MariaDB**
- **XAMPP** (para facilitar a configuração do servidor local)
- **Navegador de sua preferência** (Google Chrome, Mozilla Firefox, etc.)

## Estrutura do Projeto

- **index.php**: Página inicial do sistema com a exibição dos filmes.
- **style.css**: Arquivo CSS responsável pela estilização da interface.
- **database.sql**: Script de criação do banco de dados e tabelas.

## Como Executar o Projeto

1. **Instalar o XAMPP**:
   - Faça o download e instale o [XAMPP](https://www.apachefriends.org/index.html).
   
2. **Configuração do Banco de Dados**:
   - Abra o XAMPP e inicie o Apache e o MySQL.
   - Acesse o **phpMyAdmin** pelo navegador em `http://localhost/phpmyadmin/`.
   - Crie um novo banco de dados chamado `star_wars`.
   - Importe o arquivo `star_wars.sql` para criar as tabelas necessárias.

3. **Configuração do Projeto**:
   - Coloque os arquivos do projeto na pasta `htdocs` do XAMPP.
   - No navegador, acesse `http://localhost/starwars/` para visualizar o sistema.

## Banco de Dados

O banco de dados utilizado é o MySQL, com a estrutura conforme descrita abaixo.

### Tabela `api_logs`
Armazena logs de requisições à API.

| Nome da Coluna  | Tipo de Dados   | Descrição                           |
|-----------------|-----------------|-------------------------------------|
| `id`            | INT(11)         | Identificador único (auto incremento)|
| `endpoint`      | VARCHAR(255)    | Endpoint da requisição              |
| `request_time`  | TIMESTAMP       | Data e hora da requisição (valor padrão é o momento da requisição) |

### Tabela `cont_visual`
Armazena o número de visualizações dos filmes.

| Nome da Coluna  | Tipo de Dados   | Descrição                           |
|-----------------|-----------------|-------------------------------------|
| `cont_id`       | INT(11)         | Identificador único (auto incremento)|
| `film_id`       | INT(11)         | Identificador do filme              |

### Tabela `favorite_film`
Armazena os filmes favoritos do usuário.

| Nome da Coluna  | Tipo de Dados   | Descrição                           |
|-----------------|-----------------|-------------------------------------|
| `favorite_id`   | INT(11)         | Identificador único (auto incremento)|
| `film_id`       | INT(11)         | Identificador do filme              |
| `active`        | VARCHAR(1)      | Indica se o filme é favorito ('S' para sim, 'N' para não) |

## Melhorias Aplicadas

1. **Funcionalidade de Favoritos**: Agora é possível marcar filmes como favoritos. A funcionalidade permite adicionar ou remover filmes da lista de favoritos.
   
2. **Contagem de Visualizações**: Foi implementado um sistema para contar quantas vezes cada filme foi visualizado. Cada visualização é registrada na base de dados.

3. **Filtro de Filmes**: Foi adicionado um filtro na página inicial que permite ao usuário visualizar apenas os filmes favoritos ou todos os filmes.

## Considerações Finais

Este projeto foi desenvolvido como um exercício para demonstrar habilidades em PHP, MySQL e desenvolvimento de front-end com HTML e CSS. A ideia foi criar uma interface simples e interativa para os filmes do universo Star Wars.

## Contato

Para dúvidas ou sugestões, entre em contato com [guilhermevalencia@gmail.com](mailto:guilhermevalencia@gmail.com).

### 1. Baixe ou clone o repositório:
```bash
git clone <https://github.com/guivalencia/starwars>