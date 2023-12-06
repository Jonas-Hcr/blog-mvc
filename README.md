# blog-mvc
Blog with pure PHP, using MVC

# Passos para instalação:
- Clone o projeto
- Rode o comando: 
    `docker-compose up --build -d`
- Agora rode: `composer install`
- Após os container subirem, o projeto já estará disponível em http://localhost:8000/
- Verifique se os dados do banco estão corretos em `config.php`
- Para rodar as migrations, criar as tabelas e as seeds, vá em: http://localhost:8000/setup
- Caso dê tudo certo, você pode ir em http://localhost:8000/admin/login e colocar os dados: 
    - e-mail: admin@jonashcr.com.br
    - senha: @dmin123