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
app.service('agenceProvider', ['config','$http','$location',
    function(config,$http,$location,$rootScope) {
        return {
            lister: function() {
                var url = config.apiUrl+'api/agence/';
                return $http.get(url);
            },
            lister_banque: function() {
                var url = config.apiUrl+'api/banque/';
                return $http.get(url);
            },
            afficher: function(item) {
                var url =  config.apiUrl+'api/agence/afficher/'+item['id'];
                return $http.get(url);
            },
            supprimer: function(item) {
                var url =  config.apiUrl+'api/agence/supprimer/'+item['id'];
                return $http.delete(url);
            },
            testSupprimer: function() {
                var url =  config.apiUrl+'api/agence/supprimer/'+null;
                return $http.delete(url);
            },
            ajouter: function(item) {
                return $http.post(config.apiUrl+'api/agence/ajouter',item);
            },
            modifierurl: function(item) {
                $location.url('/agence/modifier');
                return item;
            },
            modifier: function(item) {
                var url = config.apiUrl+'api/agence/modifier/';
                return $http.put(url,item);
            },
             afficherurl: function(item) {
                $location.url('/agence/afficher');
                return item;
            },
             testerRoleAjout: function() {
                return $http.post(config.apiUrl+'api/agence/ajouter');
            },
             testerRoleModif: function() {
                return $http.put(config.apiUrl+'api/agence/modifier/');
            },
            testerRoleAffich: function() {
                return $http.get(config.apiUrl+'api/agence/afficher/'+null);
            }
        };
    }
]);