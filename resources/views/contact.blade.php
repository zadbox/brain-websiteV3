@extends('layouts.app2')

@section('title', 'A propos')

@section('content')



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<main class="nk-pages">
    <section class="section section-bottom-0 has-shape has-mask">
        <div class="nk-shape bg-shape-blur-m mt-8 start-50 top-0 translate-middle-x"></div>
        <div class="nk-mask bg-pattern-dot bg-blend-around mt-n5 mb-10p mh-50vh"></div>
        <div class="container">
            <div class="section-head">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-11 col-xl-10 col-xxl-9">
                        <h6 class="overline-title text-primary">Contactez-nous</h6>
                        <h1 class="title mb-3 mb-lg-4 display-6">
                            Des questions ou un projet à discuter ?
                            <div class="text-gradient-primary">
                                <span class="type-init" data-strings='"Nous sommes là!"'></span>
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="section-content">
                <div class="row g-gs justify-content-center justify-content-lg-between">
                    <div class="col-xl-5 col-lg-6 col-md-8 text-lg-start text-center">
                        <div class="block-text pt-lg-4">
                            <p style="text-align: justify">
                                Nous sommes à votre écoute pour vous accompagner dans la mise en place de solutions sur
                                mesure, adaptées à vos besoins. Ensemble, faisons avancer vos idées.
                            </p>
                            <ul class="row gy-4 pt-4">
                                <li class="col-12">
                                    <h5>Contact</h5>
                                    <div>
                                        <em class="icon ni ni-call-alt-fill"></em> +(33) 780959284<br>
                                        <em class="icon ni ni-call-alt-fill"></em> +(33) 755547091<br>
                                        <em class="icon ni ni-call-alt-fill"></em> +(212) 677740552
                                    </div>
                                </li>
                                <li class="col-12">
                                    <h5>Email</h5>
                                    <div>
                                        <em class="icon ni ni-mail-fill"></em> contact@braingentech.com
                                    </div>
                                </li>
                                <li class="col-12">
                                    <h5>Localisation</h5>
                                    <div>
                                        <em class="icon ni ni-map-pin-fill"></em> 107 Rue Paul Vaillant Couturier,
                                        Alfortville 94140 France
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center mt-3 mb-4" role="alert" style="max-width: 600px; margin: 0 auto;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body">
                                <h3 class="title fw-medium mb-4">
                                    Remplissez ce formulaire et nous vous répondrons rapidement !
                                </h3>
                                <form action="{{ url('/message') }}" method="post" class="form-submit-init">
                                    @csrf
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" name="user-name" class="form-control form-control-lg" placeholder="Votre Prénom" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="email" name="user-email" class="form-control form-control-lg" placeholder="Votre Adresse Email" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <select name="user-subject" class="form-control form-control-lg" required>
                                                    <option value="" hidden>Nos services</option>
                                                    <option value="communication-marketing">Communication et marketing digital</option>
                                                    <option value="immobilier-conciergerie">Promotion immobilière et conciergerie</option>
                                                    <option value="agroalimentaire-tracabilite">Agroalimentaire et traçabilité</option>
                                                    <option value="autre">Autre</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea name="user-message" class="form-control form-control-lg" placeholder="Votre message ..." rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-lg" type="submit">
                                                    Envoyer
                                                </button>
                                            </div>
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
</main>

@endsection
