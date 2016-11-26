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
app.service('simulateurProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            page: function() {
                $location.url('/simulateur');
                return true;
            },
            resultat: function() {
                var url = config.apiUrl+'changesim/'+montant+'/'+operation+'/'+devise_id;
                return $http.get(url);
            },
        };
    }
]);