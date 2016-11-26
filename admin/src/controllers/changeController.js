'use strict';
app

    .controller('change_list', ['config', '$scope', '$filter', '$rootScope', 'changeProvider', 'ngTableParams', '$state', '$http',
        function (config, $scope, $filter, $rootScope, changeProvider, ngTableParams, $state, $http) {

            changeProvider.testerRoleLister().success(
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
                    }
                }
            );

            $scope.nameapp = config.appName;
            changeProvider.lister_banque().success(
                function (data, status) {
                    $rootScope.itemBanque = data;
                    $rootScope.itemBanque.unshift("");
                    //console.log($rootScope.itemBanque);
                }
            );
            changeProvider.lister_devise().success(
                function (data, status) {
                    $rootScope.itemDevise = data;
                }
            );

            var vm = this;
            vm.users = []; //declare an empty array
            vm.pageno = 1; // initialize page no to 1
            vm.total_count = 0;
            vm.itemsPerPage = 30; //this could be a dynamic value from a drop down
            vm.filterBol = false;
            var item = item || {};
            vm.getData = function (pageno, item) { // This would fetch the data on page change
                //In practice this should be in a factory.
                vm.users = [];
                console.log(item);
                    $http.post(config.apiUrl + "api/change/filtrer/" + vm.itemsPerPage + "/" + vm.pageno, item).success(function (response) {
                        vm.users = response;  //ajax request to fetch data into vm.data
                        changeProvider.total(item).success(
                            function (data, status) {
                                vm.total_count = data;
                                console.log(vm.users);

                            }
                        );

                    });


            };

item = {type: "null"};
            vm.getData(vm.pageno, item);


            $scope.supprimer_change = function (item) {
                changeProvider.supprimer(item).success(
                    function (data, status) {

                        $scope.test.splice($scope.changes.indexOf(item), 1);

                        $scope.changesTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.changes.length,
                            getData: function ($defer, params) {

                                $scope.data = params.sorting() ? $filter('orderBy')($scope.changes, params.orderBy()) : $scope.changes;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };

        }
    ])

    .controller('change_ajouter', ['$scope', 'Flash', '$rootScope', 'changeProvider', '$location', '$state',
        function ($scope, Flash, $rootScope, changeProvider, $location, $state) {
            changeProvider.lister_banque().success(
                function (data, status) {
                    $scope.itemBanque = data;
                }
            );
            changeProvider.lister_devise().success(
                function (data, status) {
                    $scope.itemDevise = data;
                }
            );
            $scope.ajouter_change = function (item) {
                if (item.banque == null)
                    item.banque = item.banques.id;
                if (item.devise == null)
                    item.devise = item.devises.id;
                changeProvider.ajouter(item).success(
                    function (data, status) {
                        $state.go('dashboard.change');
                    }
                );
            };


        }
    ])
;


