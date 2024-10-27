@extends('layouts.app4')

@section('title', 'Agroalimentaire tracabilite')

@section('content')

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<style>
       .block-gfx img {
    transition: transform 0.5s ease;
}

.block-gfx img:hover {
    transform: scale(1.1); /* Augmente la taille de 10% au survol */
}

</style>
<section style="padding-bottom: 100px; padding-top:80px;" class="section section-sm section-0">
    <div class="container">
        <div class="section-head">
            <div class="row justify-content-center text-center">
                <div class="col-lg-9 col-xl-8 col-xxl-6">
                    <h1 class="overline-title text-primary">Nos Solutions Innovantes</h1>
                </div>
            </div>
        </div>
        <div class="section-content">
            <div class="row gy-5 justify-content-center">
              <div class="col-xxl-12">
                <div class="p-5 p-lg-6 rounded-4 shadow-sm">
                  <div
                    class="row g-gs flex-lg-row-reverse justify-content-between align-items-center"
                  >
                    <div class="col-lg-6 col-xl-5">
                      <div class="pe-4">
                        <div
                          class="rounded-4 bg-primary bg-opacity-50 p-5 pe-0"
                        >
                        
                          <div class="block-gfx me-n4">
                            <img
                              class="w-100 rounded-3 shadow-sm"
                              src="{{asset('images/gfx/process/a.webp')}}"
                              alt=""
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                      <div class="block-text pe-xl-5">
                     
                        <h3 class="title">Traçabilité des Produits avec la Blockchain</h3>
                       
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>
                                Suivez chaque étape du transport, de la conservation et de l'origine des produits.

                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Enregistrement immuable des données pour une confiance totale.

                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Offrez à vos clients une transparence complète sur l'origine des produits.

                            </span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-12">
                <div class="p-5 p-lg-6 rounded-4 shadow-sm">
                  <div
                    class="row g-gs justify-content-between align-items-center"
                  >
                    <div class="col-lg-6 col-xl-5">
                      <div class="ps-4">
                        <div
                          class="rounded-4 bg-warning bg-opacity-40 p-5 ps-0"
                        >
                          <div class="block-gfx ms-n4">
                            <img
                              class="w-100 rounded-3 shadow-sm"
                              src="{{asset('images/gfx/process/b.webp')}}"
                              alt=""
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                      <div class="block-text pe-xl-5">
                   
                        <h3 class="title">
                            Automatisation de la Gestion des Stocks

</h3>
                       
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Surveillance en temps réel des niveaux de stock.

                            </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Génération automatique de rapports sur les mouvements de stock à une fréquence définie.


                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Analyse des échanges commerciaux à l'aide de l'IA pour extraire des insights précieux et améliorer vos processus de vente.

                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Optimisation des approvisionnements grâce à des analyses précises.



                              </span
                            >
                          </li>
                        =
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-12">
                <div class="p-5 p-lg-6 rounded-4 shadow-sm">
                  <div
                    class="row g-gs flex-lg-row-reverse justify-content-between align-items-center"
                  >
                    <div class="col-lg-6 col-xl-5">
                      <div class="pe-4">
                        <div class="rounded-4 bg-info bg-opacity-50 p-5 pe-0">
                          <div class="block-gfx me-n4">
                            <img
                              class="w-100 rounded-3 shadow-sm"
                              src="{{asset('images/gfx/process/c.webp')}}"
                              alt=""
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                      <div class="block-text pe-xl-5">
                      
                        <h3 class="title">Réapprovisionnement Automatique</h3>
                       
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Systèmes intelligents pour passer des commandes lorsque les stocks sont bas.



                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Réduction des ruptures de stock et des surplus inutiles.


                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Intégration fluide avec vos fournisseurs pour un processus sans accroc.



                            </span>
                          </li>
                          
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-12">
                <div class="p-5 p-lg-6 rounded-4 shadow-sm">
                  <div
                    class="row g-gs justify-content-between align-items-center"
                  >
                    <div class="col-lg-6 col-xl-5">  
                      <div class="ps-4">
                        <div
                          class="rounded-4 bg-warning bg-opacity-40 p-5 ps-0"
                        >
                          <div class="block-gfx ms-n4">
                            <img
                              class="w-100 rounded-3 shadow-sm"
                              src="{{asset('images/gfx/process/b.webp')}}"
                              alt=""
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                      <div class="block-text pe-xl-5">
                   
                        <h3 class="title">
                           
Analyse Prédictive Basée sur la Saison et les Tendances du Marché</h3>
                       
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Prévoyez la demande en fonction des données de saisonnalité et des évolutions du marché.


                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Ajustez votre production et votre approvisionnement en conséquence.
                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Restez compétitif en anticipant les besoins du marché.
                              </span
                            >
                          </li>
                          
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xxl-12">
                <div class="p-5 p-lg-6 rounded-4 shadow-sm">
                  <div
                    class="row g-gs flex-lg-row-reverse justify-content-between align-items-center"
                  >
                    <div class="col-lg-6 col-xl-5">
                      <div class="pe-4">
                        <div
                          class="rounded-4 bg-primary bg-opacity-50 p-5 pe-0"
                        >
                        
                          <div class="block-gfx me-n4">
                            <img
                              class="w-100 rounded-3 shadow-sm"
                              src="{{asset('images/gfx/process/a.webp')}}"
                              alt=""
                            />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                      <div class="block-text pe-xl-5">
                     
                        <h3 class="title">Gestion Sécurisée des Contrats et des Transactions </h3>
                        <p style="text-align:justify  ">
                        Grâce à la blockchain, facilitez et sécurisez la gestion de vos contrats et transactions, en garantissant une transparence totale et une vérification rapide des données. Ce système assure une traçabilité parfaite des accords commerciaux et réduit les risques de fraude ou de litiges
                        </p>
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>
                           Automatisation des paiements et des transferts via des smart contracts sécurisés.

                            </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Réduction des intermédiaires pour des transactions plus rapides et économiques.

                                </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Validation et traçabilité des transactions en temps réel, réduisant ainsi les risques de fraude.

                            </span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
           
            </div>
          </div>
    </div>
</section>

<section class="section section-lg section-0">
    <div class="container">
      <div
        class="section-wrap section-wrap-angle section-wrap-angle-top-right bg-darker is-dark rounded-4 has-shape"
      >
        <div
          class="section-content p-4 pt-3 pt-sm-5 p-sm-6 overflow-hidden"
        >
          <div class="nk-shape bg-shape-blur-n mt-n10p ms-n10p"></div>
          <div
            class="nk-shape bg-shape-blur-o mt-n10p me-n20p end-0"
          ></div>
          <div class="row justify-content-center text-center">
            <div class="col-xl-8 col-xxl-9">
              <div class="block-text">
                <h6 class="overline-title text-primary">
                    Et Ce N'est Pas Tout !
                </h6>
                <h2 class="title"> Notre expertise s'étend bien au-delà de ces solutions.</h2>
                <p class="lead mt-3">
                    Ces exemples ne sont qu'un aperçu de ce que nous pouvons réaliser ensemble. Chez BrainGenTech, nous créons des solutions sur mesure, parfaitement adaptées à vos besoins et défis uniques.

                    Prêt à propulser votre agence de communication vers de nouveaux sommets ? 
                </p>
                <ul class="btn-list btn-list-inline">
                  <li>
                    <a href="{{url('/contact')}}" class="btn btn-lg btn-primary"
                      ><span>Demandez une Démo </span
                      ><em class="icon ni ni-arrow-long-right"></em
                    ></a>
                  </li>
                </ul>
                <ul class="list list-row gy-0 gx-3">
                  <li>
                      <em class="icon ni ni-check-circle-fill text-success"></em><span>Aucun engagement</span>
                  </li>
                  <li>
                      <em class="icon ni ni-check-circle-fill text-success"></em><span>Audit technique</span>
                  </li>
                  <li>
                      <em class="icon ni ni-check-circle-fill text-success"></em><span>Explorer les differentes automatisations sur mesure
                      </span>
                  </li>
              </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
