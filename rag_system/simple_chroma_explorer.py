#!/usr/bin/env python3
"""
Simple ChromaDB Explorer
"""

import sys
import os
from pathlib import Path
sys.path.append(str(Path(__file__).parent))

import sqlite3
import json
from config.settings import CHROMA_DIR

def explore_chroma_db():
    """Explore ChromaDB via SQLite direct access"""
    db_path = CHROMA_DIR / "chroma.sqlite3"
    
    print(f"🧠 ChromaDB Explorer - BrainGenTechnology")
    print(f"📂 Database: {db_path}")
    
    if not db_path.exists():
        print("❌ Database not found!")
        return
    
    try:
        conn = sqlite3.connect(str(db_path))
        cursor = conn.cursor()
        
        # Liste des tables
        print("\n📋 Tables disponibles:")
        cursor.execute("SELECT name FROM sqlite_master WHERE type='table'")
        tables = cursor.fetchall()
        for table in tables:
            print(f"  - {table[0]}")
        
        # Collections
        print("\n📚 Collections:")
        try:
            cursor.execute("SELECT name, id FROM collections")
            collections = cursor.fetchall()
            for name, coll_id in collections:
                print(f"  - {name} (ID: {coll_id})")
                
                # Compter les documents dans cette collection
                cursor.execute("SELECT COUNT(*) FROM embeddings WHERE collection_id = ?", (coll_id,))
                count = cursor.fetchone()[0]
                print(f"    📄 Documents: {count}")
        except Exception as e:
            print(f"    ⚠️  Erreur collections: {e}")
        
        # Échantillon de documents
        print("\n📄 Échantillon de documents:")
        try:
            cursor.execute("""
                SELECT e.document, e.id, em.key, em.string_value 
                FROM embeddings e 
                LEFT JOIN embedding_metadata em ON e.id = em.id 
                LIMIT 10
            """)
            docs = cursor.fetchall()
            
            current_doc = None
            metadata = {}
            
            for doc_content, doc_id, meta_key, meta_value in docs:
                if doc_content != current_doc:
                    if current_doc:
                        # Afficher le document précédent
                        print(f"\n🔹 ID: {doc_id}")
                        if metadata:
                            print(f"   Métadonnées: {json.dumps(metadata, indent=4, ensure_ascii=False)}")
                        print(f"   Contenu: {current_doc[:200]}...")
                        print("-" * 50)
                    
                    current_doc = doc_content
                    metadata = {}
                
                if meta_key and meta_value:
                    metadata[meta_key] = meta_value
            
            # Afficher le dernier document
            if current_doc:
                print(f"\n🔹 Contenu: {current_doc[:200]}...")
                if metadata:
                    print(f"   Métadonnées: {json.dumps(metadata, indent=4, ensure_ascii=False)}")
        
        except Exception as e:
            print(f"    ⚠️  Erreur documents: {e}")
        
        # Statistiques
        print("\n📊 Statistiques:")
        try:
            cursor.execute("SELECT COUNT(*) FROM embeddings")
            total_embeddings = cursor.fetchone()[0]
            print(f"  - Total embeddings: {total_embeddings}")
            
            cursor.execute("SELECT COUNT(*) FROM collections")
            total_collections = cursor.fetchone()[0]
            print(f"  - Total collections: {total_collections}")
            
        except Exception as e:
            print(f"    ⚠️  Erreur stats: {e}")
        
        conn.close()
        print("\n✅ Exploration terminée")
        
    except Exception as e:
        print(f"❌ Erreur: {e}")

def search_documents(query="BrainGenTechnology"):
    """Recherche simple dans les documents"""
    db_path = CHROMA_DIR / "chroma.sqlite3"
    
    if not db_path.exists():
        print("❌ Database not found!")
        return
    
    try:
        conn = sqlite3.connect(str(db_path))
        cursor = conn.cursor()
        
        print(f"\n🔍 Recherche: '{query}'")
        
        # Recherche textuelle simple
        cursor.execute("""
            SELECT e.document, e.id
            FROM embeddings e 
            WHERE e.document LIKE ?
            LIMIT 5
        """, (f"%{query}%",))
        
        results = cursor.fetchall()
        
        if results:
            print(f"📄 {len(results)} résultats trouvés:")
            for i, (document, doc_id) in enumerate(results):
                print(f"\n{i+1}. ID: {doc_id}")
                print(f"   Contenu: {document[:300]}...")
                print("-" * 40)
        else:
            print("❌ Aucun résultat trouvé")
        
        conn.close()
        
    except Exception as e:
        print(f"❌ Erreur recherche: {e}")

if __name__ == "__main__":
    explore_chroma_db()
    
    # Menu interactif simple
    while True:
        print("\n" + "="*50)
        print("1. Explorer la base")
        print("2. Rechercher")
        print("3. Quitter")
        
        choice = input("\nChoix (1-3): ").strip()
        
        if choice == "1":
            explore_chroma_db()
        elif choice == "2":
            query = input("Terme de recherche: ").strip()
            if query:
                search_documents(query)
        elif choice == "3":
            print("👋 Au revoir!")
            break
        else:
            print("❌ Choix invalide")