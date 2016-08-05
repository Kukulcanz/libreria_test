<?php
include("Database.php");

//script di inserimento e update
$dbo = new Database();

$id = $_POST["id"];
$genere = $_POST["genere"];
$titolo = $_POST["titolo"];
$autore = $_POST["autore"];
$prezzo = $_POST["prezzo"];
$descrizione = $_POST["descrizione"];

if( $id == 0 ){
    //è un inserimento
    $sql = "INSERT INTO libro(lib_gen_id,lib_titolo,lib_autore,lib_descrizione,lib_prezzo) VALUES(:genere,:titolo,:autore,:descrizione,:prezzo)";
    $dbo->query($sql);
    $dbo->bind(":genere",$genere);
    $dbo->bind(":titolo",$titolo);
    $dbo->bind(":autore",$autore);
    $dbo->bind(":descrizione",$descrizione);
    $dbo->bind(":prezzo",$prezzo);
    
    $dbo->execute();
    
    echo json_encode("inserimento");
}else{
    //è un update
    
    $sql = "UPDATE libro SET lib_gen_id=:genere,lib_titolo=:titolo,lib_autore=:autore,lib_descrizione=:descrizione,lib_prezzo=:prezzo WHERE lib_id=:id";
    $dbo->query($sql);
    $dbo->bind(":genere",$genere);
    $dbo->bind(":titolo",$titolo);
    $dbo->bind(":autore",$autore);
    $dbo->bind(":descrizione",$descrizione);
    $dbo->bind(":prezzo",$prezzo);
    $dbo->bind(":id",$id);
    
    $dbo->execute();
    
    echo json_encode("modifica");
}
?>

