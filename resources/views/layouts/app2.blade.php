<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="author" content="Softnio" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/brainv.png" />
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
  />
    <title>
    Brain Technology &amp; AI Automatisation & Blockchain Solutions.
    </title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css?v1.5.0')}}" />
  </head>
  <body class="is-dark nk-body" data-menu-collapse="lg">
    <div class="nk-app-root">
    @include('partials.header2') <!-- Inclusion du header -->

    <main>
      @yield('content') <!-- Ici le contenu spécifique des pages sera rendu -->
    </main>

    @include('partials.footer') <!-- Inclusion du footer -->

  </div> 
  <!-- <div
    class="nk-sticky-toolbar z-index-highest position-fixed top-0 end-0 mt-12 pt-10"
  >
    <ul class="rounded-start-1 overflow-hidden">
      <li data-bs-toggle="tooltip" data-bs-title="See RTL Demo">
        <a class="btn btn-icon btn-sm btn-info rounded-0" href="rtl/index.htm"
          ><small>RTL</small></a
        >
      </li>
      <li data-bs-toggle="tooltip" data-bs-title="Go to Dashboard">
        <a
          class="btn btn-icon btn-sm btn-warning rounded-0"
          target="_blank"
          href="dashboard/index.htm"
          ><em class="icon ni ni-dashboard"></em
        ></a>
      </li>
      <li data-bs-toggle="tooltip" data-bs-title="Go to Intro Page">
        <a
          class="btn btn-icon btn-sm bg-body border-light border-start rounded-0"
          target="_blank"
          href="landing.html"
          ><img src="images/favicon.png" alt=""
        /></a>
      </li>
      <li data-bs-toggle="tooltip" data-bs-title="Purchase">
        <a
          class="btn btn-icon btn-sm btn-success text-white rounded-0"
          target="_blank"
          href="https://1.envato.market/CopyGen"
          ><em class="icon ni ni-cart"></em
        ></a>
      </li>
    </ul>
  </div> -->
  <script src="{{asset('assets/js/bundle.js?v1.5.0')}}"></script>
  <script src="{{asset('assets/js/scripts.js?v1.5.0')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.min.js"></script>
  <script>
  var startValue = 0;
  var endValue = 60; 
  var duration = 2000; 
  var incrementTime = 2000; 
  var currentValue = startValue;
  var compteurElement = document.getElementById('compteur');
  var increments = (endValue - startValue) / (duration / incrementTime);

  function updateCounter() {
    currentValue += increments;
    if (currentValue >= endValue) {
      compteurElement.innerText = endValue + '%';
    } else {
      compteurElement.innerText = Math.floor(currentValue) + '%';
      setTimeout(updateCounter, incrementTime);
    }
  }

  // Démarrer le compteur
  updateCounter();
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 5,  // Nombre de partenaires visibles à l'écran
    spaceBetween: 30,  // Espacement entre les slides
    loop: true,  // Active le mode de défilement en boucle
    autoplay: {
      delay: 1,  // Définir un délai très court pour un défilement continu
      disableOnInteraction: false,  // Continue à défiler même après une interaction
    },
    speed: 5000,  // Ajuster la vitesse pour un défilement fluide (5000ms)
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 30,
      },
      1024: {
        slidesPerView: 5,
        spaceBetween: 40,
      },
    },
  });
</script>

<script type="module">
    import Chatbot from "https://cdn.jsdelivr.net/gh/amansoni7477030/FlowiseChatEmbed@latest/dist/web.js";
    Chatbot.init({
        chatflowid: "246905b9-3278-4d67-8efc-556ae549bb64",
        apiHost: "https://aiworklowtech.com",
        chatflowConfig: {
            // topK: 2
        },
        theme: {
            button: {
                backgroundColor: "#1A1A1A",
                right: 20,
                bottom: 20,
                size: "large",
                iconColor: "#FFFFFF",
                customIconSrc: "https://i.ibb.co/Dbn8FCy/DALL-E-2024-08-01-20-17-09-Create-an-image-of-a-humanoid-with-a-human-like-face-and-hair-focusing-on.webp",
            },
            chatWindow: {
                title: "Brain Human-bot",
                titleAvatarSrc: "https://i.ibb.co/Dbn8FCy/DALL-E-2024-08-01-20-17-09-Create-an-image-of-a-humanoid-with-a-human-like-face-and-hair-focusing-on.webp",
                titeAvatarColor: '#FFFFFF',
                welcomeMessage: "Bonjour que puis-je faire pour vous ?",
                backgroundColor: "#F0F0F0",
                height: 450,
                width: 350,
                right: 50,
                fontSize: 16,
                poweredByTextColor: "#666666",
                botMessage: {
                    backgroundColor: "#2C3E50",
                    textColor: "#FFFFFF",
                    showAvatar: true,
                    avatarSrc: "https://i.ibb.co/Dbn8FCy/DALL-E-2024-08-01-20-17-09-Create-an-image-of-a-humanoid-with-a-human-like-face-and-hair-focusing-on.webp",
                },
                userMessage: {
                    backgroundColor: "#3498DB",
                    textColor: "#FFFFFF",
                    
                   
                },
                footer: {
                    textColor: '#888888',
                    text: 'Powered by',
                    company: 'BRAIN',
                    companyLink: 'https://braingentech.com/',
                },
                textInput: {
                    placeholder: "Type your question",
                    backgroundColor: "#FFFFFF",
                    textColor: "#333333",
                    sendButtonColor: "#1ABC9C",
                }
            }
        }
    })
</script>


</body>
</html>
