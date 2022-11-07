## COMANDOS PARA EL DESPLIEGE
- composer install
- actualizar los parametros de coneccion de la base de datos en el .env
- php artisan migrate --seed
- php artisan key:generate
- php artisan passport:client --personal
    - colocar como nombre al nuevo cliente "FileApi"
    - actualizar las variables de entorno en el .env las siguientes claves:
        - PASSPORT_PERSONAL_ACCESS_CLIENT_ID
        - PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET

## GUIA
- la coleccion del postmas esta en la raiz de este proyecto con el nombre "laravel-avanza.postman_collection.json"
    - he considerado dos variables en el entorno del postmas que son:
        - url: contiene la direcion url del api
        - token: contiene la cadena del token que se genera en el servicio "Sing In"