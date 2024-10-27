@extends('layouts.app2')

@section('title', 'À propos')

@section('content')
<main class="nk-pages">

    <section class="section section-lg bg-white">
        <div class="container">
          <div class="section-head">
            <div class="row justify-content-center text-center">
              <div class="col-xl-8">
                <h2 class="title">Questions &amp; Réponses</h2>
                <p class="lead">
                  Découvrez les réponses aux questions les plus fréquentes sur nos technologies d'Intelligence Artificielle, de Blockchain et d'Automatisation.
                </p>
              </div>
            </div>
          </div>
          <div class="section-content">
            <div class="row g-gs justify-content-center">
              <div class="col-xl-9 col-xxl-8">
                <div class="accordion accordion-separated accordion-plus-minus" id="faq-1">
                  
                  <!-- AI Section -->
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faq-1-1">
                        Comment l'intelligence artificielle est-elle utilisée dans vos solutions ?
                      </button>
                    </h2>
                    <div id="faq-1-1" class="accordion-collapse collapse show" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        Nos solutions utilisent l'IA pour automatiser des tâches complexes, améliorer les processus décisionnels et fournir des analyses prédictives. Nous exploitons le machine learning et le traitement du langage naturel (NLP) pour optimiser la gestion des données et l'interface utilisateur.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-2">
                        Quels sont les avantages de l'IA pour l'automatisation ?
                      </button>
                    </h2>
                    <div id="faq-1-2" class="accordion-collapse collapse" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        L'IA permet d'automatiser des processus répétitifs, de réduire les erreurs humaines et d'optimiser l'efficacité opérationnelle. Elle peut également identifier des modèles dans les données pour proposer des solutions plus intelligentes et améliorer les résultats commerciaux.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-3">
                        Comment l'IA améliore-t-elle la sécurité des données ?
                      </button>
                    </h2>
                    <div id="faq-1-3" class="accordion-collapse collapse" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        Grâce à l'analyse en temps réel et à l'apprentissage automatique, l'IA peut identifier des comportements inhabituels et potentiellement malveillants. Elle permet ainsi d'améliorer la détection des cybermenaces et de renforcer la protection des données sensibles.
                      </div>
                    </div>
                  </div>

                  <!-- Blockchain Section -->
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-4">
                        Qu'est-ce que la blockchain et comment l'intégrez-vous dans vos solutions ?
                      </button>
                    </h2>
                    <div id="faq-1-4" class="accordion-collapse collapse" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        La blockchain est une technologie de registre distribué qui permet des transactions sécurisées et transparentes sans besoin d'intermédiaires. Nous l'utilisons pour garantir l'intégrité des données, sécuriser les transactions et améliorer la traçabilité dans différents secteurs, comme l'énergie ou les chaînes d'approvisionnement.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-5">
                        Quels sont les avantages de la blockchain pour les entreprises ?
                      </button>
                    </h2>
                    <div id="faq-1-5" class="accordion-collapse collapse" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        La blockchain offre une sécurité accrue, une transparence complète, et permet une réduction des coûts grâce à l'élimination des intermédiaires. Elle est particulièrement utile pour les transactions complexes ou dans des environnements où la confiance est cruciale.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-6">
                        Est-ce que la blockchain peut être utilisée pour l'automatisation des processus ?
                      </button>
                    </h2>
                    <div id="faq-1-6" class="accordion-collapse collapse" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        Oui, la blockchain peut être utilisée pour automatiser des processus via des contrats intelligents (smart contracts). Ces contrats exécutent automatiquement des actions prédéfinies dès que les conditions spécifiées sont remplies, ce qui améliore l'efficacité des transactions.
                      </div>
                    </div>
                  </div>

                  <!-- Automation Section -->
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-7">
                        Comment vos solutions d'automatisation transforment-elles les entreprises ?
                      </button>
                    </h2>
                    <div id="faq-1-7" class="accordion-collapse collapse" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        Nos solutions d'automatisation permettent de réduire le temps passé sur des tâches répétitives, d'augmenter la productivité et de minimiser les coûts opérationnels. En automatisant les processus critiques, les entreprises peuvent se concentrer sur des tâches à plus forte valeur ajoutée.
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq-1-8">
                        Quels processus peuvent être automatisés avec vos solutions ?
                      </button>
                    </h2>
                    <div id="faq-1-8" class="accordion-collapse collapse" data-bs-parent="#faq-1">
                      <div class="accordion-body">
                        Nous proposons des solutions pour automatiser un large éventail de processus, tels que la gestion des données, la facturation, les paiements sécurisés via blockchain, l'analyse prédictive et la gestion des relations clients. Chaque solution est adaptée aux besoins spécifiques de l'entreprise.
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</main>
@endsection
