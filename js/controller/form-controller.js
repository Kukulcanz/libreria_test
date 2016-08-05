angular.module("LibreriaApp")
        .controller("FormController",["$scope",function($scope){
            $scope.isSelected = function(number){
                if( number == 0 ){
                    return false;
                }else{
                    if ( number == $scope.genere )
                        return true;
                    else
                        return false;
                }
            }
            $scope.formSubmit = function(idLibro){
              var args = {
                  id:idLibro,
                  genere:$scope.genere,
                  titolo:$scope.titolo,
                  autore:$scope.autore,
                  prezzo:parseFloat($scope.prezzo),
                  descrizione:$("#descrizione").val()
              }; 
              console.log(args);
              $.ajax("./inc/formSubmit.php",{
                 method:"POST",
                 data:args,
                 dataType:"json",
                 success:function(risposta){
                     if ( risposta == "inserimento" ){
                         $("#alert-success").text("Inserimento avvenuto con successo,attendere");
                         $("#alert-success").show(2000,function(){
                             setTimeout(function(){
                                 $("#alert-success").hide(1000,function(){
                                     setTimeout(function(){
                                         location.reload();
                                     },2000);
                                 });
                             },3000);
                         });
                         
                     }else if ( risposta == "modifica" ){
                         $("#alert-success").text("Modifica avvenuta con successo,attendere");
                         $("#alert-success").show(2000,function(){
                             setTimeout(function(){
                                 $("#alert-success").hide(1000,function(){
                                     setTimeout(function(){
                                         window.location = "index.php";
                                     },2000);
                                 });
                             },3000);
                         });
                     }
                 },
                 error:function(risposta){
                     console.log(risposta);
                 }
              });
            };
}]);


