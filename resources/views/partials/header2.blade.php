<style>
    .logo-dark {
    margin-top: -11px;
    margin-left: -29px;

  }
    @media (min-width: 992px) {
        [data-menu-collapse="lg"] .nk-menu-list {
            width: auto;
            flex-direction: row;
            padding: 22px 1rem;
            overflow: visible;
        }

    }

    body {
    font-family: "Lexend Tera", sans-serif !important;
  font-optical-sizing: auto;
  font-weight: 400 !important;
   }

@media (min-width: 992px) {
    [data-menu-collapse="lg"] .nk-menu {
        width: 100%;
        transform: none;
        position: static;
        box-shadow: none;
        flex-direction: row;
        background-color: rgba(0, 0, 0, 0);
    }
    [data-menu-collapse="lg"] .nk-menu-list {
        width: auto;
        flex-direction: row;
        padding: 22px 1rem;
        overflow: visible;
    }
    [data-menu-collapse="lg"] .nk-menu-item {
        width: auto;
        position: relative;
        display: flex;
        align-items: center;
    }
    [data-menu-collapse="lg"] .nk-menu-item:hover .nk-menu-dropdown {
        opacity: 1;
        visibility: visible;
    }
    [data-menu-collapse="lg"] .nk-menu-link {
        padding: 1.25rem 1rem;
    }
    [data-menu-collapse="lg"] .nk-menu-dropdown {
        position: absolute;
        left: 0;
        top: 100%;
        background: #fff;
        border-radius: 0.5rem;
        opacity: 0;
        visibility: hidden;
        box-shadow: 0 0 20px 0 rgba(7, 19, 33, 0.08);
        display: block !important;
    }
    [data-menu-collapse="lg"] .nk-menu-mega-wrap {
        display: flex;
        padding: 0.5rem;
    }
    [data-menu-collapse="lg"] .nk-menu-sub {
        min-width: 10rem;
    }
    [data-menu-collapse="lg"] .nk-menu-sub .nk-menu-link {
        padding: 0.5rem 1.5rem;
    }
    [data-menu-collapse="lg"] .nk-menu-buttons {
        min-width: auto;
        margin-top: 0;
        padding: 0;
        margin-right: -1rem;
    }
    [data-menu-collapse="lg"] .nk-menu-buttons > li {
        padding: 0 1rem;
    }
    [data-menu-collapse="lg"] .on-dark .nk-menu-dropdown,
    [data-menu-collapse="lg"].is-dark .nk-menu-dropdown {
        background: #0b1f36;
    }
    [data-menu-collapse="lg"] .has-fixed .nk-menu-dropdown {
        border-top-right-radius: 0;
        border-top-left-radius: 0;
    }
}
</style>
<header class="nk-header">
  <div
    class="nk-header-main nk-menu-main will-shrink is-transparent ignore-mask"
  >
    <div class="container">
      <div class="nk-header-wrap">
        <div class="nk-header-logo">
          <a href="{{url('/')}}" class="logo-link"
            ><div class="logo-wrap">
              <img class="logo-img logo-dark" style="
                             top: -11px;
                             height: 43px;
                         "
                                 src="{{ asset('assets/LogoBrainNoir.png') }}" srcset="{{ asset('assets/LogoBrainNoir.png 2x') }}"
                                 alt="" />
                             <img class="logo-img logo-light " style="
                             top: -11px;
                             height: 39px;
                         "
                                 src="{{ asset('assets/LogoBrainBlanc.png') }}" srcset="{{ asset('assets/LogoBrainBlanc.png 2x') }}"
                                 alt="" /></div
          ></a>
        </div>
        <div class="nk-header-toggle">
          <button class="dark-mode-toggle">
            <em class="off icon ni ni-sun-fill"></em
            ><em class="on icon ni ni-moon-fill"></em></button
          ><button class="btn btn-light btn-icon header-menu-toggle">
            <em class="icon ni ni-menu"></em>
          </button>
        </div>
        <nav class="nk-header-menu nk-menu">
          <ul class="nk-menu-list mx-auto">
            <li class="nk-menu-item has-dropdown">
            <a href="{{url('/')}}" class="nk-menu-link"><span class="nk-menu-text">Accueil</span></a>

          </li>
          <li class="nk-menu-item">
          
              <a href="{{url('/a-propos')}}" class="nk-menu-link"><span class="nk-menu-text">A propos</span></a>
          </li>
            <li class="nk-menu-item has-dropdown">
              <a  class="nk-menu-link nk-menu-toggle"
                ><span class="nk-menu-text">Services</span></a
              >
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
                    <li class="nk-menu-item">
                      <a class="nk-menu-link"
                          href="{{ url('/service/agroalimentaire-tracabilite') }}">Autre
                        

                      </a>
                  </li>
                </ul>
                </div>
              </div>
            </li>
            <li class="nk-menu-item">
              <a href="{{url('/notre-demarche')}}" class="nk-menu-link"
                ><span class="nk-menu-text">Notre démarche</span></a
              >
            </li>
          
            <li class="nk-menu-item">
              <a href="{{url('/contact')}}" class="nk-menu-link"
                ><span class="nk-menu-text">Contact</span></a
              >
            </li>
          </ul>
          <div class="mx-2 d-none d-lg-block">
            <button class="dark-mode-toggle">
              <em class="off icon ni ni-sun-fill"></em
              ><em class="on icon ni ni-moon-fill"></em>
            </button>
          </div>
          <ul class="nk-menu-buttons flex-lg-row-reverse">
            <li><a href="{{url('/contact')}}" class="btn btn-primary">Demandez un devis</a></li>
           
          </ul>
        </nav>
      </div>
    </div>
  </div>
</header>