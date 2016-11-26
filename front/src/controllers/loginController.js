'use strict';
app
    .controller('user_login', ['$scope', '$rootScope', 'loginProvider', '$location', 'config', '$state',
        function ($scope, $rootScope, loginProvider, $location, config, $state) {
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
                             $state.go('index');
                        }
                    }
                );
            };
        }
    ])