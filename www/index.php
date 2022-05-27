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
    $conn = mysqli_connect('db', 'user', 'test', "myDb");


    $query = 'SELECT * From Person';
    $result = mysqli_query($conn, $query);

    echo '<table class="table table-striped">';
    echo '<thead><tr><th></th><th>id</th><th>name</th></tr></thead>';
    while($value = $result->fetch_array(MYSQLI_ASSOC)){
        echo '<tr>';
        echo '<td><a href="#"><span class="glyphicon glyphicon-search"></span></a></td>';
        foreach($value as $element){
            echo '<td>' . $element . '</td>';
        }

        echo '</tr>';
    }
    echo '</table>';

    /* Libération du jeu de résultats */
    $result->close();

    mysqli_close($conn);

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
    $temp = $pdo->query("SELECT * FROM Person")->fetch(PDO::FETCH_COLUMN);

    echo "<h1>$temp</h1> "; 


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

    $temp = $pdo_dos->query("SELECT sucursal FROM usuarios limit 1")->fetch(PDO::FETCH_COLUMN);

    echo "<h1>$temp</h1> "; 

    ?>
    </div>
</body>
</html>
