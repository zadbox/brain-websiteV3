<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="author" content="Softnio" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/brainv.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
  />

  
   
   
  </style>
    <title>
    Brain Technology &amp; AI Automatisation & Blockchain Solutions.
    </title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css?v1.5.0')}}" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  </head>
  <body class="is-dark nk-body" data-menu-collapse="lg">
    <div class="nk-app-root">
    @include('partials.header') <!-- Inclusion du header -->

    <main>
      @yield('content') <!-- Ici le contenu spécifique des pages sera rendu -->
    </main>

    @include('partials.footer') <!-- Inclusion du footer -->

  </div> 

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const counters = document.querySelectorAll('.counter');
      const speed = 200; // Ajuste la vitesse de l'animation
  
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const counter = entry.target;
            const updateCount = () => {
              const target = +counter.getAttribute('data-target');
              const count = +counter.innerText;
  
              // Calcul du nombre à ajouter à chaque étape
              const increment = target / speed;
  
              if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(updateCount, 10); // Met à jour toutes les 10ms
              } else {
                counter.innerText = target;
              }
            };
  
            // Réinitialiser le compteur et redémarrer l'animation
            counter.innerText = '0'; 
            updateCount();
          }
        });
      }, { threshold: 1.0 }); // 1.0 signifie que l'élément doit être complètement visible
  
      counters.forEach(counter => {
        observer.observe(counter);
      });
    });
  </script>
  
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
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
      delay: 3000,  // Délai entre chaque slide (3 secondes)
      disableOnInteraction: false,  // Continue à défiler même après interaction utilisateur
    },
    speed: 1000,  // Ajustez la vitesse de défilement
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
