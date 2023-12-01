# Imagem oficial do PHP 8.2 Apache
FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Configurações adicionais do Apache
COPY apache/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN service apache2 restart

# Instalação do Composer 2 (latest version)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Diretório do projeto dentro do container
WORKDIR /var/www/html

# Copiando arquivo do projeto para o container
COPY . .

# Instalando as dependências do Composer
RUN composer install

# Exponha a porta 80 para o Apache
EXPOSE 80

# Comando para iniciar o servidor Apache
CMD ["apache2-foreground"]
