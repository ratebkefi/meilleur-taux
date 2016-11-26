'use strict';
app
    .controller('adsense_list', ['config', '$scope', '$filter', '$rootScope', 'adsenseProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, adsenseProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            adsenseProvider.lister().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    } else {
                        $scope.adsenses = data;
                        $scope.adsensesTable = new ngTableParams({
                            page: 1,
                            count: 100 // Nbr de ligne par page
                        }, {
                            counts: [], // hides page sizes
                            total: $scope.adsenses.length,
                            getData: function ($defer, params) {
                                $scope.data = params.sorting() ? $filter('orderBy')($scope.adsenses, params.orderBy()) : $scope.adsenses;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                }
            );
            $scope.changerEtat = function (item) {

                adsenseProvider.chnagerEtat(item).success(
                    function (data, status) {
                        if (data == 403) {
                            $state.go('erreur403');
                        }
                        if (data == 401) {
                            $state.go('erreur401');
                        } else {
                            $state.go('dashboard.adsense');
                        }
                    }
                );
            }
            $scope.modifier = function (item) {
                $state.go('dashboard.adsensemodifier');
                $rootScope.adsense = item;
            };
            $scope.afficher = function (item) {
                $state.go('dashboard.adsenseafficher');
                $rootScope.adsense = item;
            };
        }
    ])
    .controller('adsense_modifier', ['$scope', '$rootScope', 'adsenseProvider', '$location', 'config', '$state',
        function ($scope, $rootScope, adsenseProvider, $location, config, $state) {
            adsenseProvider.testerRoleModif().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.modifier_adsense = function (item) {
                console.log(item);
                adsenseProvider.modifier(item).success(
                    function (data, status) {
                        $state.go('dashboard.adsense');
                    }
                );
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
    .controller('adsense_afficher', ['$scope', '$rootScope', 'publiciteProvider', '$location', 'config',
        function ($scope, $rootScope, adsenseProvider, $location, config) {
            banqueProvider.testerRoleAffich().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
        }
    ]);