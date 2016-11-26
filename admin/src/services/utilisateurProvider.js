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
            lister: function() {
                var url = config.apiUrl+'utilisateur/';
                return $http.get(url);
            },
            lister_groupe: function() {
                var url = config.apiUrl+'api/groupe/';
                return $http.get(url);
            },
            afficher: function(item) {
                var url =  config.apiUrl+'utilisateur/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'utilisateur/supprimer/'+item['id'];
                return $http.delete(url);
            },
            testSupprimer: function() {
                var url =  config.apiUrl+'utilisateur/supprimer/'+null;
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'utilisateur/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/utilisateur/modifier');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'utilisateur/modifier/';
                return $http.put(url,item);
            },
             afficherurl: function(item) {
                $location.url('/utilisateur/afficher');
                return item;
            }
        };
    }
]);