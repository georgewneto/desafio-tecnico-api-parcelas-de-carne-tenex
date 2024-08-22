# desafio-tecnico-api-parcelas-de-carne-tenex
Desafio técnico para a Tenex, API REST para Parcelas de Carnê

## **Tech Stack**
- PHP 8.3.4
- Laravel 11.1.4

## Explicando o código
routes/api.php
- **GET** /carne/{id}
- **POST** /gerar-parcelas

app/Http/Controllers/CarneController.php
- **show($id)** - recupera o carne e as parcelas através do ID do carnê
- **store(Request $request)** - recebe a requisição, valida,  processa e armazena os dados. 

app/Services/ParcelasService.php
- **gerarParcelas($valor_total, $qtd_parcelas, $data_primeiro_vencimento, $periodicidade, $valor_entrada)** - essa função é utilizada pelo CarneController->store(), nela ficam as regras de negócio para o processamento (geração do carnê e parcelas e armazenamento)

## Endpoints da API
- [POST] http://localhost:8000/api/gerar-parcelas
- [GET] http://localhost:8000/api/carne/{$id}

## Para rodar o projeto

execute os seguintes comandos (antes disso, copiar o arquivo .env enviado por email, dentro da pasta **api-parcelas-de-carne**):

- composer install
- php artisan migrate
- php artisan serve (ou php artisan serve --host=0.0.0.0 --port=8000)
