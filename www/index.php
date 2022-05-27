<html>
 <head>
  <title>Hello...</title>

  <meta charset="utf-8"> 

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
    <?php echo "<h1>Hi! I'm happy</h1>"; ?>

    <?php
    require_once 'security.php';


    // Connexion et sélection de la base
    // $conn = mysqli_connect('db', 'user', 'test', "myDb");


    // $query = 'SELECT * From Person';
    // $result = mysqli_query($conn, $query);

    // echo '<table class="table table-striped">';
    // echo '<thead><tr><th></th><th>id</th><th>name</th></tr></thead>';
    // while($value = $result->fetch_array(MYSQLI_ASSOC)){
    //     echo '<tr>';
    //     echo '<td><a href="#"><span class="glyphicon glyphicon-search"></span></a></td>';
    //     foreach($value as $element){
    //         echo '<td>' . $element . '</td>';
    //     }

    //     echo '</tr>';
    // }
    // echo '</table>';

    // /* Libération du jeu de résultats */
    // $result->close();

    // mysqli_close($conn);

    try {
        $pdo = new PDO("mysql:dbname=myDb;host=db;",
                        "user",
                        "test"
                        , array(PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8")
                    );
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo
       $error_message = date('Y-m-d G:i:s') . " [ERROR]: " . $e->getMessage() . "\n\r";
       file_put_contents('PDOErrors.txt', $error_message, FILE_APPEND);
        $db = null;
    }
    // $temp = $pdo->query("SELECT * FROM Person")->fetch(PDO::FETCH_COLUMN);

    // echo "<h1>$temp</h1> "; 


    try {
        $pdo_dos = new PDO("mysql:dbname=$MYSQL_DATABASE;host=$MYSQL_HOST;",
                        "$MYSQL_USER",
                        "$MYSQL_PASSWORD"
                        , array(PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8")
                    );
         $pdo_dos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo
       $error_message = date('Y-m-d G:i:s') . " [ERROR]: " . $e->getMessage() . "\n\r";
       file_put_contents('PDOErrors.txt', $error_message, FILE_APPEND);
        $db = null;
    }


    // para listar todas las tablas tengo 2 opciones
    // show tables (prefiero esta porque solo me trae las tablas de la bd actaul)
    // select table_name from information_schema.tables;

    // apartir de aqui crea un funcion para insertar datos, pasandole de parametros el nombre de la tabla y el limit
    $usuarios = $pdo_dos ->query("SELECT codNoEmpleado, usuario, contrasena, tipoUsuario, correo, status, sucursal 
    FROM usuarios 
    where codNoEmpleado not in (1,2)")->fetchAll(PDO::FETCH_ASSOC);


    $describe = $pdo_dos ->query("describe usuarios")->fetchAll(PDO::FETCH_ASSOC);
    $crear_table = "CREATE TABLE usuarios (";
    $index_i = 0;
    $describe_lenght = count($describe);
    foreach($describe as $i => $fila){
        if($index_i < $describe_lenght-1){
            $crear_table.= $fila["Field"]. " " . $fila["Type"]. ", ";
        }else{
            $crear_table.= $fila["Field"]. " " . $fila["Type"];
        }
        $index_i+=1;
    }
    $crear_table.=")";
    // echo $crear_table;
    $pdo->exec($crear_table);

    $inserta_sql = "INSERT INTO usuarios (codNoEmpleado, usuario, contrasena, tipoUsuario, correo, status, sucursal)
        VALUES";
    $inserta_usuario = "";
    $temp_dos = count($usuarios);
    $temp = count($usuarios[0]);
    $index_i = 0;
    foreach($usuarios as $i =>$usuario){
        $inserta_usuario.= "(";
        $index_j = 0;
        foreach($usuario as $j => $col){  
            if($index_j < $temp -1){
                $inserta_usuario.="'".$col."'";
                $inserta_usuario.=",";
            }else{
                $inserta_usuario.="'".$col."'";
            }
            $index_j+= 1;
        }
        if($index_i < $temp_dos -1){
            $inserta_usuario.="), ";
        }else{
            $inserta_usuario.=");";
        }
        $index_i+= 1;
    }
    $inserta_sql.= $inserta_usuario;
    echo $inserta_sql; // falta esto insertart a la table
    $pdo->exec($inserta_sql);
    ?>

    
    </div>
</body>
</html>
