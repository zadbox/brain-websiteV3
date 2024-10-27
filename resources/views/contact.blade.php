@extends('layouts.app2')

@section('title', 'A propos')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main class="nk-pages">
    <section class="section section-bottom-0 has-shape has-mask">
    <div
        class="nk-shape bg-shape-blur-m mt-8 start-50 top-0 translate-middle-x"
    ></div>
    <div
        class="nk-mask bg-pattern-dot bg-blend-around mt-n5 mb-10p mh-50vh"
    ></div>
    <div class="container">
        <div class="section-head">
        <div class="row justify-content-center text-center">
            <div class="col-lg-11 col-xl-10 col-xxl-9">
            <h6 class="overline-title text-primary">Contactez-nous </h6>
            <h1 class="title mb-3 mb-lg-4 display-6">
            Des questions ou un projet à discuter ? 
                            <div class="text-gradient-primary">
                                <span class="type-init" data-strings='"Nous sommes là!"'></span>
                            </div>
            <h1 class="title">
            

            </h1>
            </div>
        </div>
        </div>
        <div class="section-content">
        <div
            class="row g-gs justify-content-center justify-content-lg-between"
        >
            <div
            class="col-xl-5 col-lg-6 col-md-8 text-lg-start text-center"
            >
            <div class="block-text pt-lg-4">
                
                <p style="text-align: justify">
                Nous sommes à votre écoute pour vous accompagner dans la mise en place de solutions sur mesure, adaptées à vos besoins. Ensemble, faisons avancer vos idées.
                </p>
                <ul class="row gy-4 pt-4">
                <li class="col-12">
                    <h5>Contact</h5>
                    <div
                    class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-start"
                    >
                    <em
                        class="icon text-base fs-5 mb-2 mb-lg-0 me-lg-2 ni ni-call-alt-fill"
                    ></em
                    ><span>+(33) 780959284</span>
                    </div>
                   
                    <div
                    class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-start"
                    >
                    <em
                        class="icon text-base fs-5 mb-2 mb-lg-0 me-lg-2 ni ni-call-alt-fill"
                    ></em
                    ><span>+(33) 755547091</span>
                    </div>
                    <div
                    class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-start"
                    >
                    <em
                        class="icon text-base fs-5 mb-2 mb-lg-0 me-lg-2 ni ni-call-alt-fill"
                    ></em
                    ><span>+(212) 677740552</span>
                    
                    </div>
                    
                </li>
                <li class="col-12">
                    <h5>Email</h5>
                    <div
                    class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-start"
                    >
                    <em
                        class="icon text-base fs-5 mb-2 mb-lg-0 me-lg-2 ni ni-mail-fill"
                    ></em
                    ><span>contact@braingentech.com</span>
                    </div>
                </li>
                <li class="col-12">
                    <h5>Localisation</h5>
                    <div
                    class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-start"
                    >
                    <em
                        class="icon text-base fs-5 mb-2 mb-lg-0 me-lg-2 ni ni-map-pin-fill"
                    ></em
                    ><span
                        >107 Rue Paul Vaillant Couturier , Alfortville 94140 France</span
                    >
                    </div>
                </li>
                </ul>
            </div>
            </div>
            <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                <h3 class="title fw-medium mb-4">
                Remplissez ce formulaire et nous vous répondrons rapidement !

                </h3>
                <form
                    data-action="form/message-form.php"
                    method="post"
                    class="form-submit-init"
                >
                    <div class="row g-4">
                    <div class="col-12">
                        <div class="form-group">
                        <div class="form-control-wrap">
                            <input
                            type="text"
                            name="user-name"
                            class="form-control form-control-lg"
                            placeholder="Votre Prénom"
                            required=""
                            />
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                        <div class="form-control-wrap">
                            <input
                            type="email"
                            name="user-email"
                            class="form-control form-control-lg"
                            placeholder="Votre Adresse"
                            required=""
                            />
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                        <div class="form-group">
                         
    <div class="form-control-wrap">
        <select name="user-subject" class="form-control form-control-lg" required>
            <option value="" hidden> Nos services</option>
            <option class="aa"  value="communication-marketing">Communication et marketing digital</option>
            <option class="aa"  value="immobilier-conciergerie">Promotion immobilière et conciergerie</option>
            <option class="aa"  value="agroalimentaire-tracabilite">Agroalimentaire et traçabilité</option>
            <option class="aa"  value="agroalimentaire-tracabilite">Autre</option>
        </select>
        <i class="fas fa-chevron-down" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); pointer-events: none;"></i>

    </div>
</div>

                        </div>
                        
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                        <div class="form-control-wrap">
                            <textarea
                            name="user-message"
                            class="form-control form-control-lg"
                            placeholder="Votre message ..."
                            required=""
                            ></textarea>
                        </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                        <button
                            class="btn btn-primary"
                            type="submit"
                            id="submit-btn"
                        >
                            Envoyer
                        </button>
                        </div>
                        <div class="form-result mt-4"></div>
                    </div>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    <section style="padding-bottom: 50px; padding-top:50px" >
        <div class="container" style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center;">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2627.5654994109623!2d2.414947976016333!3d48.809270804162544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e673049e8a9b3f%3A0xf6ba4803e56483fa!2s107%20Rue%20Paul%20Vaillant%20Couturier%2C%2094140%20Alfortville%2C%20France!5e0!3m2!1sfr!2sma!4v1728779706734!5m2!1sfr!2sma" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
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
