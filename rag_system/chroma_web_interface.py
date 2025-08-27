#!/usr/bin/env python3
"""
ChromaDB Web Interface - Interface web simple pour explorer ChromaDB
"""

import sys
import os
from pathlib import Path
sys.path.append(str(Path(__file__).parent))

import sqlite3
import json
from flask import Flask, render_template_string, request, jsonify
from config.settings import CHROMA_DIR

app = Flask(__name__)

# Template HTML pour l'interface
HTML_TEMPLATE = """
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChromaDB Interface - BrainGenTechnology</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 300;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.8;
        }
        .content {
            padding: 30px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            color: white;
        }
        .stat-card h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: bold;
        }
        .stat-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }
        .search-section {
            background: #f8f9ff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .search-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .search-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .documents-section {
            margin-top: 30px;
        }
        .document {
            background: #fff;
            border: 1px solid #e1e8ed;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .document h4 {
            margin: 0 0 10px 0;
            color: #2a5298;
        }
        .document-content {
            background: #f8f9ff;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            white-space: pre-wrap;
            overflow-wrap: break-word;
            max-height: 300px;
            overflow-y: auto;
        }
        .loading {
            text-align: center;
            padding: 40px;
            font-size: 18px;
            color: #666;
        }
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #f44336;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🧠 ChromaDB Interface</h1>
            <p>BrainGenTechnology - Exploration de la base vectorielle</p>
        </div>
        
        <div class="content">
            <div class="stats-grid">
                <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 id="total-docs">{{ stats.total_documents }}</h3>
                    <p>Documents</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <h3 id="collections">{{ stats.collections }}</h3>
                    <p>Collections</p>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <h3 id="embeddings">{{ stats.embeddings }}</h3>
                    <p>Embeddings</p>
                </div>
            </div>
            
            <div class="search-section">
                <h3>🔍 Recherche dans les documents</h3>
                <input type="text" id="search-input" class="search-input" placeholder="Rechercher dans la base de connaissances..." value="">
                <button onclick="searchDocuments()" class="search-btn">Rechercher</button>
            </div>
            
            <div class="documents-section">
                <h3 id="results-title">📄 Documents récents</h3>
                <div id="documents-container">
                    {% for doc in documents %}
                    <div class="document">
                        <h4>Document</h4>
                        <div class="document-content">{{ doc.content }}</div>
                    </div>
                    {% endfor %}
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchDocuments() {
            const query = document.getElementById('search-input').value;
            const container = document.getElementById('documents-container');
            const resultsTitle = document.getElementById('results-title');
            
            if (!query.trim()) {
                alert('Veuillez saisir un terme de recherche');
                return;
            }
            
            container.innerHTML = '<div class="loading">🔍 Recherche en cours...</div>';
            resultsTitle.textContent = '🔍 Résultats de recherche';
            
            fetch('/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({query: query})
            })
            .then(response => response.json())
            .then(data => {
                container.innerHTML = '';
                
                if (data.success && data.results.length > 0) {
                    data.results.forEach((result, index) => {
                        const docDiv = document.createElement('div');
                        docDiv.className = 'document';
                        docDiv.innerHTML = `
                            <h4>Résultat ${index + 1}</h4>
                            <div class="document-content">${result.content}</div>
                        `;
                        container.appendChild(docDiv);
                    });
                } else {
                    container.innerHTML = '<div class="error">Aucun résultat trouvé pour "' + query + '"</div>';
                }
            })
            .catch(error => {
                container.innerHTML = '<div class="error">Erreur lors de la recherche: ' + error.message + '</div>';
            });
        }
        
        // Recherche avec Enter
        document.getElementById('search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchDocuments();
            }
        });
        
        // Charger des exemples au démarrage
        window.onload = function() {
            loadRecentDocuments();
        };
        
        function loadRecentDocuments() {
            fetch('/recent')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('documents-container');
                container.innerHTML = '';
                
                if (data.success && data.documents.length > 0) {
                    data.documents.forEach((doc, index) => {
                        const docDiv = document.createElement('div');
                        docDiv.className = 'document';
                        docDiv.innerHTML = `
                            <h4>Document ${index + 1}</h4>
                            <div class="document-content">${doc.content}</div>
                        `;
                        container.appendChild(docDiv);
                    });
                }
            });
        }
    </script>
</body>
</html>
"""

def get_db_connection():
    """Obtenir une connexion à la base ChromaDB"""
    db_path = CHROMA_DIR / "chroma.sqlite3"
    if not db_path.exists():
        return None
    return sqlite3.connect(str(db_path))

def get_stats():
    """Obtenir les statistiques de la base"""
    conn = get_db_connection()
    if not conn:
        return {"total_documents": 0, "collections": 0, "embeddings": 0}
    
    try:
        cursor = conn.cursor()
        
        # Compter les documents
        cursor.execute("SELECT COUNT(*) FROM embedding_fulltext_search")
        total_docs = cursor.fetchone()[0]
        
        # Compter les collections
        cursor.execute("SELECT COUNT(*) FROM collections")
        collections = cursor.fetchone()[0]
        
        # Compter les embeddings
        cursor.execute("SELECT COUNT(*) FROM embeddings")
        embeddings = cursor.fetchone()[0]
        
        conn.close()
        
        return {
            "total_documents": total_docs,
            "collections": collections,
            "embeddings": embeddings
        }
    except Exception as e:
        conn.close()
        return {"total_documents": 0, "collections": 0, "embeddings": 0}

def get_recent_documents(limit=5):
    """Obtenir les documents récents"""
    conn = get_db_connection()
    if not conn:
        return []
    
    try:
        cursor = conn.cursor()
        cursor.execute(f"SELECT string_value FROM embedding_fulltext_search LIMIT {limit}")
        results = cursor.fetchall()
        conn.close()
        
        documents = []
        for result in results:
            content = result[0][:1000] + "..." if len(result[0]) > 1000 else result[0]
            documents.append({"content": content})
        
        return documents
    except Exception as e:
        conn.close()
        return []

def search_documents(query, limit=10):
    """Rechercher des documents par mot-clé"""
    conn = get_db_connection()
    if not conn:
        return []
    
    try:
        cursor = conn.cursor()
        
        # Recherche avec LIKE (simple mais efficace)
        cursor.execute(
            f"SELECT string_value FROM embedding_fulltext_search WHERE string_value LIKE ? LIMIT {limit}",
            (f"%{query}%",)
        )
        results = cursor.fetchall()
        conn.close()
        
        documents = []
        for result in results:
            # Highlighter le terme recherché (simple)
            content = result[0]
            if len(content) > 800:
                # Trouver le contexte autour du terme
                query_pos = content.lower().find(query.lower())
                if query_pos != -1:
                    start = max(0, query_pos - 200)
                    end = min(len(content), query_pos + 600)
                    content = "..." + content[start:end] + "..."
                else:
                    content = content[:800] + "..."
            
            documents.append({"content": content})
        
        return documents
    except Exception as e:
        conn.close()
        return []

@app.route('/')
def index():
    """Page principale"""
    stats = get_stats()
    documents = get_recent_documents(5)
    return render_template_string(HTML_TEMPLATE, stats=stats, documents=documents)

@app.route('/search', methods=['POST'])
def search():
    """API de recherche"""
    data = request.get_json()
    query = data.get('query', '')
    
    if not query:
        return jsonify({"success": False, "error": "Requête vide"})
    
    results = search_documents(query, 10)
    return jsonify({"success": True, "results": results})

@app.route('/recent')
def recent():
    """API pour les documents récents"""
    documents = get_recent_documents(8)
    return jsonify({"success": True, "documents": documents})

@app.route('/stats')
def stats():
    """API pour les statistiques"""
    stats_data = get_stats()
    return jsonify(stats_data)

if __name__ == '__main__':
    print("🧠 Démarrage de l'interface web ChromaDB")
    print(f"📂 Base de données: {CHROMA_DIR / 'chroma.sqlite3'}")
    print("🌐 Interface disponible sur: http://localhost:5001")
    print("=" * 50)
    
    # Vérifier la disponibilité de la base
    if not (CHROMA_DIR / "chroma.sqlite3").exists():
        print("❌ Base de données ChromaDB non trouvée!")
        print(f"Chemin: {CHROMA_DIR / 'chroma.sqlite3'}")
    else:
        stats = get_stats()
        print(f"✅ Base trouvée - {stats['total_documents']} documents, {stats['collections']} collections")
    
    app.run(host='0.0.0.0', port=5002, debug=True)