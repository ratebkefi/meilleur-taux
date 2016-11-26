'use strict';
app

    .controller('utilisateur_ajouter', ['$scope', '$rootScope', 'utilisateurProvider', '$location', '$state',
        function ($scope, $rootScope, utilisateurProvider, $location, $state) {
            $scope.ajouter_utilisateur = function (item) {
                    item.groupe = '56ab424fb179aac41d000029';
                utilisateurProvider.ajouter(item).success(
                    function (data, status) {
                        $state.go('index');
                    }
                );
            };
        }
    ])
  ;

