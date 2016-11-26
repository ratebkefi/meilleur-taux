'use strict';
app
        .controller('devise_list', ['config', '$scope', '$filter', '$rootScope', 'deviseProvider', 'ngTableParams', '$state', '$http',
            function (config, $scope, $filter, $rootScope, deviseProvider, ngTableParams, $state, $http) {
                deviseProvider.testerRoleLister().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            }
                        }
                );

                $scope.nameapp = config.appName;
                var vm = this;
                vm.users = []; //declare an empty array
                vm.pageno = 1; // initialize page no to 1
                vm.total_count = 0;
                vm.itemsPerPage = 10; //this could be a dynamic value from a drop down
                vm.getData = function (pageno) { // This would fetch the data on page change.
                    //In practice this should be in a factory.
                    vm.users = [];
                    $http.get(config.apiUrl + "api/devises/" + vm.itemsPerPage + "/" + pageno).success(function (response) {
                        vm.users = response;  //ajax request to fetch data into vm.data
                        //alert(config.apiUrl+"devises/"+vm.itemsPerPage+"/"+pageno)
                        deviseProvider.total().success(
                                function (data, status) {
                                    vm.total_count = data;
                                }
                        );
                    });
                };
                vm.getData(vm.pageno);
                $scope.supprimer_devise = function (item) {
                    deviseProvider.supprimer(item).success(
                            function (data, status) {
                                //$scope.devises.splice($scope.devises.indexOf(item), 1);
                                $scope.devisesTable = new ngTableParams({
                                    page: 1,
                                    count: 100
                                }, {
                                    counts: [],
                                    total: $scope.devises.length,
                                    getData: function ($defer, params) {
                                        $scope.data = params.sorting() ? $filter('orderBy')($scope.devises, params.orderBy()) : $scope.devises;
                                        $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                        $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                        $defer.resolve($scope.data);
                                    }
                                });
                            }
                    );
                };
                $scope.modifier = function (item) {
                    $state.go('dashboard.devisemodifier');
                    $rootScope.item = item;
                };
                $scope.afficher = function (item) {
                    $state.go('dashboard.deviseafficher');
                    $rootScope.item = item;
                };
            }
        ])
        .controller('devise_ajouter', ['$scope', 'Flash', '$rootScope', 'deviseProvider', '$location', '$state',
            function ($scope, Flash, $rootScope, deviseProvider, $location, $state) {
                deviseProvider.testerRoleAjout().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            }
                        }
                );
                $scope.ajouter_devise = function (item) {
                    deviseProvider.ajouter(item).success(
                            function (data, status) {
                                $state.go('dashboard.devise');
                            }
                    );
                };
            }
        ])
        .controller('devise_modifier', ['$scope', '$rootScope', 'deviseProvider', '$location', '$state',
            function ($scope, $rootScope, deviseProvider, $location, $state) {
                deviseProvider.testerRoleModif().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            }
                        }
                );
                $scope.modifier_devise = function (item) {
                    deviseProvider.modifier(item).success(
                            function (data, status) {
                                $state.go('dashboard.devise');
                                //$location.url('/devise/');
                            }
                    );
                };
            }
        ])
        .controller('devise_afficher', ['$scope', '$rootScope', 'deviseProvider', '$location', '$state',
            function ($scope, $rootScope, deviseProvider, $location, $state) {
                deviseProvider.testerRoleAffich().success(
                        function (data, status) {
                            if (data == 403) {
                                $state.go('erreur403');
                            }
                            if (data == 401) {
                                $state.go('erreur401');
                            }
                        }
                );
                $scope.devise_afficher = function (item) {
                };
            }
        ]);