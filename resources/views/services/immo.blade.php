@extends('layouts.app4')

@section('title', 'Promotion immobiliere conciergerie')

@section('content')

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<style>
  body{
    font-family: "Lexend Tera", sans-serif !important;

  }
  h1 {
    font-family: "Lexend Tera", sans-serif !important;
    font-optical-sizing: auto;
    font-weight: 400 !important;
}
</style>
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
                     
                        <h3 class="title">Qualification Multidimensionnelle des Clients</h3>
                        <p style="text-align:justify  ">
                        Optimisez votre processus de vente en vous basant sur une compréhension fine des besoins de vos clients :
                        </p>
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>
                            Analyse intelligente des besoins spécifiques, de la capacité de financement et des préférences des acheteurs.

                            </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Segmentation automatisée pour adapter vos offres à chaque profil client et proposer les biens les plus pertinents.

                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Priorisation des leads pour cibler vos efforts commerciaux sur les prospects les plus prometteurs, améliorant ainsi votre taux de conversion.

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
                          Automatisation de la Gestion des Rendez-vous </h3>
                       
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Facilitez la planification des visites et améliorez l'expérience client grâce à une gestion fluide des rendez-vous :

                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Planification et confirmation automatiques des visites de biens, sans intervention manuelle.
                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Rappels personnalisés envoyés aux clients et agents pour garantir la ponctualité et l’engagement.
                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              > Synchronisation en temps réel avec vos calendriers pour éviter les conflits d'agenda, maximisant ainsi l'efficacité de votre équipe.
                          
                              </span
                            >
                          </li>
                         <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Automatisation de la prise de notes pendant les appels, pour une documentation précise et rapide.


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
                      
                        <h3 class="title">
                          Service Après-Vente Optimisé</h3>
                       
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Collecte automatisée des tickets d'incidents via un chatbot interactif.

                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Dispatching intelligent des tickets vers les techniciens ou équipes de maintenance appropriés.
                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Suivi en temps réel des interventions pour une satisfaction client accrue.
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
                          Transfert Automatisé des Garanties</h3>
                       
                        <ul class="list gy-3">
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span>Gestion simplifiée du transfert des garanties à la fin de la vente.



                            </span>
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Documentation numérique sécurisée accessible à toutes les parties prenantes.





                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Améliorez la satisfaction client tout en réduisant la charge de travail de vos équipes.



                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Réduction des erreurs et du temps de traitement.



                              </span
                            >
                          </li>
                          <li>
                            <em
                              class="icon text-info fs-5 ni ni-check-circle-fill"
                            ></em
                            ><span
                              >Offrez une expérience client améliorée en réduisant les temps d'attente et en dirigeant les appels vers les bonnes équipes.


                              </span
                            >
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
