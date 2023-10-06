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

## Rodar testes
php artisan test

## Gerar Swagger após modificação
php artisan l5-swagger:generate

## Exemplos subir s3, sqs, sns
awslocal s3api create-bucket --bucket laravel-infra
awslocal sns create-topic --name laravel-topico
awslocal sqs create-queue --queue-name laravel-fila

## Exemplo .env
AWS_ACCESS_KEY_ID=qualquer
AWS_SECRET_ACCESS_KEY=qualquer
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=laravel-infra
AWS_USE_PATH_STYLE_ENDPOINT=true
AWS_ENDPOINT="http://localstack:4566/"


## Falta fazer
CI/CD
<br>
Melhorar a forma de documentação (deixar mais automático)
