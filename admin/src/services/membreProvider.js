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
app.service('membreProvider', ['config', '$http', '$location',
    function (config, $http, $location, $rootScope) {
        return {
            lister: function () {
                var url = config.apiUrl + 'api/membre/';
                return $http.get(url);
            },
            afficher: function (item) {
                var url = config.apiUrl + 'api/membre/afficher/' + item['id'];
                return $http.get(url);
            },
            supprimer: function (item) {
                var url = config.apiUrl + 'api/membre/supprimer/' + item['id'];
                return $http.delete(url);
            },
            testSupprimer: function () {
                var url = config.apiUrl + 'api/membre/supprimer/' + null;
                return $http.delete(url);
            },
            ajouter: function (item) {
                return $http.post(config.apiUrl + 'api/membre/ajouter', item);
            },
            modifierurl: function (item) {
                $location.url('/membre/modifier');
                return item;
            },
            modifier: function (item) {
                var url = config.apiUrl + 'api/membre/modifier/';
                return $http.put(url, item);
            },
            chnagerEtat: function (item) {
                var url = config.apiUrl + 'api/membre/activerdesactiver/' + item['id'];
                return $http.get(url);
            },
            testerRoleAjout: function () {
                return $http.post(config.apiUrl + 'api/membre/ajouter');
            },
            testerRoleModif: function () {
                return $http.put(config.apiUrl + 'api/membre/modifier/');
            },
            testerRoleaffich: function () {
                return $http.get(config.apiUrl + 'api/membre/afficher/' + null);
            },
            testerRolechangeetat: function () {
                return $http.get(config.apiUrl + 'api/membre/activerdesactiver/' + null);
            }
        };
    }
]);