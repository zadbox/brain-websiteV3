/**
 * =============================================================================
 * BRAINGENTECHNOLOGY - INTERACTIVE SCRIPT
 * Modern AI-powered website with neural network background and chatbot
 * =============================================================================
 */

class BrainGenTechnology {
    constructor() {
        this.chatbot = null;
        this.neuralNetwork = null;
        this.beamBackground = null;
        this.init();
    }

    init() {
        this.setupChatbot();
        this.setupMetricsAnimation();
        this.setupIndustrySelector();
        this.setupNeuralNetwork();
        this.setupBeamBackground();
        this.setupScrollAnimations();
    }

    // =============================================================================
    // CHATBOT FUNCTIONALITY
    // =============================================================================

    setupChatbot() {
        this.chatbot = {
            widget: document.getElementById('chatbot-widget'),
            toggle: document.getElementById('chatbot-toggle'),
            close: document.getElementById('chatbot-close'),
            messages: document.getElementById('chatbot-messages'),
            input: document.getElementById('message-input'),
            sendBtn: document.getElementById('send-btn'),
            isOpen: false,
            isTyping: false,
            typingSpeed: 40
        };

        this.bindChatbotEvents();
        this.initWelcomeMessage();
    }

    bindChatbotEvents() {
        const { toggle, close, input, sendBtn } = this.chatbot;

        toggle.addEventListener('click', () => this.toggleChatbot());
        close.addEventListener('click', () => this.closeChatbot());
        sendBtn.addEventListener('click', () => this.sendMessage());
        
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        input.addEventListener('input', () => {
            sendBtn.style.opacity = input.value.trim() ? '1' : '0.5';
        });
    }

    toggleChatbot() {
        if (this.chatbot.isOpen) {
            this.closeChatbot();
        } else {
            this.openChatbot();
        }
    }

    openChatbot() {
        this.chatbot.widget.classList.add('active');
        this.chatbot.isOpen = true;
        setTimeout(() => this.chatbot.input.focus(), 300);
    }

    closeChatbot() {
        this.chatbot.widget.classList.remove('active');
        this.chatbot.isOpen = false;
    }

    async sendMessage() {
        const { input, messages } = this.chatbot;
        const message = input.value.trim();
        
        if (!message || this.chatbot.isTyping) return;

        // Add user message
        this.addMessage(message, 'user');
        input.value = '';
        input.dispatchEvent(new Event('input'));

        // Show typing indicator
        this.showTypingIndicator();

        // Simulate AI response
        await this.delay(1000 + Math.random() * 2000);
        this.hideTypingIndicator();

        const response = this.generateResponse(message);
        await this.typeMessage(response, 'bot');
    }

    addMessage(content, type) {
        const messageElement = document.createElement('div');
        messageElement.className = `message ${type}`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = '<img src="assets/LogoBrainBlanc.png" alt="Avatar">';
        
        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        bubble.textContent = content;
        
        messageElement.appendChild(avatar);
        messageElement.appendChild(bubble);
        
        this.chatbot.messages.appendChild(messageElement);
        this.scrollToBottom();
    }

    showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'message bot';
        indicator.id = 'typing-indicator';
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = '<img src="assets/LogoBrainBlanc.png" alt="Avatar">';
        
        const typingBubble = document.createElement('div');
        typingBubble.className = 'typing-indicator';
        typingBubble.innerHTML = '<span></span><span></span><span></span>';
        
        indicator.appendChild(avatar);
        indicator.appendChild(typingBubble);
        
        this.chatbot.messages.appendChild(indicator);
        this.scrollToBottom();
    }

    hideTypingIndicator() {
        const indicator = document.getElementById('typing-indicator');
        if (indicator) {
            indicator.remove();
        }
    }

    async typeMessage(message, type) {
        this.chatbot.isTyping = true;
        
        const messageElement = document.createElement('div');
        messageElement.className = `message ${type}`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = '<img src="assets/LogoBrainBlanc.png" alt="Avatar">';
        
        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        
        messageElement.appendChild(avatar);
        messageElement.appendChild(bubble);
        
        this.chatbot.messages.appendChild(messageElement);
        this.scrollToBottom();

        // Type character by character
        for (let i = 0; i < message.length; i++) {
            bubble.textContent += message[i];
            this.scrollToBottom();
            
            const delay = message[i] === '.' ? 300 : 
                         message[i] === ',' ? 200 : 
                         message[i] === ' ' ? 30 : 
                         this.chatbot.typingSpeed;
            
            await this.delay(delay);
        }

        this.chatbot.isTyping = false;
    }

    generateResponse(message) {
        const responses = {
            'hello': 'Hello! I\'m your Brain Assistant. How can I help you today?',
            'hi': 'Hi there! What can I do for you?',
            'services': 'We offer AI Analytics, Process Automation, and ML Integration solutions.',
            'ai': 'Our AI solutions include predictive analytics, natural language processing, and computer vision.',
            'automation': 'We help streamline your workflows with intelligent automation systems.',
            'pricing': 'Our pricing is tailored to your specific needs. Would you like to schedule a consultation?',
            'contact': 'You can reach us through our contact form or schedule a demo. What works best for you?',
            'help': 'I can help you learn about our AI and automation solutions. What would you like to know?',
            'thank': 'You\'re welcome! Is there anything else I can help you with?',
            'bye': 'Goodbye! Feel free to reach out anytime you need assistance.',
            'default': 'That\'s interesting! Our AI experts can provide more detailed information. Would you like to schedule a consultation?'
        };

        const lowerMessage = message.toLowerCase();
        
        for (const [key, response] of Object.entries(responses)) {
            if (lowerMessage.includes(key)) {
                return response;
            }
        }

        return responses.default;
    }

    initWelcomeMessage() {
        setTimeout(() => {
            this.typeMessage('Hello! I\'m your Brain Assistant. How can I help you accelerate your performance with AI?', 'bot');
        }, 2000);
    }

    scrollToBottom() {
        const { messages } = this.chatbot;
        messages.scrollTop = messages.scrollHeight;
    }

    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // =============================================================================
    // METRICS ANIMATION
    // =============================================================================

    setupMetricsAnimation() {
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statValue = entry.target.querySelector('.stat-value');
                    if (statValue && !statValue.classList.contains('animated')) {
                        this.animateCounter(statValue);
                        statValue.classList.add('animated');
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.stat-item').forEach(item => {
            observer.observe(item);
        });
    }

    animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        let current = 0;
        const increment = target / 100;
        const duration = 2000;
        const stepTime = duration / 100;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, stepTime);
    }

    // =============================================================================
    // INDUSTRY SELECTOR
    // =============================================================================

    setupIndustrySelector() {
        const dropdown = document.getElementById('industry-dropdown');
        const arrow = document.querySelector('.dropdown-arrow');
        
        dropdown.addEventListener('change', (e) => {
            const selectedIndustry = e.target.value;
            if (selectedIndustry) {
                this.updateServicesForIndustry(selectedIndustry);
            }
        });

        dropdown.addEventListener('focus', () => {
            arrow.style.transform = 'translateY(-50%) rotate(180deg)';
        });

        dropdown.addEventListener('blur', () => {
            arrow.style.transform = 'translateY(-50%) rotate(0deg)';
        });
    }

    updateServicesForIndustry(industry) {
        const serviceCards = document.querySelectorAll('.service-card');
        
        // Add a subtle animation to indicate change
        serviceCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.style.transform = 'scale(1)';
                }, 150);
            }, index * 100);
        });

        // You can customize services based on industry here
        console.log(`Services updated for industry: ${industry}`);
    }

    // =============================================================================
    // NEURAL NETWORK BACKGROUND - REMOVED
    // =============================================================================

    setupNeuralNetwork() {
        // Neural network background animations have been removed
        console.log('Neural network background disabled - cube animations removed');
        return;
    }

    // =============================================================================
    // INTERACTIVE BEAM BACKGROUND - REMOVED
    // =============================================================================

    setupBeamBackground() {
        // Three.js beam background animations have been removed
        console.log('Beam background disabled - cube animations removed');
        return;
    }

    // =============================================================================
    // SCROLL ANIMATIONS
    // =============================================================================

    setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.8s ease-out forwards';
                }
            });
        }, observerOptions);

        // Observe service cards
        document.querySelectorAll('.service-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
            observer.observe(card);
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new BrainGenTechnology();
});

// Handle page visibility changes
document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        // Pause animations when page is hidden
        document.querySelectorAll('canvas').forEach(canvas => {
            canvas.style.animationPlayState = 'paused';
        });
    } else {
        // Resume animations when page is visible
        document.querySelectorAll('canvas').forEach(canvas => {
            canvas.style.animationPlayState = 'running';
        });
    }
});

// Performance monitoring
if ('performance' in window) {
    window.addEventListener('load', () => {
        const loadTime = performance.now();
        console.log(`🧠 BrainGenTechnology loaded in ${loadTime.toFixed(2)}ms`);
    });
}