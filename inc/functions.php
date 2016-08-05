<?php
include("Database.php");
//FUNCTIONS.PHP -- funzioni richiamate da altre pagine

//select_all_books() : restituisce l'insieme dei libri presenti nel database associato
function select_all_books(){
    $dbo = new Database();
    
    $sql = "SELECT * FROM libro INNER JOIN genere ON lib_gen_id = gen_id ORDER BY lib_titolo";
    $dbo->query($sql);
    
    return $dbo->resultset();
}
//select_all_genres() : restituisce tutti i generi presenti nel database associato
function select_all_genres(){
    $dbo = new Database();
    
    $sql = "SELECT * FROM genere ORDER BY gen_id";
    $dbo->query($sql);
    
    return $dbo->resultset();
}

//select_books_filtered() : seleziona i libri in base ad una stringa di ricerca ed un genere.
function select_books_filtered($genere,$stringa){
    $dbo = new Database();
    
    
    if( $genere == 0 ){
        //il genere è 'tutti'
        $sql = "SELECT * FROM libro INNER JOIN genere ON lib_gen_id=gen_id WHERE lib_titolo LIKE '%$stringa%'";
        $dbo->query($sql);

        return $dbo->resultset();
    }else{
        //il genere è specifico
        $sql = "SELECT * FROM libro INNER JOIN genere ON lib_gen_id=gen_id WHERE lib_gen_id=:gen AND lib_titolo LIKE '%$stringa%'";
        $dbo->query($sql);
        $dbo->bind(":gen",$genere);
        

        return $dbo->resultset();
    }
}
//select_book_by_id(idparameter) : seleziona un libro a partire da un id fornito da parametri
function select_book_by_id($idparameter){
    $dbo = new Database();
    
    $sql = "SELECT * FROM libro INNER JOIN genere ON lib_gen_id=gen_id WHERE lib_id=:id";
    $dbo->query($sql);
    $dbo->bind(":id",$idparameter);
    
    return $dbo->single();
}
?>

