'use strict';
app
    .controller('utilisateur_list', ['config', '$scope', '$filter', '$rootScope', 'utilisateurProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, utilisateurProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            $scope.suppression = false;
            utilisateurProvider.testSupprimer().success(
                function (data, status) {
                    if (data == 403) {
                        $scope.suppression = false;
                    }
                    else if (data == 401) {
                        $scope.suppression = false;
                    }
                    else
                        $scope.suppression = true;
                }
            );
            console.log($scope.suppression);
            utilisateurProvider.lister().success(
                function (data, status) {
                    console.log(data);
                    $scope.data = data;
                    $scope.inter = data;
                    for (var i = 0; i < $scope.inter.length; i++) {
                        $scope.inter[i].nomgroupe = $scope.inter[i].groupe.nom;
                    }
                    $scope.utilisateurs = $scope.inter;
                }
            );
            $scope.supprimer_utilisateur = function (item) {
                utilisateurProvider.supprimer(item).success(
                    function (data, status) {
                        $scope.data.splice($scope.data.indexOf(item), 1);
                        $scope.utilisateursTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.data.length,
                            getData: function ($defer, params) {
                                $scope.data = params.sorting() ? $filter('orderBy')($scope.data, params.orderBy()) : $scope.data;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };
            $scope.modifier = function (item) {
                $state.go('dashboard.utilisateurmodifier');
                $rootScope.item = item;
            };
            $scope.afficher = function (item) {
                $state.go('dashboard.utilisateurafficher');
                $rootScope.item = item;
            };
        }
    ])
    .controller('utilisateur_ajouter', ['$scope', 'Flash', '$rootScope', 'utilisateurProvider', '$location', '$state',
        function ($scope, Flash, $rootScope, utilisateurProvider, $location, $state) {
            utilisateurProvider.lister_groupe().success(
                function (data, status) {
                    $rootScope.itemGroupe = data;
                    console.log($scope.itemGroupe);
                }
            );
            $scope.ajouter_utilisateur = function (item) {
                if (item.groupe == null)
                    item.groupe = item.groupes.id;
                utilisateurProvider.ajouter(item).success(
                    function (data, status) {
                        $state.go('dashboard.utilisateur');
                    }
                );
            };
        }
    ])
    .controller('utilisateur_modifier', ['$scope', '$rootScope', 'utilisateurProvider', '$location', '$state',
        function ($scope, $rootScope, utilisateurProvider, $location, $state) {

            utilisateurProvider.lister_groupe().success(
                function (data, status) {
                    $scope.itemGroupe = data;
                }
            );
            $scope.modifier_utilisateur = function (item) {
                if (item.intermediaire != null)
                    item.groupe = item.intermediaire;
                else
                    item.groupe = item.groupes.id;
                utilisateurProvider.modifier(item).success(
                    function (data, status) {
                        $state.go('dashboard.utilisateur');
                    }
                );
            };
        }
    ])
    .controller('utilisateur_afficher', ['$scope', '$rootScope', 'utilisateurProvider', '$location',
        function ($scope, $rootScope, utilisateurProvider, $location) {
        }
    ]);

