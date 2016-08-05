<?php
include("inc/functions.php");

if( $_POST ){
    //se sono qui ed esiste l'array superglobale $_POST
    $all_books = select_books_filtered($_POST["genereSelect"], $_POST["stringaRicerca"]);
    $strsearch = $_POST["stringaRicerca"];
}else{
   $all_books = select_all_books();
   $strsearch ="";
}

$all_genres = select_all_genres();
?>
<!DOCTYPE html>
<html lang="it" ng-app="LibreriaApp" ng-cloak>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#ffffff">
        <title>Libreria</title>
        <!-- CSS -->
        <!-- favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
        <link rel="manifest" href="icon/manifest.json">
        
        <!-- font awesome -->
        <link href='css/font-awesome.min.css' rel='stylesheet'/>
        <!-- custom css -->
        <link href="css/custom.min.css" rel="stylesheet" />
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <!-- Google fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="wrapper">
            <div class="navbar navbar-fixed-top topbar">
                <a href="./formLibro.php?az=aggiungi"><button type="button" class="btn btn-default pull-right">Aggiungi Libro</button></a>
            </div>
            <!--barra fissa posizione top -->
            <!-- main content -->
            <div class="container content" ng-controller="MainController">
                <div class="row">
                    <div class="col-xs-12 page-header">
                        <h1 id="intestazione-libreria">Libreria : Elenco dei libri</h1>
                    </div>
                </div>
                <!-- fine row -->
                <div class="row select-box">
                    <form id="frmSearch" method="POST" action="index.php">
                        <div class="form-group col-xs-12 col-md-3 pull-left">
                            <label for="genere_select">Genere</label>
                            <?php if($_POST ){ ?>
                            <div ng-init="selettoreCategoria=<?php echo $_POST["genereSelect"];?>"></div>
                            <?php }else{?>
                            <div ng-init="selettoreCategoria=0"></div>
                            <?php }?>
                            <select name="genereSelect" class="form-control" id="genereSelect" ng-model="selettoreCategoria">
                                <option ng-selected="isSelected(0)" value="0">Tutti</option>
                                <?php foreach ($all_genres as $genre) { ?>
                                    <option ng-selected="isSelected(<?php echo $genre["gen_id"]; ?>)" value="<?php echo $genre["gen_id"]; ?>"><?php echo $genre["gen_nome"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-xs-12 col-md-3">
                            <label for="stringaRicerca">Contiene</label>
                            <div class="row">
                                <div class="col-xs-12 col-md-9">
                                    <input name="stringaRicerca" type="text" id="stringaRicerca" class="form-control" value="<?php echo $strsearch; ?>"/>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                    <button id="btn-search" type="submit" class="btn btn-default">CERCA LIBRO</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- fine row -->
                <div class="row">
                    <div class="col-xs-12 col-md-10">
                        <h3 id="genere-scelto">Lista filtrata secondo i criteri selezionati</h3>
                    </div>
                </div>
                <!-- fine row -->
                <!-- lista libri -->
                <?php foreach ($all_books as $book) { ?>
                    <div class="row" ng-show="mostraRiga(<?php echo $book["lib_gen_id"]; ?>)">
                        <div class="col-xs-12 libro">
                            <div class="row title-row">
                                <div class="col-xs-12">
                                    <h3 class="titolo-libro"><?php echo $book["lib_titolo"]; ?><span class="pull-right genere-libro"><?php echo $book["gen_nome"] . " "; ?><i class="fa fa-book"></i></span></h3>
                                </div>
                            </div>
                            <div class="row author-row">
                                <div class="col-xs-12">
                                    <div class="autore-libro">Di : <?php echo $book["lib_autore"]; ?></div>
                                </div>
                            </div>
                            <div class="row description-row">
                                <div class="col-xs-12">
                                    <h4 class='descrizione-intestazione'>Breve descrizione</h4>
                                    <div class="descrizione-libro">
                                        <?php echo $book["lib_descrizione"]; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row price-row">
                                <div class="col-xs-12">
                                    <div class="prezzo-libro">Prezzo : <?php echo $book["lib_prezzo"]; ?> €</div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row modify-row">
                                <div class="col-xs-12">
                                    <div class="modify-text">Modifica <a href="./formLibro.php?az=modifica&id_libro=<?php echo $book["lib_id"]; ?>"><i class="fa fa-arrow-right"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- fine lista libri -->
            </div>
        </div>



        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-1.11.3.min.js"></script>
        <!-- script personali -->
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <!-- angular js -->
        <script src="js/angular.min.js"></script>
        <!-- angular js app -->
        <script src="js/app/app.js"></script>
        <!-- angular js controller -->
        <script src="js/controller/main-controller.js"></script>
    </body>
</html>