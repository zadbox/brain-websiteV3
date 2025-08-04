#!/usr/bin/env python3

import os
import httpx
from dotenv import load_dotenv

load_dotenv()

def test_groq_api():
    api_key = os.getenv("GROQ_API_KEY")
    
    if not api_key:
        print("❌ No GROQ API key found")
        return
        
    print(f"✅ API Key present: {api_key[:10]}...")
    
    try:
        response = httpx.post(
            "https://api.groq.com/openai/v1/chat/completions",
            headers={
                "Authorization": f"Bearer {api_key}",
                "Content-Type": "application/json"
            },
            json={
                "model": "llama-3.1-8b-instant",
                "messages": [{"role": "user", "content": "Hello! What is 2+2?"}],
                "temperature": 0.3,
                "max_tokens": 100,
                "stream": False
            },
            timeout=10.0
        )
        
        print(f"Status: {response.status_code}")
        if response.status_code == 200:
            result = response.json()
            content = result["choices"][0]["message"]["content"]
            print(f"✅ Response: {content}")
        else:
            print(f"❌ Error: {response.text}")
            
    except Exception as e:
        print(f"❌ Exception: {e}")
        import traceback
        traceback.print_exc()

if __name__ == "__main__":
    test_groq_api()