# Reusable DTO Validation

## ⚠ This homemade feature is now outdated

With Symfony 6.3 we can now use `MapRequestPayload`

[https://symfony.com/blog/new-in-symfony-6-3-mapping-request-data-to-typed-objects](https://symfony.com/blog/new-in-symfony-6-3-mapping-request-data-to-typed-objects)


## Try it at home

#### Launch web server
````bash
symfony composer install
symfony server:start
````

#### Send data to API

With Postman, cURL, ...

POST https://127.0.0.1:8000/product

JSON body with keys : uuid, label, price, customValue1, customValue2
````cURL
curl --location --request POST 'https://127.0.0.1:8000/product' \
--header 'Content-Type: application/json' \
--data-raw '{
    "uuid": "test",
    "label": "",
    "price": 10
}'
````
