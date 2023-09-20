## Subir docker
docker-compose up -d

## Subir projeto
Terminal do container php
<br>
php artisan serve
<br>
http://localhost:8080/

## Gerar migration exemplo
php artisan make:migration create_pedido_item_table

## Rodar migration
php artisan migrate

## Gerar Swagger após modificação
php artisan l5-swagger:generate

## Falta fazer
Testes unitarios
<br>
CI/CD
<br>
Melhorar a forma de documentação (deixar mais automático)
