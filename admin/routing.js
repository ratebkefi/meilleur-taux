'use strict';
app.config(
    function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/connexion');
        $stateProvider
            .state('connexion', {
                url: '/connexion',
                templateUrl: 'views/seconnecter.html',
                controller: 'user_login'
            })
            .state('mot-de-passe-oublie', {
                url: '/mot-de-passe-oublie',
                templateUrl: 'views/mot-de-passe-oublie.html'
            })
            .state('erreur403', {
                url: '/erreur-403',
                templateUrl: 'views/403.html'
            })
            .state('erreur401', {
                url: '/erreur-401',
                templateUrl: 'views/401.html'
            })
            .state('dashboard', {
                url: '/dashboard',
                templateUrl: 'views/index.html',
                controller: 'user_login'
            })
            //routing publicite
            .state('dashboard.publicite', {
                url: '/publicite',
                templateUrl: 'views/pub/liste.html',
                controller: 'publicite_list'
            })
            .state('dashboard.pubajouter', {
                url: '/publicite/ajouter',
                templateUrl: 'views/pub/ajouter.html',
                controller: 'publicite_ajouter'
            })
            .state('dashboard.pubmodifier', {
                url: '/publicite/modifier',
                templateUrl: 'views/pub/modifier.html',
                controller: 'publicite_modifier'
            })
            .state('dashboard.pubafficher', {
                url: '/publicite/afficher',
                templateUrl: 'views/pub/afficher.html',
                controller: 'publicite_afficher'
            })
            //routing agence
            .state('dashboard.agence', {
                url: '/agence',
                templateUrl: 'views/agence/list.html',
                controller: 'agence_list'
            })
            .state('dashboard.agenceajouter', {
                url: '/agence/ajouter',
                templateUrl: 'views/agence/ajouter.html',
                controller: 'agence_ajouter'
            })
            .state('dashboard.agencemodifier', {
                url: '/agence/modifier',
                templateUrl: 'views/agence/modifier.html',
                controller: 'agence_modifier'
            })
            .state('dashboard.agenceafficher', {
                url: '/agence/afficher',
                templateUrl: 'views/agence/afficher.html',
                controller: 'agence_afficher'
            })
            ////////////////////DEVISE///////////////////////////////////
            .state('dashboard.devise', {
                url: '/devise',
                templateUrl: 'views/devise/liste.html',
                controller: 'devise_list'
            })
            .state('dashboard.devisemodifier', {
                url: '/devise/modifier',
                templateUrl: 'views/devise/modifier.html',
                controller: 'devise_modifier'
            })
            .state('dashboard.deviseajouter', {
                url: '/devise/ajouter',
                templateUrl: 'views/devise/ajouter.html',
                controller: 'devise_ajouter'
            })
            .state('dashboard.deviseafficher', {
                url: '/devise/afficher',
                templateUrl: 'views/devise/afficher.html',
                controller: 'devise_afficher'
            })
            ////////////////////CHANGE///////////////////////////////////
            .state('dashboard.change', {
                url: '/change',
                controller: 'change_list',
                templateUrl: 'views/change/liste.html'
            })
            .state('dashboard.changeajouter', {
                url: '/change/ajouter',
                controller: 'change_ajouter',
                templateUrl: 'views/change/ajouter.html'
            })

            ////////////////////Menu///////////////////////////////////
            .state('dashboard.menu', {
                url: '/menu',
                controller: 'menu_list',
                templateUrl: 'views/menu/liste.html'
            })
            .state('dashboard.menumodifier', {
                url: '/menu/modifier',
                controller: 'menu_modifier',
                templateUrl: 'views/menu/modifier.html'
            })
            .state('dashboard.menuajouter', {
                url: '/menu/ajouter',
                controller: 'menu_ajouter',
                templateUrl: 'views/menu/ajouter.html'
            })
            .state('dashboard.menuafficher', {
                url: '/menu/afficher',
                controller: 'menu_afficher',
                templateUrl: 'views/menu/afficher.html'
            })
            ////////////////////Page///////////////////////////////////
            .state('dashboard.page', {
                url: '/page',
                controller: 'page_list',
                templateUrl: 'views/page/liste.html'
            })
            .state('dashboard.pagemodifier', {
                url: '/page/modifier',
                controller: 'page_modifier',
                templateUrl: 'views/page/modifier.html'
            })
            .state('dashboard.pageajouter', {
                url: '/page/ajouter',
                controller: 'page_ajouter',
                templateUrl: 'views/page/ajouter.html'
            })
            .state('dashboard.pageafficher', {
                url: '/page/afficher',
                controller: 'page_afficher',
                templateUrl: 'views/page/afficher.html'
            })
            //routing membre
            .state('dashboard.membre', {
                url: '/membre',
                templateUrl: 'views/membre/list.html',
                controller: 'membre_list'
            })
            .state('dashboard.membreajouter', {
                url: '/membre/ajouter',
                templateUrl: 'views/membre/ajouter.html',
                controller: 'membre_ajouter'
            })
            .state('dashboard.membremodifier', {
                url: '/membre/modifier',
                controller: 'membre_modifier',
                templateUrl: 'views/membre/modifier.html'
            })
            //routing Banque
            .state('dashboard.banque', {
                url: '/banque',
                templateUrl: 'views/banque/liste.html',
                controller: 'banque_list'
            })
            .state('dashboard.banqueajouter', {
                url: '/banque/ajouter',
                templateUrl: 'views/banque/ajouter.html',
                controller: 'banque_ajouter'
            })
            .state('dashboard.banquemodifier', {
                url: '/banque/modifier',
                templateUrl: 'views/banque/modifier.html',
                controller: 'banque_modifier'
            })
            .state('dashboard.banqueafficher', {
                url: '/banque/afficher',
                controller: 'banque_afficher',
                templateUrl: 'views/banque/afficher.html'
            })
            //routing Adsense
            .state('dashboard.adsense', {
                url: '/adsense',
                templateUrl: 'views/adsense/liste.html',
                controller: 'adsense_list'
            })
            .state('dashboard.adsensemodifier', {
                url: '/adsense/modifier',
                templateUrl: 'views/adsense/modifier.html',
                controller: 'adsense_modifier'
            })
            .state('dashboard.adsenseafficher', {
                url: '/adsense/afficher',
                controller: 'adsense_afficher',
                templateUrl: 'views/adsense/afficher.html'
            })
            ////////////////////UTILISATEUR///////////////////////////////////
            .state('dashboard.utilisateur', {
                url: '/utilisateur',
                controller: 'utilisateur_list',
                templateUrl: 'views/utilisateur/liste.html'
            })
            .state('dashboard.utilisateurajouter', {
                url: '/utilisateur/ajouter',
                controller: 'utilisateur_ajouter',
                templateUrl: 'views/utilisateur/ajouter.html'
            })
            .state('dashboard.utilisateurmodifier', {
                url: '/utilisateur/modifier',
                controller: 'utilisateur_modifier',
                templateUrl: 'views/utilisateur/modifier.html'
            })
            .state('dashboard.utilisateurafficher', {
                url: '/utilisateur/afficher',
                controller: 'utilisateur_afficher',
                templateUrl: 'views/utilisateur/afficher.html'
            })
            ////////////////////GROUPE///////////////////////////////////
            .state('dashboard.groupe', {
                url: '/groupe',
                controller: 'groupe_list',
                templateUrl: 'views/groupe/liste.html'
            })
            .state('dashboard.groupeajouter', {
                url: '/groupe/ajouter',
                controller: 'groupe_ajouter',
                templateUrl: 'views/groupe/ajouter.html'
            })
            .state('dashboard.groupemodifier', {
                url: '/groupe/modifier',
                controller: 'groupe_modifier',
                templateUrl: 'views/groupe/modifier.html'
            })
            .state('dashboard.groupeafficher', {
                url: '/groupe/afficher',
                controller: 'groupe_afficher',
                templateUrl: 'views/groupe/afficher.html'
            })
    });
