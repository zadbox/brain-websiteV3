<style>
    .is-dark .logo-light {
        opacity: 1;
        visibility: visible;
        margin-top: -25px;
        width: 155px;
        height: auto;
    }

    .logo-dark {
        opacity: 1;
        visibility: visible;
        height: 65px;
        height: auto;
    }

    @media (min-width: 992px) {
        [data-menu-collapse="lg"] .nk-menu-list {
            width: auto;
            flex-direction: row;
            padding: 22px 1rem;
            overflow: visible;
        }

    }


    /* Lorsque le mode sombre est activé */
    body.dark-mode .logo-light {
        display: none;
    }

    body.dark-mode .logo-dark {
        display: block;
    }
</style>
<header class="nk-header has-mask">
    <div class="nk-mask bg-gradient-a"></div>
    <div class="nk-mask bg-pattern-dot bg-blend-top"></div>
    <div class="nk-header-main nk-menu-main will-shrink is-transparent ignore-mask">
        <div class="container">
            <div class="nk-header-wrap">
                <div class="nk-header-logo">
                    <a href="{{url('/')}}" class="logo-link">
                        <div class="logo-wrap">


                            <img class="logo-img logo-light" style="
                  top: -31px;
              "
                                src="{{asset('images/Brain_light.png')}}" srcset="{{asset('images/Brain_light.png 4x')}}" alt="" /><img
                                style="
    top: -31px;
" class="logo-img logo-dark" src="{{asset('images/Brain_dark.png')}}"
                                srcset="{{asset('images/Brain_dark.png 4x')}}" alt="" />
                        </div>
                    </a>
                </div>
                <div class="nk-header-toggle">
                    <button class="dark-mode-toggle">
                        <em class="off icon ni ni-sun-fill"></em><em
                            class="on icon ni ni-moon-fill"></em></button><button
                        class="btn btn-light btn-icon header-menu-toggle">
                        <em class="icon ni ni-menu"></em>
                    </button>
                </div>
                <nav class="nk-header-menu nk-menu">
                    <ul class="nk-menu-list mx-auto">
                        <li class="nk-menu-item has-dropdown">
                            <a href="{{url("/")}}" class="nk-menu-link"><span
                                    class="nk-menu-text">Accueil</span></a>

                        </li>
                        <li class="nk-menu-item">
                            <a href="{{url("/a-propos")}}" href="{{ url('/a-propos') }}" class="nk-menu-link"><span class="nk-menu-text">A propos </span></a>
                        </li>
                        <li class="nk-menu-item has-dropdown">
                            <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                    class="nk-menu-text">Services</span></a>
                            <div class="nk-menu-dropdown nk-menu-mega">
                                <div class="nk-menu-mega-wrap">
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a class="nk-menu-link"
                                                href="{{ url('/service/communication-et-marketing-digital') }}">
                                                Communication et marketing digital</a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a class="nk-menu-link"  href="{{ url('/service/promotion-immobiliere-conciergerie') }}">
                                              Promotion Immobilière et
                                                Conciergerie </a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a class="nk-menu-link" href="{{ url('/service/agroalimentaire-tracabilite') }}">Agroalimentaire et
                                                Traçabilité

                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nk-menu-item">
                            <a href="{{url('/notre-demarche')}}" class="nk-menu-link"><span class="nk-menu-text">Notre
                                    démarche</span></a>
                        </li>

                        <li class="nk-menu-item">
                            <a href="{{url('/contact')}}" class="nk-menu-link"><span class="nk-menu-text">Contact</span></a>
                        </li>
                    </ul>
                    <div class="mx-2 d-none d-lg-block">
                        <button class="dark-mode-toggle">
                            <em class="off icon ni ni-sun-fill"></em><em class="on icon ni ni-moon-fill"></em>
                        </button>
                    </div>
                    <ul class="nk-menu-buttons flex-lg-row-reverse">
                        <li><a href="{{url('/contact')}}" class="btn btn-primary">Demandez un devis</a></li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="nk-hero pt-xl-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-11 col-xl-9 col-xxl-8">
                    <div class="nk-hero-content py-5 py-lg-6">

                        <h1 class="title mb-3 mb-lg-4 display-6">
                            Découvez et explorer nos services en 
                            
                            <div class="text-gradient-primary">
                                <span class="type-init" data-strings='"Promotion Immobilière", "et Conciergerie"'></span>
                            </div>
                        </h1> <!--
                        <p class="lead px-md-8 px-lg-6 mb-4 mb-lg-5">
                            Nous facilitons l'accès aux solutions d'IA et d'automatisation intelligentes pour les
                            petites et moyennes entreprises.
                        </p>
                        <ul class="btn-list btn-list-inline">
                            <li>
                                <a href="#" class="btn btn-secondary btn-lg"><span>Regoindre Brain</span></a>
                            </li>
                        </ul> -->
                    </div>
                    <div class="nk-hero-gfx">
                        <img class="w-100 rounded-top-4" src="{{asset('images/marketing.webp')}}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>
