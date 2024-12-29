<footer id="ftr" class="nk-footer">
    <div class="section">
      <div class="container">
        <div class="row g-5">
          <div class="col-xl-3 col-sm-4 col-6">
            <div class="wgs">
              <h6 class="wgs-title overline-title text-heading mb-3">
                Lien utils
              </h6>
              <ul class="list gy-2 list-link-base">
                <li><a class="link-base" href="{{url('/')}}">Accueil</a></li>
                <li><a class="link-base" href="{{url('/a-propos')}}">A propos</a></li>
                <li><a class="link-base" href="#">Nos services</a></li>
                <li>
                  <a class="link-base" href="{{url('/notre-demarche')}}">Notre démarche</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-xl-2 col-sm-4 col-6">
            <div class="wgs">
              <h6 class="wgs-title overline-title text-heading mb-3">
                Services
              </h6>
              <ul class="list gy-2 list-link-base">
                <li><a class="link-base" href="{{url('/service/communication-et-marketing-digital')}}"> Communication et Marketing Digital </a></li>
                <li><a class="link-base" href="{{url('/service/promotion-immobiliere-conciergerie')}}">Promotion Immobilière et Conciergerie</a></li>
                <li><a class="link-base" href="{{url('/service/agroalimentaire-tracabilite')}}">Agroalimentaire et Traçabilité</a></li>
                <li>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-xl-2 col-sm-4 col-6">
            <div class="wgs">
              <h6 class="wgs-title overline-title text-heading mb-3">
              BRAIN TECHNOLOGY
              </h6>
              <ul class="list gy-2 list-link-base">
                <li><a class="link-base" href="{{url('/contact')}}">Contact</a></li>
                <li><a class="link-base" href="{{url('/faqs')}}">FAQs</a></li>
              </ul>
            </div>
          </div>
          <div class="col-xl-4 col-lg-7 col-md-9 me-auto order-xl-first">
            <div class="block-text">
              
              <h4 class="title">BRAIN TECHNOLOGY.</h4>
              <p id="animated-text" style="text-align: justify">
                Chez BRAIN TECHNOLOGY, nous vous aidons à libérer vos équipes des tâches répétitives et à faible valeur ajoutée,
                en automatisant ce qui peut l’être, pour leur permettre de se concentrer sur des missions stratégiques et créatives.
              </p>
              <p class="text-heading mt-4">
                &copy; 2024  tous droits réservés - BRAIN TECHNOLOGY
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <style>
#animated-text {
  opacity: 1; /* Le conteneur du texte est toujours visible */
  white-space: pre-wrap; /* Préserve les retours à la ligne */
  line-height: 1.5em; /* Ajustez l'espacement des lignes */
  overflow: hidden;
}

.line {
  opacity: 0; /* Initialement, les lignes sont invisibles */
  transform: translateY(20px); /* Décalage initial */
  transition: opacity 0.5s ease, transform 0.5s ease;
}

.line.visible {
  opacity: 1; /* Les lignes deviennent visibles */
  transform: translateY(0); /* Elles se déplacent à leur position normale */
}


    </style>

    <script>
  document.addEventListener("DOMContentLoaded", () => {
  const textElement = document.getElementById("animated-text");
  const originalText = textElement.textContent.trim();
  const lines = originalText.split(/,\s|\.\s|\n/); // Découpe le texte en phrases ou lignes

  // Supprime le contenu initial et crée des lignes
  textElement.innerHTML = "";
  lines.forEach((line, index) => {
    const span = document.createElement("span");
    span.classList.add("line");
    span.style.display = "block";
    span.style.transitionDelay = `${index * 0.3}s`; // Ajoute un délai progressif
    span.textContent = line.trim();
    textElement.appendChild(span);
  });

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Ajoute la classe visible aux lignes
          const lineElements = textElement.querySelectorAll(".line");
          lineElements.forEach((line) => line.classList.add("visible"));
        } else {
          // Réinitialise l'animation si nécessaire
          const lineElements = textElement.querySelectorAll(".line");
          lineElements.forEach((line) => line.classList.remove("visible"));
        }
      });
    },
    { threshold: 0.5 } // Déclenche lorsque 50% de la section est visible
  );

  observer.observe(document.getElementById("ftr"));
});


    </script>
  </footer>