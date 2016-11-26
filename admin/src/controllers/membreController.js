'use strict';
app
    .controller('membre_list', ['config', '$scope', '$filter', '$rootScope', 'membreProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, membreProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            $scope.suppression = false;
            membreProvider.testSupprimer().success(
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
            $scope.getArray = [{
                a: 'Nom prénom',
                b: 'Email',
                c: 'Sexe',
                d: 'Date de naissance',
                e: 'Téléphone',
                f: 'Societé',
                g: 'Emploi',
                h: 'Etat',
                j: 'Résumé quotidien'
            }];
            membreProvider.lister().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                        $scope.suppression = false;
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                        $scope.suppression = false;
                    } else {
                        $scope.suppression = true;
                        $scope.inter = data;
                        for (var i = 0; i < $scope.inter.length; i++) {
                            if ($scope.inter[i].sexe == true)
                                $scope.inter[i].sexe = "Homme";
                            else
                                $scope.inter[i].sexe = "Femme";
                        }
//Generation du CSV
                        $scope.membres = data;
                        for (var i = 0; i < $scope.membres.length; i++) {
                            $scope.getArray.push({
                                a: $scope.membres[i].nom_prenom,
                                b: $scope.membres[i].email,
                                c: $scope.membres[i].sexe,
                                d: $scope.membres[i].date_naissance,
                                e: $scope.membres[i].tel,
                                f: $scope.membres[i].societe,
                                g: $scope.membres[i].emploi,
                                h: $scope.membres[i].etat,
                                j: $scope.membres[i].resumer_quotidien
                            });
                        }
                        $scope.membresTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.membres.length,
                            getData: function ($defer, params) {

                                $scope.data = params.sorting() ? $filter('orderBy')($scope.membres, params.orderBy()) : $scope.membres;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                }
            );
            $scope.changerEtat = function (item) {

                membreProvider.chnagerEtat(item).success(
                    function (data, status) {
                        if (data == 403) {
                            $state.go('erreur403');
                        }
                        if (data == 401) {
                            $state.go('erreur401');
                        } else {
                            $state.go('dashboard.membre');
                        }
                    }
                );
            }
            $scope.supprimer_membre = function (item) {
                membreProvider.supprimer(item).success(
                    function (data, status) {
                        $scope.membres.splice($scope.membres.indexOf(item), 1);
                        $scope.membresTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.membres.length,
                            getData: function ($defer, params) {

                                $scope.data = params.sorting() ? $filter('orderBy')($scope.membres, params.orderBy()) : $scope.membres;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };
            $scope.modifier = function (item) {
                $state.go('dashboard.membremodifier');
                $rootScope.item = item;
            };
        }
    ])
    .directive('stringToNumber', function () {
        return {
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                ngModel.$parsers.push(function (value) {
                    return '' + value;
                });
                ngModel.$formatters.push(function (value) {
                    return parseFloat(value, 10);
                });
            }
        };
    })
    .controller('membre_ajouter', ['$scope', 'Flash', '$rootScope', 'membreProvider', '$location', '$state',
        function ($scope, Flash, $rootScope, membreProvider, $location, $state) {
            membreProvider.testerRoleAjout().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                    console.log(data);
                }
            );
            $scope.ajouter_membre = function (item) {
                membreProvider.ajouter(item).success(
                    function (data, status) {
                        $state.go('dashboard.membre');
                    }
                );
            };
        }
    ])
    .controller('membre_modifier', ['$scope', '$rootScope', 'membreProvider', '$location', '$state',
        function ($scope, $rootScope, membreProvider, $location, $state) {
            membreProvider.testerRoleModif().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.modifier_membre = function (item) {
                membreProvider.modifier(item).success(
                    function (data, status) {
                        $state.go('dashboard.membre');
                    }
                );
            };
        }
    ]);