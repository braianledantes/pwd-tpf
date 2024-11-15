# PWD | TP Final | Grupo 2
- Tecnicatura Universitaria en Desarrollo Web
- Facultad de Informática
- Universidad Nacional del Comahue
- Programacion Web Dinámica

## Integrantes del Grupo N°2
- **Braian Ledantes** - Legajo FAI-1686 - mail: braian.ledantes@est.fi.uncoma.edu.ar - Github: braianledantes
- **Clara Pelozo** - Legajo FAI-4938 - mail: clara.pelozo@est.fi.uncoma.edu.ar - Github: ClariMel1
- **Luciana Romano** - Legajo FAI-3075 - mail: luciana.romano@est.fi.uncoma.edu.ar - Github: Lucianaromano

## Bibliotecas utilizadas
<!-- TODO: agregar las bibliotecas -->

## Pruebas
1. Instalar XAMP.
2. Copiar el repositorio en la carpeta donde esta instalado XAMP. Por ejemplo `C:\xampp\htdocs`.
3. Iniciar el servidor de Apache.
4. Iniciar el servidor MySql
5. Crear la base de datos *dbcarritocompras*
6. Importar el contenido de la base de datos del archivo *bdcarritocompras.sql*
7. Ingresar en el navegador la URL: http://localhost/pwd-tp-final/.

# Enunciado
## Objetivo
El objetivo del trabajo es integrar todosl los conceptos vistos en la materia. Se espera que el alumno implemente un **Carrito de Compra** que tendrá 2 vistas: Pública y Privada.
Desde el acceso público se van a poder visualizar todos los artículos que pueden ser seleccionados de la tienda, información de contacto de la tienda y el acceso a la parte Privada.
El acceso a la parte privada del *Carrito* solo podrá ser realizado por aquellos usuarios habilitados de la aplicación que pueden tener uno de los siguietes roles: *Cliente*, *Administrador*.
## Pautas básicas
1. La aplicación debe ser desarrollada sobre una arquitectura MVC (Modelo-Vista-Controlador) utilizando PHP como lenguaje de programación. Se otorgará una estructura de directorio inicial.
    - Control
    - estructura
    - Modelo
    - Test
    - util
    - Vista
    - configuracion.php
2. Utilizar la Base de Datos MySql ***dbcarritocompras*** otorgada por la cátedra. Realizar el MOR de las tablas del modelo de base de datos. (*ver ilustración 2 y archivo .sql*)
3. La aplicación tendrá páginas públicas y otras restringidas que sólo podrán ser accedidas a partir de un usuario y contraseña. Utilizar el módulo de autenticación implementado en el TP5. La aplicación debe tener como mínimo 2 roles: *cliente* y *administrador*.
4. El menú de la aplicación debe ser un menú dinámico que pueda ser gestinodo por el administrador de la aplicación. El modelo de datos será otorgado por la cátedra.
5. Desde el módulo los usuarios registrados con el rol *clientes* podrán:
    1. Gestionar los datos de su cuenta como: cambiar su e-mail, contraseña, etc.
    2. Realizar la compra de uno o más productos **con stock**.
6. Módulo de administracion, solo podrá ser accedido por el perfil de usuario de mayor nivel. Dentro de las operaciones que pueden realizar encontramos: *Administración de Usuarios*, *roles*, *menú*, y *productos*. *Alta, baja y modificación* (*ABM*).
    a. Acceso a los procedimientos que perminte el cambio de estado de los *productos*.