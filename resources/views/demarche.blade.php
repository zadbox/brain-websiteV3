@extends('layouts.app')

@section('title', 'A propos')

@section('content')
    <main class="nk-pages">
    

        <section style="padding-top: 100px" class="section section-bottom-0 section-top-0">
            <div class="container">
              <div class="section-head">
                <div class="row justify-content-center text-center">
                  <div class="col-lg-9 col-xl-7 col-xxl-6">
                    <h6 id="notre-approche" class="overline-title text-primary">Notre approche en trois phases </h6>
                    <h2 class="title">Commencez votre parcours avec BRAIN </h2>
                 
                  </div>
                </div>
              </div>
              <div class="section-content">
                <div class="row g-gs justify-content-center">
                  <div class="col-lg-4 col-md-6">
                    <div  class="pricing pricing-featured bg-primary">
                      <div class="pricing-body p-5">
                        <div class="text-center">
                          <h5 class="mb-3">Phase 1 : Audit, Analyse et Modélisation</h5>
                          <h3 class="h2 mb-4">
                              
                              <span class="caption-text text-muted"> </span>
                            </h3>
                            <a  href="{{url('/a-propos')}}" class="btn btn-primary btn-block"
                              >Planifier vôtre rendez-vous</a
                            >
                         
                        </div>
                        <ul class="list gy-3 pt-4 ps-2">
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span
                              ><strong></strong> Analyse des points de douleur de votre business</span
                            >
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span><strong></strong>Détection et cartographie des processus internes  </span>
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span><strong></strong> Évaluation des technologies actuelles</span>
                          </li>
                         
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Recommandations personnalisées</span>
                          </li>
                        
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Amélioration de vos opérations</span>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6">
                    <div class="pricing pricing-featured bg-primary">
                      <div class="pricing-body p-5">
                        <div class="text-center">
                          <h5 class="mb-3">Phase 2 : Conception Technique et développement</h5>
                        
                        </div>
                        <ul class="list gy-3 pt-4 ps-2">
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span
                              ><strong></strong>  Conception de l'architecture
                              technique</span
                            >
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span><strong></strong> Choix des composants (LLM, BDD, scraping, stockage, API)</span>
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Développement des solutions
                            d'automatisation</span>
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Paramétrage</span>
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Tests fonctionnels</span>
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Tests techniques</span>
                          </li>
                          
                         
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6">
                    <div  class="pricing pricing-featured bg-primary">
                      <div class="pricing-body p-5">
                        <div class="text-center">
                          <h5 class="mb-3">Phase 3 : Déploiement, Hébergement et Formation</h5>
                          <h3 class="h2 mb-4">
                            
                            <span class="caption-text text-muted"> </span>
                          </h3>
                          
                        </div>
                        <ul class="list gy-3 pt-4 ps-2">
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span
                              ><strong></strong> Déploiement de la solution</span
                            >
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span><strong></strong>  Suivi
                            post-déploiement</span>
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Optimisation</span>
                          </li>
                          <li>
                            <em class="icon ni ni-check text-success"></em>
                            <span>Formation des utilisateurs finaux</span>
                          </li>
                          
                        </ul>
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
    </main>
@endsection
