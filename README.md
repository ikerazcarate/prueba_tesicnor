#APLICACIÓN WEB PARA BUSCAR PELICULAS DE STAR WARS

##DESCRIPCIÓN:
Aplicación Web en React que muestra el listado completo de películas de star wars, y que es capaz de filtar por titulo y año sin necesidad de recargar la página.
Esta aplicación consigue los datos a través de una API de nuestro servidor PHP, el cuál recoge los datos con una consulta en https://www.omdbapi.com y los almacena en una base de datos local.

##INSTRUCCIONES PARA LA INSTALACIÓN
El proyecto consta de 2 carpetas backend_php y catalogo_peliculas, al tratarse de una prueba he usado herramientas que permiten simular la web en un entorno local.
Pero se podría subir a un hoster cambiando las urls por el nuevo dominio en el código y creando el build de la app react (npm run build).
A continuación voy a explicar los pasos que he seguido para probar el código de manera local:
1. Para crear el servidor backend debemos de instalar XAMPP.
2. Una vez instalado creamos la carpeta C:\xampp\htdocs\prueba-tesicnor\ y copiamos los documentos de backend_php dentro de ella.
3. Iniciamos XAMPP y le damos Start a los modulos de Apache y MySQL
4. Accedemos a la Administración de MySQL
5. Creamos la base de datos peliculas con una unica tabla, se puede crear ejecutando el siguiente código SQL:
   CREATE DATABASE peliculas;
   CREATE TABLE `peliculas_star_wars` (
    `ID` varchar(15) NOT NULL,
    `Titulo` varchar(500) NOT NULL,
    `Fecha` int(4) DEFAULT NULL,
    `Descripcion` varchar(500) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
   
6.  Después de crear la Base de Datos la poblamos con el siguiente servicio web php: localhost/prueba-tesicnor/CargarDatos.php
    Nota: También se podría crear un script que automatice esta carga.
7. Una vez preparado el backend, solo nos falta ejecutar nuestra app en React, para ello instalamos npm.
8. Una vez instalado solo debemos acceder a la carpeta catalogo_peliculas y ejecutar el comando npm start

Con eso ya deberíamos poder ver una web con el listado completo de peliculas de star wars

##PLANIFICACIÓN
1. Estudio de requisitos
2. Estudio de las consultas a la API https://www.omdbapi.com
3. Dividir el proyecto en secciones: Carga de datos, Creación de BBDD, Backend PHP (Model), Web Services y Front-End (React)
4. Creación de BBDD en phpMyAdmin
5. Creación de Model, Conexión a BBDD y Web Services
6. Front-End (Aplicación React) - Nota: Esta tarea no me llevo mucho tiempo ya que pude aprovechar código de uno de mis proyectos previos. 
7. Carga de Datos: Debido a algunos bugs con las consultas a la API tuve que postponer la tarea hasta este momento.
8. Solucionar bugs
9. Filtrado de la lista
10. Estilado
11. Documentación

##CUESTIONARIO
1. Si te asignan una tarea y ves que la funcionalidad no está definida al 100%, ¿qué haces?
   
   Intento recopilar más información, ya que si no está totalmente definida puede que la aplicación no alcance los estandares deseados y supongo una mayor perdida de tiempo.
   Por lo que intentaría concertar una reunión con mi superior, un compañero más experto o con el cliente para intentar tener toda la información que necesito.
   
3. ¿Has utilizado algún sistema de control de versiones? ¿Cómo lo usabas?

   Sí, he usado git tanto en Gitlab como en Github. Normalmente lo usaba para tener un historial de mi proyecto y para colaborar con otros compañeros.
