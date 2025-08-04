#!/usr/bin/env python3

import os
from dotenv import load_dotenv
load_dotenv()

try:
    from langchain_groq import ChatGroq
    
    groq_api_key = os.getenv("GROQ_API_KEY")
    print(f"API Key present: {bool(groq_api_key)}")
    print(f"API Key length: {len(groq_api_key) if groq_api_key else 0}")
    
    # Test initialization with correct parameters
    llm = ChatGroq(
        api_key=groq_api_key,
        model="llama-3.1-8b-instant",
        temperature=0.3,
        max_tokens=100,
        timeout=10.0,
        max_retries=2
    )
    
    print("✅ Groq LLM initialized successfully!")
    
    # Test a simple query
    response = llm.invoke("Hello, what is 2+2?")
    print(f"✅ Test response: {response.content}")
    
except Exception as e:
    print(f"❌ Error: {e}")
    import traceback
    traceback.print_exc()