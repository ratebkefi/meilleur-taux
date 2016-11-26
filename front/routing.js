'use strict';
app.config(
    function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/index');
        $stateProvider
            .state('index', {
                url: '/index',
                templateUrl: 'views/index.html',
                controller: 'derniertaux'
            })
            .state('index.banque_agence', {
                url: '/banque_agence',
                templateUrl: 'views/banque_agence.html',
                controller: 'banqueagence'
            })
            .state('index.change_affiche_vendu', {
                url: '/change_affiche_vendu',
                templateUrl: 'views/change_affiche_vendu.html',
                controller: 'change_affiche'
            })
            .state('index.change_affiche_achete', {
                url: '/change_affiche_achat',
                templateUrl: 'views/change_affiche_achete.html',
                controller: 'change_affiche'
            })
            .state('index.simulateur', {
                url: '/simulateur',
                templateUrl: 'views/simulateur.html',
                controller: 'simulateur'
            })
            .state('connexion', {
                url: '/connexion',
                templateUrl: 'views/seconnecter.html',
                controller: 'user_login'
            })
            .state('index.utilisateurajouter', {
                url: '/utilisateur/ajouter',
                controller: 'utilisateur_ajouter',
                templateUrl: 'views/ajouter.html'
            })

    }).run(['$rootScope', '$location', function ($rootScope, $location) {
    var path = function () {
        return $location.path();
    };
    $rootScope.$watch(path, function (newVal, oldVal) {
        $rootScope.activetab = newVal;
    });
}]);
