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
app.service('banqueagenceProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister_banque: function() {
                var url = config.apiUrl+'banquelist';
                return $http.get(url);
            },
            lister_agence: function() {
                var url = config.apiUrl+'agencelist';
                return $http.get(url);
            },
        };
    }
]);