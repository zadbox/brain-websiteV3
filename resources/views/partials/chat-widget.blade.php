<!-- Chat Widget -->
<div id="brain-chat-widget" class="chat-widget">
    <!-- Chat Button -->
    <button id="chat-toggle" 
            class="chat-button group" 
            aria-label="Open Brain Assistant"
            aria-expanded="false">
        <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        
        <!-- Pulse Animation -->
        <div class="absolute inset-0 rounded-2xl bg-primary-500 animate-ping opacity-20"></div>
    </button>
    
    <!-- Chat Window (initially hidden) -->
    <div id="chat-window" 
         class="fixed bottom-24 right-6 w-80 h-96 bg-neutral-800 border border-neutral-700 rounded-2xl shadow-2xl transform translate-y-full opacity-0 invisible transition-all duration-300 md:w-96 md:h-[500px]">
        
        <!-- Chat Header -->
        <div class="flex items-center justify-between p-4 border-b border-neutral-700 bg-neutral-800 rounded-t-2xl">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-primary-500/10 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-white">Brain Assistant</h4>
                    <p class="text-xs text-neutral-400">Powered by Brain AI</p>
                </div>
            </div>
            
            <!-- Close Button -->
            <button id="chat-close" 
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-neutral-700 transition-colors duration-200"
                    aria-label="Close chat">
                <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Chat Messages -->
        <div id="chat-messages" 
             class="flex-1 p-4 space-y-4 overflow-y-auto bg-neutral-900 max-h-80 md:max-h-96">
            
            <!-- Welcome Message -->
            <div class="flex space-x-3">
                <div class="w-8 h-8 bg-primary-500/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="bg-neutral-800 rounded-2xl rounded-tl-md p-3 max-w-xs">
                    <p class="text-sm text-neutral-200">
                        Hello! I'm your Brain Assistant. How can I help you with AI solutions today?
                    </p>
                </div>
            </div>
            
            <!-- Typing Indicator (hidden by default) -->
            <div id="typing-indicator" class="flex space-x-3 hidden">
                <div class="w-8 h-8 bg-primary-500/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="bg-neutral-800 rounded-2xl rounded-tl-md p-3">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-primary-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Chat Input -->
        <div class="p-4 border-t border-neutral-700 bg-neutral-800 rounded-b-2xl">
            <div class="flex space-x-2">
                <input type="text" 
                       id="chat-input"
                       placeholder="Type your message..."
                       class="flex-1 bg-neutral-900 border border-neutral-600 rounded-full px-4 py-2 text-sm text-white placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <button id="chat-send" 
                        class="w-10 h-10 bg-primary-500 hover:bg-primary-600 rounded-full flex items-center justify-center transition-colors duration-200"
                        aria-label="Send message">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </div>
            
            <!-- Powered by Badge -->
            <div class="mt-2 text-center">
                <span class="text-xs text-neutral-500">Powered by </span>
                <span class="text-xs text-primary-400 font-medium">Brain AI</span>
            </div>
        </div>
        
    </div>
</div>

<script>
class BrainChatWidget {
    constructor() {
        this.isOpen = false;
        this.chatToggle = document.getElementById('chat-toggle');
        this.chatWindow = document.getElementById('chat-window');
        this.chatClose = document.getElementById('chat-close');
        this.chatInput = document.getElementById('chat-input');
        this.chatSend = document.getElementById('chat-send');
        this.chatMessages = document.getElementById('chat-messages');
        this.typingIndicator = document.getElementById('typing-indicator');
        
        this.init();
    }
    
    init() {
        // Event listeners
        this.chatToggle?.addEventListener('click', () => this.toggleChat());
        this.chatClose?.addEventListener('click', () => this.closeChat());
        this.chatSend?.addEventListener('click', () => this.sendMessage());
        this.chatInput?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        });
        
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.isOpen && !this.chatWindow?.contains(e.target) && !this.chatToggle?.contains(e.target)) {
                this.closeChat();
            }
        });
    }
    
    toggleChat() {
        if (this.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }
    
    openChat() {
        this.isOpen = true;
        this.chatToggle?.setAttribute('aria-expanded', 'true');
        
        if (this.chatWindow) {
            this.chatWindow.classList.remove('translate-y-full', 'opacity-0', 'invisible');
            this.chatWindow.classList.add('translate-y-0', 'opacity-100', 'visible');
        }
        
        // Focus on input
        setTimeout(() => {
            this.chatInput?.focus();
        }, 300);
    }
    
    closeChat() {
        this.isOpen = false;
        this.chatToggle?.setAttribute('aria-expanded', 'false');
        
        if (this.chatWindow) {
            this.chatWindow.classList.add('translate-y-full', 'opacity-0', 'invisible');
            this.chatWindow.classList.remove('translate-y-0', 'opacity-100', 'visible');
        }
    }
    
    sendMessage() {
        const message = this.chatInput?.value.trim();
        if (!message) return;
        
        // Add user message
        this.addMessage(message, 'user');
        
        // Clear input
        if (this.chatInput) {
            this.chatInput.value = '';
        }
        
        // Show typing indicator
        this.showTypingIndicator();
        
        // Simulate response (replace with actual API call)
        setTimeout(() => {
            this.hideTypingIndicator();
            this.addMessage(this.generateResponse(message), 'assistant');
        }, 1500);
    }
    
    addMessage(text, sender) {
        if (!this.chatMessages) return;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex space-x-3';
        
        if (sender === 'user') {
            messageDiv.innerHTML = `
                <div class="flex-1"></div>
                <div class="bg-primary-500 rounded-2xl rounded-tr-md p-3 max-w-xs">
                    <p class="text-sm text-white">${text}</p>
                </div>
                <div class="w-8 h-8 bg-neutral-700 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-neutral-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-primary-500/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="bg-neutral-800 rounded-2xl rounded-tl-md p-3 max-w-xs">
                    <p class="text-sm text-neutral-200">${text}</p>
                </div>
            `;
        }
        
        this.chatMessages.appendChild(messageDiv);
        this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
    }
    
    showTypingIndicator() {
        this.typingIndicator?.classList.remove('hidden');
        this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
    }
    
    hideTypingIndicator() {
        this.typingIndicator?.classList.add('hidden');
    }
    
    generateResponse(message) {
        // Simple response logic (replace with actual AI integration)
        const responses = [
            "I'd be happy to help you explore our AI solutions. Would you like to know more about Brain Invest, Brain RH+, or Brain Assistant?",
            "Our AI automation solutions can help streamline your business processes. What specific area are you looking to improve?",
            "Thanks for your question! Our team can provide you with a detailed consultation. Would you like to schedule a demo?",
            "That's a great question about our technology. Our multi-agent systems and RAG pipeline can address that need. Let me connect you with a specialist.",
            "I can help you understand how our blockchain solutions integrate with AI. Would you like to explore our case studies?"
        ];
        
        return responses[Math.floor(Math.random() * responses.length)];
    }
}

// Initialize chat widget when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new BrainChatWidget();
});

// Global function for footer link
function toggleChatWidget() {
    const chatWidget = document.querySelector('#brain-chat-widget button');
    if (chatWidget) {
        chatWidget.click();
    }
}
</script>
