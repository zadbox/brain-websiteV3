/**
 * =============================================================================
 * CHATBOT WIDGET - BRAINGEN TECHNOLOGY
 * Widget de chat moderne avec effet typing
 * =============================================================================
 */

class ChatbotWidget {
    constructor() {
        this.widget = document.getElementById('chatbot-widget');
        this.toggle = document.getElementById('chatbot-toggle');
        this.closeBtn = document.getElementById('chatbot-close');
        this.messagesContainer = document.getElementById('chatbot-messages');
        this.messageInput = document.getElementById('message-input');
        this.sendBtn = document.getElementById('send-btn');
        this.voiceBtn = document.getElementById('voice-btn');
        this.notificationBadge = document.querySelector('.notification-badge');
        
        this.messageCounter = 0;
        this.isTyping = false;
        this.typingSpeed = 50; // ms par caractère
        this.isOpen = false;
        this.isRecording = false;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.startWelcomeMessage();
        this.setupVoiceRecognition();
    }

    bindEvents() {
        // Toggle widget
        this.toggle.addEventListener('click', () => this.toggleWidget());
        this.closeBtn.addEventListener('click', () => this.closeWidget());
        
        // Send message
        this.sendBtn.addEventListener('click', () => this.sendMessage());
        this.messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });
        
        // Voice recording
        this.voiceBtn.addEventListener('click', () => this.toggleVoiceRecording());
        
        // Input validation
        this.messageInput.addEventListener('input', () => this.validateInput());
        
        // Click outside to close
        document.addEventListener('click', (e) => {
            if (!this.widget.contains(e.target) && !this.toggle.contains(e.target) && this.isOpen) {
                this.closeWidget();
            }
        });
    }

    toggleWidget() {
        if (this.isOpen) {
            this.closeWidget();
        } else {
            this.openWidget();
        }
    }

    openWidget() {
        this.widget.classList.add('active');
        this.isOpen = true;
        this.hideNotification();
        this.focusInput();
        
        // Animation du toggle button
        this.toggle.style.transform = 'rotate(180deg)';
        this.toggle.innerHTML = '<i class="fas fa-times"></i>';
    }

    closeWidget() {
        this.widget.classList.remove('active');
        this.isOpen = false;
        
        // Reset toggle button
        this.toggle.style.transform = 'rotate(0deg)';
        this.toggle.innerHTML = '<i class="fas fa-comments"></i>';
        
        if (this.notificationBadge) {
            this.toggle.appendChild(this.notificationBadge);
        }
    }

    focusInput() {
        setTimeout(() => {
            this.messageInput.focus();
        }, 300);
    }

    hideNotification() {
        if (this.notificationBadge) {
            this.notificationBadge.style.display = 'none';
        }
    }

    validateInput() {
        const message = this.messageInput.value.trim();
        this.sendBtn.disabled = message.length === 0;
        
        if (message.length > 0) {
            this.sendBtn.style.opacity = '1';
        } else {
            this.sendBtn.style.opacity = '0.5';
        }
    }

    startWelcomeMessage() {
        const welcomeMessage = "Bonjour ! Je suis votre assistant IA BrainGen. Comment puis-je vous aider aujourd'hui ?";
        setTimeout(() => {
            this.typeMessage(welcomeMessage, 0);
        }, 1000);
    }

    async sendMessage() {
        const message = this.messageInput.value.trim();
        if (message.length === 0 || this.isTyping) return;

        // Ajouter le message utilisateur
        this.addUserMessage(message);
        this.messageInput.value = '';
        this.validateInput();

        // Simuler une réponse du bot
        await this.simulateBotResponse(message);
    }

    addUserMessage(message) {
        const messageElement = this.createMessageElement(message, 'user');
        this.messagesContainer.appendChild(messageElement);
        this.scrollToBottom();
    }

    createMessageElement(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        
        if (type === 'user') {
            messageDiv.classList.add('slideInRight');
        }

        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = `<img src="assets/logo-b-white.png" alt="Avatar" class="avatar-img">`;

        const content = document.createElement('div');
        content.className = 'message-content';

        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        
        if (type === 'user') {
            bubble.textContent = message;
        } else {
            const typingText = document.createElement('div');
            typingText.className = 'typing-text';
            typingText.id = `typing-text-${this.messageCounter}`;
            
            const typingIndicator = document.createElement('div');
            typingIndicator.className = 'typing-indicator';
            typingIndicator.id = `typing-indicator-${this.messageCounter}`;
            typingIndicator.innerHTML = '<span></span><span></span><span></span>';
            
            bubble.appendChild(typingText);
            bubble.appendChild(typingIndicator);
        }

        const time = document.createElement('div');
        time.className = 'message-time';
        time.textContent = 'Il y a quelques secondes';

        content.appendChild(bubble);
        content.appendChild(time);
        
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(content);

        return messageDiv;
    }

    async simulateBotResponse(userMessage) {
        // Simuler un délai de réflexion
        await this.delay(1000);

        // Générer une réponse basée sur le message utilisateur
        const response = this.generateBotResponse(userMessage);
        
        // Ajouter le message bot avec effet typing
        const messageElement = this.createMessageElement('', 'bot');
        this.messagesContainer.appendChild(messageElement);
        this.scrollToBottom();

        // Démarrer l'effet typing
        await this.typeMessage(response, this.messageCounter);
        this.messageCounter++;
    }

    generateBotResponse(userMessage) {
        const responses = {
            'bonjour': 'Bonjour ! Comment puis-je vous aider aujourd\'hui ?',
            'hello': 'Hello! How can I assist you today?',
            'services': 'BrainGen propose des solutions d\'IA, de blockchain et d\'automatisation pour transformer votre entreprise.',
            'ai': 'Nos solutions d\'IA incluent l\'apprentissage automatique, le traitement du langage naturel et la vision par ordinateur.',
            'blockchain': 'Nous développons des contrats intelligents, des applications décentralisées et des solutions de traçabilité blockchain.',
            'contact': 'Vous pouvez nous contacter via notre formulaire sur le site ou prendre rendez-vous directement.',
            'prix': 'Nos tarifs sont adaptés à chaque projet. Contactez-nous pour un devis personnalisé.',
            'équipe': 'Notre équipe est composée d\'experts en IA, blockchain et développement.',
            'merci': 'Je vous en prie ! N\'hésitez pas si vous avez d\'autres questions.',
            'au revoir': 'Au revoir ! J\'espère avoir pu vous aider. À bientôt !',
            'aide': 'Je peux vous renseigner sur nos services d\'IA, blockchain, automatisation et bien plus encore.',
            'default': 'C\'est une excellente question ! Notre équipe d\'experts peut vous fournir une réponse détaillée. Souhaitez-vous que je vous mette en contact avec un spécialiste ?'
        };

        const lowerMessage = userMessage.toLowerCase();
        
        // Chercher une réponse correspondante
        for (const [key, response] of Object.entries(responses)) {
            if (lowerMessage.includes(key)) {
                return response;
            }
        }

        return responses.default;
    }

    async typeMessage(message, messageIndex) {
        this.isTyping = true;
        const typingElement = document.getElementById(`typing-text-${messageIndex}`);
        const indicatorElement = document.getElementById(`typing-indicator-${messageIndex}`);
        
        if (!typingElement) return;

        // Afficher l'indicateur de saisie
        indicatorElement.style.display = 'flex';
        
        // Attendre un peu avant de commencer à taper
        await this.delay(800);
        
        // Masquer l'indicateur et commencer le typing
        indicatorElement.style.display = 'none';
        
        let currentText = '';
        
        for (let i = 0; i < message.length; i++) {
            currentText += message[i];
            typingElement.innerHTML = currentText + '<span class="typing-cursor"></span>';
            
            // Scroll vers le bas pendant le typing
            this.scrollToBottom();
            
            // Délai variable selon le caractère
            let delay = this.typingSpeed;
            if (message[i] === '.') delay = 300;
            else if (message[i] === ',') delay = 200;
            else if (message[i] === ' ') delay = 30;
            
            await this.delay(delay);
        }

        // Supprimer le curseur final
        typingElement.innerHTML = currentText;
        this.isTyping = false;
    }

    scrollToBottom() {
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }

    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // Voice Recognition Setup
    setupVoiceRecognition() {
        if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            this.recognition = new SpeechRecognition();
            this.recognition.continuous = false;
            this.recognition.interimResults = false;
            this.recognition.lang = 'fr-FR';

            this.recognition.onresult = (event) => {
                const result = event.results[0][0].transcript;
                this.messageInput.value = result;
                this.validateInput();
            };

            this.recognition.onerror = (event) => {
                console.error('Speech recognition error:', event.error);
                this.stopVoiceRecording();
            };

            this.recognition.onend = () => {
                this.stopVoiceRecording();
            };
        } else {
            // Masquer le bouton vocal si non supporté
            this.voiceBtn.style.display = 'none';
        }
    }

    toggleVoiceRecording() {
        if (this.isRecording) {
            this.stopVoiceRecording();
        } else {
            this.startVoiceRecording();
        }
    }

    startVoiceRecording() {
        if (!this.recognition) return;
        
        this.isRecording = true;
        this.voiceBtn.classList.add('recording');
        this.voiceBtn.innerHTML = '<i class="fas fa-stop"></i>';
        this.recognition.start();
    }

    stopVoiceRecording() {
        if (!this.recognition) return;
        
        this.isRecording = false;
        this.voiceBtn.classList.remove('recording');
        this.voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
        this.recognition.stop();
    }

    // Méthodes publiques pour l'interaction externe
    addBotMessage(message) {
        const messageElement = this.createMessageElement('', 'bot');
        this.messagesContainer.appendChild(messageElement);
        this.scrollToBottom();
        this.typeMessage(message, this.messageCounter);
        this.messageCounter++;
    }

    showNotification() {
        if (this.notificationBadge) {
            this.notificationBadge.style.display = 'flex';
        }
    }

    clearChat() {
        this.messagesContainer.innerHTML = '';
        this.messageCounter = 0;
        this.startWelcomeMessage();
    }
}

// Initialisation du widget
document.addEventListener('DOMContentLoaded', function() {
    window.chatbot = new ChatbotWidget();
    
    // API publique pour l'interaction
    window.ChatbotAPI = {
        open: () => window.chatbot.openWidget(),
        close: () => window.chatbot.closeWidget(),
        sendMessage: (message) => window.chatbot.addBotMessage(message),
        clearChat: () => window.chatbot.clearChat(),
        showNotification: () => window.chatbot.showNotification()
    };
    
    console.log('🤖 BrainGen Chatbot Widget initialized successfully!');
});

// Gestion des erreurs globales
window.addEventListener('error', function(event) {
    console.error('Chatbot Widget Error:', event.error);
});

// Nettoyage lors du déchargement de la page
window.addEventListener('beforeunload', function() {
    if (window.chatbot && window.chatbot.recognition) {
        window.chatbot.recognition.stop();
    }
});