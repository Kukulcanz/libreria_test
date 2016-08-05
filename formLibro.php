<?php if (!$_GET) { ?>
    <div class="row">
        <div class="col-xs-12">
            <h1 class="text-danger">Errore di visualizzazione ; torna alla pagina <a href="./index.php">index.php</a></h1>
        </div>
    </div>
    <?php
} else {
    include("inc/functions.php");
    
    if ($_GET["az"] === "aggiungi") {
        $id = 0;
        
        $libro=$genere=$titolo=$autore=$descrizione=$prezzo="";
    } else if ($_GET["az"] === "modifica") {
        $id = $_GET["id_libro"];
        
        $libro = select_book_by_id($id);
        $genere = $libro["lib_gen_id"];
        $titolo = $libro["lib_titolo"];
        $autore = $libro["lib_autore"];
        $descrizione = $libro["lib_descrizione"];
        $prezzo = $libro["lib_prezzo"];            
    }
    
    
    $all_genres = select_all_genres();
    ?>
    <!DOCTYPE html>
    <html lang="it" ng-app="LibreriaApp">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Libreria - <?php echo $_GET["az"]; ?> libro</title>
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
                    <div class="pull-left"><a href="./index.php"><i class="fa fa-arrow-left"></i></a> Torna indietro</div>
                </div>
                <!--barra fissa posizione top -->
                <!-- main content -->
                <div class="container content">
                    <div class="row">
                        <div class="col-xs-12 page-header">
                            <h1 id="intestazione-libreria"><?php echo $_GET["az"]; ?> libro</h1>
                        </div>
                    </div>
                    <!-- fine row -->
                    <div class="row select-box">
                        <!-- form di inserimento e modifica -->
                        <form name="frmDati" novalidate ng-controller="FormController">
                            <?php if ( $id !=0 ){ ?>
                            <div ng-init="titolo='<?php echo $titolo; ?>'"></div>
                            <div ng-init="autore='<?php echo $autore; ?>'"></div>
                            <div ng-init="prezzo=<?php echo $prezzo; ?>"></div>
                            <div ng-init="genere=<?php echo $genere; ?>"></div>
                            <?php } ?>
                            <div class="row frmRow1">
                                <div class="col-xs-12 col-md-6">
                                    <fieldset class="form-group">
                                        <label for="genereSelect">Genere</label>
                                        <select id="genereSelect" class='form-control' ng-model="genere" required>
                                            <?php foreach($all_genres as $genre ){ ?>                                               
                                                <option ng-selected="isSelected(<?php echo $genre["gen_id"]; ?>)" value="<?php echo $genre["gen_id"];?>"><?php echo $genre["gen_nome"]; ?></option>
                                            <?php }?>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <fieldset class='form-group'>
                                        <label for='titolo'>Titolo</label>
                                        <input id="titolo" type='text' class='form-control' ng-model="titolo" required />
                                    </fieldset>
                                </div>
                            </div>
                            <!--- fine row -->
                            <div class="row frmRow2">
                                <div class="col-xs-12 col-md-6">
                                    <fieldset class="form-group">
                                        <label for="autore">Autore</label>
                                        <input type="text" class="form-control" id="autore" ng-model="autore" required />
                                    </fieldset>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                    <fieldset class="form-group">
                                        <label for="prezzo">Prezzo (€)</label>
                                        <input id="prezzo" type="number" min="0" step="1" class="form-control" ng-model="prezzo" required/>
                                    </fieldset>
                                </div>
                            </div>
                            <!-- fine row -->
                            <div class="row frmRow3">
                                <div class="col-xs-12">
                                    <label for="descrizione">Descrizione</label>
                                    <textarea style="height:200px;"id="descrizione" class="form-control" required ><?php echo $descrizione; ?></textarea>
                                </div>
                            </div>
                            <div class="row frmRowBtn">
                                <div class="col-xs-2">
                                    <button ng-click="formSubmit(<?php echo $id; ?>)" ng-disabled="frmDati.$invalid" id="btnSubmit" type="button" class="btn btn-default"><?php echo $_GET["az"]; ?></button>
                                </div>
                            </div>
                            <div class="row alertRow success">
                                <div id="alert-success" class="alert alert-success" hidden>Inserimento avvenuto con successo!</div>
                            </div>
                            <div class="row alertRow error">
                                <div id="alert-error" class="alert alert-danger" hidden>Errore in fase di inserimento</div>
                            </div>
                        </form>
                        <!-- fine form -->
                    </div>
                    <!-- fine row -->
                </div>
            </div>
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="js/jquery-1.11.3.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="js/bootstrap.min.js"></script>
            <!-- angular js -->
            <script src="js/angular.min.js"></script>
            <!-- angular js app -->
            <script src="js/app/app.js"></script>
            <!-- angular js controller -->
            <script src="js/controller/form-controller.js"></script>
        </body>
    </html>
<?php } ?>

