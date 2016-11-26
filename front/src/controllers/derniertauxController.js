'use strict';
app
    .controller('derniertaux', ['config', '$scope', '$filter','$rootScope','loginProvider',  'derniertauxProvider', 'ngTableParams', '$state',
        function (config, $scope, $filter, $rootScope,loginProvider , derniertauxProvider, ngTableParams, $state) {
            $scope.nameapp = config.appName;
            //Récupérer la liste des banques
            $scope.tauxchange = [];
            $scope.tauxchangeinter = [];
            $scope.stateUser=false;

            $scope.logout = function () {
                loginProvider.logout().success(
                    function (data, status) {

                        $scope.stateUser=false;
                        $state.go('index');
                    }
                );
            };

            derniertauxProvider.statususer().success(
                function (data, status) {
                    if (data['status'] == true)
                        $scope.stateUser=true;
                    else
                    $scope.stateUser=false;
                });
            console.log($scope.stateUser);
            derniertauxProvider.listerpub().success(
                function (data, status) {
                    $scope.banarrayId = [];
                    $scope.compt = 0;
                    for (var prop in data) {
                        //console.log("obj." + prop + " = " + data[prop]);
                        $scope.banarrayId.push(data[prop].id);
                        $scope.compt++;
                    }
                    var nbrandom1 = Math.floor(Math.random() * 2);
                    var idrandom1 = $scope.banarrayId[nbrandom1];
                    var nbrandom2 = Math.floor(Math.random() * 2);
                    var idrandom2 = $scope.banarrayId[nbrandom2];

                    $scope.photoUrl=config.photoUrl;
                    $scope.imagerandom1 = data[idrandom1];
                    $scope.imagerandom2 = data[idrandom2];

                });


            derniertauxProvider.listerbanque().success(
                function (data, status) {
                    $scope.banques = data;
                });

            var dateOut = new Date();
            $scope.dateOut= dateOut;

            derniertauxProvider.derniertaux().success(
                function (data, status) {
                    $scope.taux = data;

                    for (var i = 0; i < $scope.taux.length; i++) {
                        if(i>0)
                        {
                        if(($scope.taux[i].banque.raison_social)!==($scope.taux[i-1].banque.raison_social))
                        {
                            $scope.tauxchangeinter = {};
                            $scope.tauxchangeinter.raison_social=$scope.taux[i-1].banque.raison_social;

                            for (var j = 0; j < $scope.taux.length; j++)
                            {
                                if(($scope.taux[j].banque.raison_social)==($scope.taux[i-1].banque.raison_social))
                                {

                                    if($scope.taux[j].devise.code_iso=="EUR")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_eur=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_eur=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="USD")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_usd=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_usd=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="SAR")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_sar=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_sar=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="CAD")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_cad=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_cad=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="DKK")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_dkk=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_dkk=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="GBP")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_gbp=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_gbp=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="JPY")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_jpy=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_jpy=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="NOK")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_nok=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_nok=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="SEK")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_sek=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_sek=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="CHF")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_chf=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_chf=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="KWD")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_kwd=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_kwd=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="AED")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_aed=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_aed=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="LYD")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_lyd=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_lyd=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="BHD")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_bhd=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_bhd=$scope.taux[j].taux_achat;
                                    }
                                    else if($scope.taux[j].devise.code_iso=="QAR")
                                    {
                                        $scope.tauxchangeinter.id=$scope.taux[j].id;
                                        $scope.tauxchangeinter.taux_vente_qar=$scope.taux[j].taux_vente;
                                        $scope.tauxchangeinter.taux_achat_qar=$scope.taux[j].taux_achat;
                                    }
                                }
                            }

                            $scope.tauxchange.push($scope.tauxchangeinter);
                        }
                        }
                    }


                    $scope.taux = $scope.tauxchange;


                    $scope.tauxTable = new ngTableParams({
                        page: 1,
                        count: 15 // Nbr de ligne par page
                    }, {
                        counts: [], // hides page sizes
                        total: $scope.taux.length,
                        getData: function ($defer, params) {
                            $scope.data = params.sorting() ? $filter('orderBy')($scope.taux, params.orderBy()) : $scope.taux;
                            $scope.data = params.filter() ? $filter('filter')($scope.data, params.filter()) : $scope.data;
                            $scope.data = $scope.data.slice((params.page() - 1) * params.count(), params.page() * params.count());
                            $defer.resolve($scope.data);
                        }
                    });


                    $scope.tauxa = data;
                    $scope.tauxTablea = new ngTableParams({
                        page: 1,
                        count: 15 // Nbr de ligne par page
                    }, {
                        counts: [], // hides page sizes
                        total: $scope.tauxa.length,
                        getData: function ($defer, params) {
                            $scope.dataa = params.sorting() ? $filter('orderBy')($scope.tauxa, params.orderBy()) : $scope.tauxa;
                            $scope.dataa = params.filter() ? $filter('filter')($scope.dataa, params.filter()) : $scope.dataa;
                            $scope.dataa = $scope.dataa.slice((params.page() - 1) * params.count(), params.page() * params.count());
                            $defer.resolve($scope.dataa);
                        }
                    });
                }
            );

            $scope.afficher_vendu = function (item) {
                $state.go('index.change_affiche_vendu');
                $rootScope.item = item;
            };

            $scope.afficher_achete = function (item) {
                $state.go('index.change_affiche_achete');
                $rootScope.item = item;
            };

            $scope.login = function () {
                $state.go('connexion');

            };







        }
    ])

    .controller('change_affiche', ['$scope', '$rootScope', '$location', 'config',
        function ($scope, $rootScope, $location, config) {


        }
    ]);