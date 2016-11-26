'use strict';
app
    .controller('simulateur', ['config', '$scope', '$filter', '$rootScope', 'simulateurProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, simulateurProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            //Récupérer le résultat
            //simulateurProvider.resultat(montant,operation,devise_id).success(
            //    function (data, status) {
                    //        $scope.resultat = data;
                    //        console.log($scope.resultat);
                    //    }
            //);
            //simulateurProvider.page().success(
            //    function (data, status) {
            //    }
            //);
        }
    ]);