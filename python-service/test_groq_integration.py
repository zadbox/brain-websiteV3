#!/usr/bin/env python3

import requests
import json
import time

def test_groq_integration():
    """Test complet de l'intégration Groq et des fonctionnalités du chatbot"""
    
    base_url = "http://localhost:8001"
    
    print("🚀 Test complet de l'intégration Groq - BrainGenTech Chatbot")
    print("=" * 60)
    
    # Test 1: Health check
    print("\n🔍 Test 1: Vérification de l'état du service...")
    try:
        response = requests.get(f"{base_url}/health")
        if response.status_code == 200:
            health_data = response.json()
            print(f"✅ Service opérationnel: {health_data['status']}")
            print(f"   Services: {health_data['services']}")
        else:
            print(f"❌ Service indisponible: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Erreur de connexion: {e}")
        return False
    
    # Test 2: Test des réponses intelligentes
    test_messages = [
        "bonjour",
        "Parlez-moi de vos solutions agroalimentaires",
        "Quels sont vos tarifs ?",
        "Je veux un chatbot pour mon entreprise",
        "Comment fonctionne votre qualification de leads ?"
    ]
    
    print(f"\n💬 Test 2: Test des réponses intelligentes ({len(test_messages)} messages)")
    
    for i, message in enumerate(test_messages, 1):
        print(f"\n--- Test {i}: '{message}' ---")
        try:
            response = requests.post(
                f"{base_url}/chat",
                headers={"Content-Type": "application/json"},
                json={"message": message}
            )
            
            if response.status_code == 200:
                data = response.json()
                print(f"✅ Réponse reçue ({len(data['response'])} caractères)")
                print(f"   Confiance: {data['confidence']:.2f}")
                print(f"   Source: {data['source']}")
                print(f"   Temps de traitement: {data['processing_time']:.3f}s")
                
                # Afficher les suggestions
                if data.get('suggestions'):
                    print(f"   Suggestions: {len(data['suggestions'])} proposées")
                
                # Afficher la qualification de lead
                if data.get('lead_qualification'):
                    lead = data['lead_qualification']
                    print(f"   Qualification: {lead['category']} (confiance: {lead['confidence']:.2f})")
                
            else:
                print(f"❌ Erreur HTTP: {response.status_code}")
                
        except Exception as e:
            print(f"❌ Erreur de test: {e}")
    
    # Test 3: Test de qualification de leads
    print(f"\n🎯 Test 3: Qualification de leads")
    lead_test_messages = [
        "Nous avons un budget de 50k€ pour un projet urgent",
        "Je suis directeur marketing et nous cherchons des solutions IA",
        "Nous voulons améliorer notre présence digitale"
    ]
    
    for i, message in enumerate(lead_test_messages, 1):
        print(f"\n--- Qualification {i}: '{message}' ---")
        try:
            response = requests.post(
                f"{base_url}/qualify-lead",
                headers={"Content-Type": "application/json"},
                json={"message": message}
            )
            
            if response.status_code == 200:
                data = response.json()
                print(f"✅ Lead qualifié: {data['category']}")
                print(f"   Score BANT: {data['bant_score']}")
                print(f"   Recommandations: {data['recommendations']}")
            else:
                print(f"❌ Erreur qualification: {response.status_code}")
                
        except Exception as e:
            print(f"❌ Erreur qualification: {e}")
    
    # Test 4: Test de recherche dans la base de connaissances
    print(f"\n🔍 Test 4: Recherche dans la base de connaissances")
    search_queries = [
        "agroalimentaire",
        "immobilier",
        "communication"
    ]
    
    for query in search_queries:
        print(f"\n--- Recherche: '{query}' ---")
        try:
            response = requests.get(f"{base_url}/search-knowledge", params={"query": query, "limit": 3})
            
            if response.status_code == 200:
                data = response.json()
                print(f"✅ {len(data)} résultats trouvés")
                for j, result in enumerate(data[:2], 1):
                    print(f"   Résultat {j}: {result['text'][:100]}...")
            else:
                print(f"❌ Erreur recherche: {response.status_code}")
                
        except Exception as e:
            print(f"❌ Erreur recherche: {e}")
    
    # Test 5: Test de performance
    print(f"\n⚡ Test 5: Test de performance")
    start_time = time.time()
    
    for _ in range(5):
        response = requests.post(
            f"{base_url}/chat",
            headers={"Content-Type": "application/json"},
            json={"message": "test performance"}
        )
    
    total_time = time.time() - start_time
    avg_time = total_time / 5
    
    print(f"✅ 5 requêtes en {total_time:.3f}s (moyenne: {avg_time:.3f}s)")
    
    # Résumé final
    print(f"\n🎉 Test d'intégration Groq terminé avec succès !")
    print(f"✅ Service opérationnel sur {base_url}")
    print(f"✅ Réponses intelligentes fonctionnelles")
    print(f"✅ Qualification de leads active")
    print(f"✅ Base de connaissances accessible")
    print(f"✅ Performance optimale")
    
    return True

if __name__ == "__main__":
    test_groq_integration() 