'use strict';
app
    .controller('user_login', ['$scope', 'Flash', '$rootScope', 'loginProvider', '$location', 'config', '$state',
        function ($scope, Flash, $rootScope, loginProvider, $location, config, $state) {
            $scope.login = function (item) {
                console.log(item);
                loginProvider.login(item).success(
                    function (data, status) {
                        console.log(data);
                        $scope.datauser = data;
                        if (data['status'] == false) {
                            $state.go('connexion');
                        }
                        else {
                            $state.go('dashboard');
                        }
                    }
                );
            };
            $scope.logout = function () {
                console.log();
                loginProvider.logout().success(
                    function (data, status) {
                        console.log(data);
                        if (data['status'] == true) {
                            $state.go('connexion');
                        }
                    }
                );
            };
        }
    ])