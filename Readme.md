Proyecto desarrollado desde framework laravel
1.- Alojar repositorio en su servidor web
2.- Abra una terminal y posicionarse en la carpeta del proyecto ejemplo "C:\www\htdocs\desweb-app"
3.- Ejecutar "composer install" desde la terminal
4.- Ejecutar "php artisan key:generate" desde la terminal
5.- Crear una base de datos llamada "desweb"
6.- Crear un archivo ".env" en la raiz del proyecto
7.- Copiar contenido de ".env.example" a ".env" (en este archivo debes configurar conexión a la base de datos)
8.- Ejecutar "php artisan migrate" desde la terminal

Abra su navegador web e ingrese la siguiente url para ejecutar el sistema:
http://localhost/desweb-app/public

Otra manera de ejectar el sistema

Abra la terminar y ejecutar "php artisan serve"
Abra su navegador web e ingrese la siguiente url para ejecutar el sistema:
http:://localhost:8000