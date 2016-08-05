angular.module("LibreriaApp")
        .controller("MainController", ["$scope", function ($scope) {
                
                
                //funzione isSelected ; ritorna true se il valore nella variabile ng-model associata alla select è identico all'argomento passato.
                $scope.isSelected = function (val) {
                    return val === $scope.selettoreCategoria;
                }

                //mostraRiga : funzione per visualizzare solo le righe corrispondenti a prodotti della categoria prescelta
                $scope.mostraRiga = function (val) {
                    if ($scope.selettoreCategoria == 0)
                        return true;
                    else if (val == $scope.selettoreCategoria) {
                        return true;
                    } else
                        return false;
                };
                

                
               
            }]);


