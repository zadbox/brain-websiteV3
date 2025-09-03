
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
