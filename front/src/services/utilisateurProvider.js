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
app.service('utilisateurProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {

            ajouter: function(item) {
                return $http.post(config.apiUrlAdmin+'utilisateur/ajouter',item);
            }
        };
    }
]);