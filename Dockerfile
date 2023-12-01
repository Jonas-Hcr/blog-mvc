# Imagem oficial do PHP 8.2
FROM php:8.2

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Instalação do Composer 2 (latest version)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Diretório do projeto dentro do container
WORKDIR /var/www/html

# Copiando arquivo do projeto para o container
COPY . .

# Instalando as dependências do Composer
RUN composer install

# Exponha a porta 8000 para o servidor PHP interno
EXPOSE 8000

# Comando para iniciar o servidor PHP interno
CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]

