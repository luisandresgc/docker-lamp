#* 1. (Tener los dump de las dases de datos que necesites, estas tienen que estar en UTF-8)
# (irse al servidor de amazon / produccion)
# (abrir la terminal en VSCode)
# cd C:\xampp\mysql\bin (NO ES NECESARIO)
# mysqldump -u root [nombre-de-la-database-en-produccion] > [nombre_del_archivo].sql OR
# mysqldump -u root [nombre-de-la-database-en-produccion] -r [nombre_del_archivo].sql
# (abrir el archivo generado en el bloc de notas y guardarlo como UTF-8)

#* 2. docker exec -it [nombre-del-contenedor-de-la-database] bash

#* 3. cd docker-entrypoint-initdb.d/
cd docker-entrypoint-initdb.d/

#* 4. Crear las bases de datos
mysql -u root -p
test
create database pedidosalmacen;
create database sae;
create database sistemanomina_prueba;
exit;

#* 5. mysql -u root -p [nombre-de-la-database-en-localhost] < [nombre_del_archivo].sql
mysql -u root -p pedidosalmacen < pedidosalmacen.sql
test
mysql -u root -p sae < sae.sql
test
mysql -u root -p sistemanomina_prueba < sistemanomina_prueba.sql
test