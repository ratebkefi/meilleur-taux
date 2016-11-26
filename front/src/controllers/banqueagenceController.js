'use strict';
app
    .controller('banqueagence', ['config', '$scope', '$filter', '$rootScope', 'banqueagenceProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, banqueagenceProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            //Récupérer la liste des banques
            banqueagenceProvider.lister_banque().success(
                function (data, status) {
                    $scope.banques = data;
                    console.log('Liste des banques:');
                    console.log($scope.banques);
                    $scope.banquesTable = new ngTableParams({
                        page: 1,
                        count: 100 // Nbr de ligne par page
                    }, {
                        counts: [], // hides page sizes
                        total: $scope.banques.length,
                        getData: function ($defer, params) {
                            $scope.data = params.sorting() ? $filter('orderBy')($scope.banques, params.orderBy()) : $scope.banques;
                            $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                            $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                            $defer.resolve($scope.data);
                        }
                    });
                }
            );
            //Récupérer la liste des agences
            banqueagenceProvider.lister_agence().success(
                function (data, status) {
                    $scope.agences = data;
                    console.log('Liste des agences:');
                    console.log($scope.agences);
                    $scope.agencesTable = new ngTableParams({
                        page: 1,
                        count: 100 // Nbr de ligne par page
                    }, {
                        counts: [], // hides page sizes
                        total: $scope.agences.length,
                        getData: function ($defer, params) {
                            $scope.data = params.sorting() ? $filter('orderBy')($scope.agences, params.orderBy()) : $scope.agences;
                            $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                            $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                            $defer.resolve($scope.data);
                        }
                    });
                }
            );
        }
    ]);