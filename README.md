1° Instale o php versão 8.1 NTS (Non Thread Safe) <br>
https://windows.php.net/download#php-8.1 <br>
2° Instale o composer  <br>
https://getcomposer.org/download/ <br>
3° Instale o laravel globalmente <br>
composer global require laravel/installer <br>
4° Localize o php.ini e insira a seguinte extensão no arquivo <br>
extension=php_pdo_sqlsrv_81_nts_x64 <br>
5° Baixe drivers para fazer a conexão do php com o banco de dados <br>
https://learn.microsoft.com/pt-br/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver16 <br>
6° Abra o projeto no cmd e execute o seguinte comando <br>
composer install <br>
7° Posteriormente, execute esse comando no cmd para configurar o projeto <br>
copy .env.example .env <br>
8° Para executar o projeto, setando o host a aplicação poderá ser acessada de outro dispositivo na rede <br>
php artisan serve --host=192.168.0.159 --port=80 <br>
