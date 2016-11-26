'use strict';
app.service('loginProvider', ['config', '$http', '$location',
    function (config, $http, $location, $rootScope) {
        return {
            login: function (item) {
                console.log(item + " data1");
                var url = config.apiUrlAdmin + 'user/login/';
                return $http.post(url,item);
            },
            logout: function () {
                console.log();
                var url = config.apiUrlAdmin + 'user/logout/';
                return $http.get(url);
            }
        };
    }
]);