'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselSettings
 * @description     settingsService
 */
app.service('derniertauxProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            derniertaux: function() {
                var url = config.apiUrl+'changelist';
                return $http.get(url);
            },
            listerpub: function() {
                var url = config.apiUrl+'publiciterandom';
                return $http.get(url);
            },
            listerbanque: function() {
                var url = config.apiUrl+'banquelist';
                return $http.get(url);
            },
            statususer: function () {

                var url = config.apiUrlAdmin + 'user/status/';
                return $http.get(url);
            }
        };
    }
]);