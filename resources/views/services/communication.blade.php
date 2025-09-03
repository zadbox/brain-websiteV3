@extends('layouts.app')

@section('title', 'Communication et marketing digital')

@section('content')

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        .block-gfx img {
            transition: transform 0.5s ease;
        }

        .block-gfx img:hover {
            transform: scale(1.1);
            /* Augmente la taille de 10% au survol */
        }
    </style>
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
                            <div class="row g-gs flex-lg-row-reverse justify-content-between align-items-center">
                                <div class="col-lg-6 col-xl-5">
                                    <div class="pe-4">
                                        <div class="rounded-4 bg-primary bg-opacity-50 p-5 pe-0">

                                            <div class="block-gfx me-n4">
                                                <img class="w-100 rounded-3 shadow-sm"
                                                    src="{{ asset('images/gfx/process/a.webp') }}" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xxl-5">
                                    <div class="block-text pe-xl-5">

                                        <h3 class="title">Génération Automatisée de Contenu Média</h3>
                                        <p style="text-align:justify  ">
                                        Aujourd'hui, les entreprises doivent générer et publier du contenu de manière régulière pour rester pertinentes.
                                         Brain Technology simplifie ce processus grâce à une génération automatisée de contenu média. En quelques clics,
                                          transformez votre site web et vos documents en posts, vidéos, et reels Instagram ultra-contextualisés.
                                           Notre solution vous permet de publier du contenu à une fréquence définie, sans effort manuel,
                                            tout en libérant vos équipes pour qu'elles se concentrent sur l'innovation et la stratégie à long terme.
                                        </p>
                                        <ul class="list gy-3">
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>
                                                Transformez vos contenus en publications engageantes pour les réseaux sociaux.</span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Automatisez vos publications à une fréquence définie, sans effort.</span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Déléguez les tâches répétitives pour permettre à vos équipes de se concentrer sur l’innovation.</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12">
                        <div class="p-5 p-lg-6 rounded-4 shadow-sm">
                            <div class="row g-gs justify-content-between align-items-center">
                                <div class="col-lg-6 col-xl-5">
                                    <div class="ps-4">
                                        <div class="rounded-4 bg-warning bg-opacity-40 p-5 ps-0">
                                            <div class="block-gfx ms-n4">
                                                <img class="w-100 rounded-3 shadow-sm"
                                                    src="{{ asset('images/gfx/process/b.webp') }}" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xxl-5">
                                    <div class="block-text pe-xl-5">

                                        <h3 class="title">
                                            Automatisation de la Réception des Appels</h3>

                                        <ul class="list gy-3">
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Mettez en
                                                    place des systèmes intelligents pour gérer automatiquement les appels
                                                    entrants.</span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Qualification
                                                    des leads en temps réel en fonction des besoins spécifiques des clients.

                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Analyse
                                                    des échanges commerciaux à l'aide de l'IA pour extraire des insights
                                                    précieux et améliorer vos processus de vente.

                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Automatisation
                                                    de la prise de notes pendant les appels, pour une documentation précise
                                                    et rapide.


                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Offrez
                                                    une expérience client améliorée en réduisant les temps d'attente et en
                                                    dirigeant les appels vers les bonnes équipes.


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
                            <div class="row g-gs flex-lg-row-reverse justify-content-between align-items-center">
                                <div class="col-lg-6 col-xl-5">
                                    <div class="pe-4">
                                        <div class="rounded-4 bg-info bg-opacity-50 p-5 pe-0">
                                            <div class="block-gfx me-n4">
                                                <img class="w-100 rounded-3 shadow-sm"
                                                    src="{{ asset('images/gfx/process/c.webp') }}" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xxl-5">
                                    <div class="block-text pe-xl-5">

                                        <h3 class="title">Chatbots Multilingues et Multidialectes</h3>
                                        <p style="text-align: justify">
                                        Les clients d’aujourd’hui attendent une assistance immédiate et personnalisée, peu importe leur langue.
                                         Grâce à nos chatbots multilingues et multidialectes, vous pouvez offrir une assistance 24/7 en plusieurs
                                          langues, telles que le français, l'anglais, et même des dialectes spécifiques. Cela permet non seulement
                                           de répondre aux besoins d'une clientèle internationale, mais aussi d’améliorer leur satisfaction en
                                            garantissant une disponibilité constante.
                                        </p>
                                        <ul class="list gy-3">
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Exemples
                                                    de langues supportées : français 🇫🇷, anglais 🇬🇧, chinois 🇨🇳, et
                                                    bien d'autres.


                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Améliorez
                                                    la satisfaction client en offrant une assistance personnalisée et
                                                    accessible 24/7.

                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>
                                                    Offrez une assistance adaptée à chaque client selon sa langue et ses besoins.

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
                            <div class="row g-gs justify-content-between align-items-center">
                                <div class="col-lg-6 col-xl-5">
                                    <div class="ps-4">
                                        <div class="rounded-4 bg-warning bg-opacity-40 p-5 ps-0">
                                            <div class="block-gfx ms-n4">
                                                <img class="w-100 rounded-3 shadow-sm"
                                                    src="{{ asset('images/gfx/process/b.webp') }}" alt="" />
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
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Automatisez
                                                    la gestion des tickets et le suivi des demandes clients.

                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Utilisez
                                                    l'IA pour prioriser les demandes et affecter les ressources
                                                    efficacement.



                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Améliorez
                                                    la satisfaction client tout en réduisant la charge de travail de vos
                                                    équipes.



                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Automatisation
                                                    de la prise de notes pendant les appels, pour une documentation précise
                                                    et rapide.


                                                </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Offrez
                                                    une expérience client améliorée en réduisant les temps d'attente et en
                                                    dirigeant les appels vers les bonnes équipes.


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
                            <div class="row g-gs flex-lg-row-reverse justify-content-between align-items-center">
                                <div class="col-lg-6 col-xl-5">
                                    <div class="pe-4">
                                        <div class="rounded-4 bg-primary bg-opacity-50 p-5 pe-0">

                                            <div class="block-gfx me-n4">
                                                <img class="w-100 rounded-3 shadow-sm"
                                                    src="{{ asset('images/gfx/process/a.webp') }}" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xxl-5">
                                    <div class="block-text pe-xl-5">

                                        <h3 class="title">Automatisation des Campagnes Marketing</h3>
                                        <p style="text-align:justify  ">
                                        La personnalisation est la clé des campagnes marketing réussies. Notre solution d’automatisation
                                         des campagnes marketing vous permet de personnaliser vos messages à grande échelle,
                                          en utilisant l'IA pour segmenter automatiquement votre audience. Que ce soit par email,
                                           SMS ou notifications, vous pouvez maximiser l’engagement client tout en réduisant l'effort manuel.
                                        </p>
                                        <ul class="list gy-3">
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>
                                                L'IA adapte vos messages pour chaque segment de votre audience.

                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Ciblez
                                                     précisément votre audience pour des campagnes plus efficaces.
                                                    </span>
                                            </li>
                                            <li>
                                                <em class="icon text-info fs-5 ni ni-check-circle-fill"></em><span>Automatisez
                                                     l’envoi de vos communications pour maximiser l’interaction avec vos clients.

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
                class="section-wrap section-wrap-angle section-wrap-angle-top-right bg-darker is-dark rounded-4 has-shape">
                <div class="section-content p-4 pt-3 pt-sm-5 p-sm-6 overflow-hidden">
                    <div class="nk-shape bg-shape-blur-n mt-n10p ms-n10p"></div>
                    <div class="nk-shape bg-shape-blur-o mt-n10p me-n20p end-0"></div>
                    <div class="row justify-content-center text-center">
                        <div class="col-xl-8 col-xxl-9">
                            <div class="block-text">
                                <h6 class="overline-title text-primary">
                                    Et Ce N'est Pas Tout !
                                </h6>
                                <h2 class="title"> Notre expertise s'étend bien au-delà de ces solutions.</h2>
                                <p class="lead mt-3">
                                    Ces exemples ne sont qu'un aperçu de ce que nous pouvons réaliser ensemble. Chez
                                    BRAIN, nous créons des solutions sur mesure, parfaitement adaptées à vos besoins
                                    et défis uniques.

                                    Prêt à propulser votre agence de communication vers de nouveaux sommets ?
                                </p>
                                <ul class="btn-list btn-list-inline">
                                    <li>
                                        <a href="{{url('/contact')}}" class="btn btn-lg btn-primary"><span>Demandez une démo </span><em
                                                class="icon ni ni-arrow-long-right"></em></a>
                                    </li>
                                </ul>
                                <ul class="list list-row gy-0 gx-3">
                                    <li>
                                        <em class="icon ni ni-check-circle-fill text-success"></em><span>Aucune carte de crédit requise</span>
                                    </li>
                                    <li>
                                        <em class="icon ni ni-check-circle-fill text-success"></em><span>Audit technique</span>
                                    </li>
                                    <li>
                                        <em class="icon ni ni-check-circle-fill text-success"></em><span>Explorer les différentes automatisations sur mésure 
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
