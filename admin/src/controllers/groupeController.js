'use strict';
app
    .controller('groupe_list', ['config', '$scope', '$filter', '$rootScope', 'groupeProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope, groupeProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            $scope.suppression = false;
            groupeProvider.testSupprimer().success(
                function (data, status) {
                    if (data == 403) {
                        $scope.suppression = false;
                    }
                    else if (data == 401) {
                        $scope.suppression = false;
                    }
                    else
                        $scope.suppression = true;
                }
            );
            console.log($scope.suppression);
            groupeProvider.lister().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    } else {
                        console.log(data);
                        $scope.item = data;
                    }
                }
            );
            $scope.supprimer_groupe = function (item) {
                groupeProvider.supprimer(item).success(
                    function (data, status) {
                        $scope.item.splice($scope.item.indexOf(item), 1);
                        $scope.groupesTable = new ngTableParams({
                            page: 1,
                            count: 5
                        }, {
                            total: $scope.item.length,
                            getData: function ($defer, params) {

                                $scope.data = params.sorting() ? $filter('orderBy')($scope.item, params.orderBy()) : $scope.item;
                                $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                                $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                                $defer.resolve($scope.data);
                            }
                        });
                    }
                );
            };
            $scope.modifier = function (item) {
                $state.go('dashboard.groupemodifier');
                $rootScope.item = item;

            };
            $scope.afficher = function (item) {
                $state.go('dashboard.groupeafficher');
                $rootScope.item = item;
            };
        }
    ])
    .controller('groupe_ajouter', ['$scope', 'Flash', '$rootScope', 'groupeProvider', '$location', '$state','$window',
        function ($scope, Flash, $rootScope, groupeProvider, $location, $state, $window) {
            groupeProvider.lister_role().success(
                function (data, status) {
                    $rootScope.itemRole = data;
                    console.log($scope.itemRole);
                }
            );
            groupeProvider.testerRoleAjout().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            $scope.selection = [];
            // toggle selection pour un role donne par nom
            $scope.toggleSelection = function toggleSelection(notreRole) {
                var idx = $scope.selection.indexOf(notreRole);
                console.log(idx);
                // est actuellement sélectionné
                if (idx > -1) {
                    $scope.selection.splice(idx, 1);
                    console.log(idx);
                }
                // est nouvellement sélectionné
                else {
                    if (notreRole === "modifier_utilisateur") {
                        $scope.selection.push("modifier_utilisateur");
                        $scope.selection.push("lister_groupes");
                    }
                    else {
                        $scope.selection.push(notreRole);
                    }
                    console.log(notreRole);
                    console.log($scope.selection);
                }
            };

            $scope.ajouter_groupe = function (item) {
                item.role = $scope.selection;
                console.log(item);
                groupeProvider.ajouter(item).success(
                    function (data, status) {
                        $state.go('dashboard.groupe');
                    }
                );
            };
        }
    ])
    .controller('groupe_modifier', ['$scope', '$rootScope', 'groupeProvider', '$location', '$state',
        function ($scope, $rootScope, groupeProvider, $location, $state) {
            groupeProvider.testerRoleModif().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
            groupeProvider.lister_role().success(
                function (data, status) {
                    $scope.itemRole = data;
                    console.log($rootScope.item['role']);
                }
            );
            $scope.selection = $rootScope.item['role'];
            // toggle selection pour un role donne par nom
            $scope.toggleSelection = function toggleSelection(notreRole) {
                var idx = $scope.selection.indexOf(notreRole);
                // est actuellement sélectionné
                if (idx > -1) {
                    $scope.selection.splice(idx, 1);
                    $rootScope.item['role'] = $scope.selection;
                }
                // est nouvellement sélectionné
                else {
                    $scope.selection.push(notreRole);
                    $rootScope.item['role'] = $scope.selection;
                }
            };
            /*parcour object
             for(var key in $scope.itemRole){
             for (var i = 0; i < $scope.itemRole[key].length; i++) {
             if(role==($scope.itemRole[key][i]))
             {
             console.log(role +"=="+ $scope.itemRole[key][i]);
             return true;
             }
             }
             }*/
            $scope.searchRole = function (role) {
                for (var i = 0; i < $rootScope.item['role'].length; i++) {
                    if (role == ($rootScope.item['role'][i])) {
                        return true;
                    }
                }
                return false;
            };
            $scope.modifier_groupe = function (item) {
                item.role = $scope.selection;
                groupeProvider.modifier(item).success(
                    function (data, status) {
                        $state.go('dashboard.groupe');
                    }
                );
            };
        }
    ])
    .controller('groupe_afficher', ['$scope', '$rootScope', 'groupeProvider', '$location',
        function ($scope, $rootScope, groupeProvider, $location) {
            groupeProvider.testerRoleAffich().success(
                function (data, status) {
                    if (data == 403) {
                        $state.go('erreur403');
                    }
                    if (data == 401) {
                        $state.go('erreur401');
                    }
                }
            );
        }
    ]);