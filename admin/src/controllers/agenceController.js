'use strict';
app
        .controller('agence_list', ['config', '$scope', '$filter', '$rootScope', 'agenceProvider', 'ngTableParams', '$state',
            function (config, $scope, $filter, $rootScope, agenceProvider, ngTableParams, $state) {
                $scope.nameapp = config.appName;
                $scope.suppression = false;
                agenceProvider.testSupprimer().success(
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
                agenceProvider.lister().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            } else {
                                $scope.inter = data;
                                for (var i = 0; i < $scope.inter.length; i++) {
                                    $scope.inter[i].nombanque = $scope.inter[i].banque.raison_social;
                                }
                                $scope.agences = $scope.inter;
                                $scope.agencesTable = new ngTableParams({
                                    page: 1,
                                    count: 5
                                }, {
                                    total: $scope.agences.length,
                                    getData: function ($defer, params) {
                                        $scope.data = params.sorting() ? $filter('orderBy')($scope.agences, params.orderBy()) : $scope.agences;
                                        $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                        $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                        $defer.resolve($scope.data);
                                    }
                                });
                            }
                        }
                );
                $scope.supprimer_agence = function (item) {
                    agenceProvider.supprimer(item).success(
                            function (data, status) {
                                $scope.agences.splice($scope.agences.indexOf(item), 1);
                                $scope.agencesTable = new ngTableParams({
                                    page: 1,
                                    count: 5
                                }, {
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
                };
                $scope.modifier = function (item) {
                    $state.go('dashboard.agencemodifier');
                    $rootScope.item = item;
                };
                $scope.afficher = function (item) {
                    $state.go('dashboard.agenceafficher');
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
        .controller('agence_ajouter', ['$scope', 'Flash', '$rootScope', 'agenceProvider', '$location', '$state',
            function ($scope, Flash, $rootScope, agenceProvider, $location, $state) {
                agenceProvider.testerRoleAjout().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            }
                        }
                );
                agenceProvider.lister_banque().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            }
                            $rootScope.itemBanque = data;
                            console.log($scope.itemBanque);
                        }
                );
                $scope.ajouter_agence = function (item) {
                    if (item.banque == null)
                        item.banque = item.banques.id;
                    agenceProvider.ajouter(item).success(
                            function (data, status) {
                                $state.go('dashboard.agence');
                            }
                    );
                };
            }
        ])
        .controller('agence_modifier', ['$scope', '$rootScope', 'agenceProvider', '$location', '$state',
            function ($scope, $rootScope, agenceProvider, $location, $state) {
                agenceProvider.testerRoleModif().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            }
                        }
                );
                agenceProvider.lister_banque().success(
                        function (data, status) {
                            $scope.itemBanque = data;
                        }
                );
                $scope.modifier_agence = function (item) {
                    if (item.intermediaire != null)
                        item.banque = item.intermediaire;
                    else
                        item.banque = item.banques.id;
                    agenceProvider.modifier(item).success(
                            function (data, status) {
                                $state.go('dashboard.agence');
                            }
                    );
                };
            }
        ])
        .controller('agence_afficher', ['$scope', '$rootScope', 'agenceProvider', '$location',
            function ($scope, $rootScope, agenceProvider, $location) {
            }
        ]);