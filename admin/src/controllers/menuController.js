'use strict';
app
    .controller('menu_list', ['config', '$scope', '$filter', '$rootScope', 'menuProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, menuProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            $scope.suppression = false;
            menuProvider.testSupprimer().success(
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
            menuProvider.lister().success(
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
                        $scope.menus = data;
                        $scope.menusTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.menus.length,
                            getData: function ($defer, params) {

                                $scope.data = params.sorting() ? $filter('orderBy')($scope.menus, params.orderBy()) : $scope.menus;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                }
            );
            $scope.supprimer_menu = function (item) {
                menuProvider.supprimer(item).success(
                    function (data, status) {
                        $scope.menus.splice($scope.menus.indexOf(item), 1);
                        $scope.menusTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.menus.length,
                            getData: function ($defer, params) {
                                $scope.data = params.sorting() ? $filter('orderBy')($scope.menus, params.orderBy()) : $scope.menus;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };
            $scope.modifier = function (item) {
                $state.go('dashboard.menumodifier');
                $rootScope.item = item;
            };
            $scope.afficher = function (item) {
                $state.go('dashboard.menuafficher');
                $rootScope.item = item;
            };
        }
    ])
    .controller('menu_ajouter', ['$scope', 'Flash', '$rootScope', 'menuProvider', '$location', '$state',
        function ($scope, Flash, $rootScope, menuProvider, $location, $state) {
            menuProvider.testerRoleAjout().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.types = [{
                type: 'Extra Header',
                value: 1
            }, {
                type: 'Menu principal',
                value: 2
            }, {
                type: 'Footer',
                value: 3
            }
            ];
            menuProvider.lister_page().success(
                function (data, status) {
                    $scope.itemPage = data;
                }
            );
            $scope.ajouter_menu = function (item) {
                menuProvider.ajouter(item).success(
                    function (data, status) {
                        var message = '<strong>menu Créée avec succès !</strong>';
                        Flash.create('success', message);
                        $state.go('dashboard.menu');
                    }
                );
            };
        }
    ])
    .controller('menu_modifier', ['$scope', '$rootScope', 'menuProvider', '$location', '$state',
        function ($scope, $rootScope, menuProvider, $location, $state) {
            menuProvider.testerRoleModif().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.data = {
                availableOptions: [
                    {type: '1', value: 'Extra Header'},
                    {type: '2', value: 'Menu principal'},
                    {type: '3', value: 'Footer'}
                ],
                selectedOption: {type: '1'} //This sets the default value of the select in the ui
            };
            menuProvider.lister_page().success(
                function (data, status) {
                    $scope.itemPage = data;
                }
            );
            $scope.modifier_menu = function (item) {
                menuProvider.modifier(item).success(
                    function (data, status) {
                        $state.go('dashboard.menu');
                    }
                );
            };
        }
    ])
    .controller('menu_afficher', ['$scope', '$rootScope', 'pageProvider', '$location', '$state',
        function ($scope, $rootScope, pageProvider, $location, $state) {
            menuProvider.testerRoleAffich().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.afficher_page = function (item) {
                menuProvider.afficher(item).success(
                );
            };
        }
    ]);