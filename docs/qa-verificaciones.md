
# Verificaciones de calidad - QA

El proyecto utiliza Laravel Pint y PHPUnit para verificar la calidad del código y ejecutar pruebas automatizadas.

## Comandos de verificación

- `vendor/bin/pint --test`: revisa el formato del código PHP.
- `php artisan test`: ejecuta las pruebas automatizadas.
- `npm run build`: comprueba la compilación del frontend.

Las verificaciones también se ejecutan mediante GitHub Actions en los Pull Requests dirigidos a `main`.
