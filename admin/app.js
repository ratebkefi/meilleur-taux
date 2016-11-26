'use strict';
var app = angular.module("angularForm",["ngRoute","ngSanitize", "ngCsv","ngTable","flash","ngAnimate","angularFileUpload","ui.materialize","ui.router","perfect_scrollbar","angular-loading-bar","ui.tinymce","angularUtils.directives.dirPagination","checklist-model"]);
app.constant('config', {
    appName: 'My App',
    appVersion: 2.0,
    mediaUrl: 'http://localhost/meilleur-taux.tn/admin/src/media/upload.php',
        apiUrl: 'http://localhost/meilleur-taux.tn/web/app_dev.php/',
        photoUrl:'http://localhost/meilleur-taux.tn/admin/src/media/'
        });