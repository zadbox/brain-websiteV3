/**
 * BrainGenTechnology RAG Chat Widget
 * Advanced conversational AI widget with lead qualification
 * Optimized for business prospects and customer engagement
 */

class BrainGenRAGChatWidget {
    constructor(config = {}) {
        // Configuration
        this.config = {
            apiEndpoint: config.apiEndpoint || '/api/chat',
            qualificationEndpoint: config.qualificationEndpoint || '/api/chat/qualify',
            sessionId: config.sessionId || this.generateSessionId(),
            autoOpen: config.autoOpen || false,
            theme: config.theme || 'dark',
            position: config.position || 'bottom-right',
            welcomeMessage: config.welcomeMessage || "Hi! I'm your AI assistant from BrainGenTechnology. How can I help you explore our AI, automation, and blockchain solutions today?",
            placeholderText: config.placeholderText || "Ask me about our services...",
            maxMessageLength: config.maxMessageLength || 2000,
            typingSpeed: config.typingSpeed || 30,
            autoQualifyAfter: config.autoQualifyAfter || 5, // messages
            enableSounds: config.enableSounds || true,
            enableTypingIndicator: config.enableTypingIndicator || true,
            brandName: config.brandName || 'BrainGenTechnology'
        };

        // State management
        this.state = {
            isOpen: false,
            isTyping: false,
            messageCount: 0,
            conversationStarted: false,
            isQualified: false,
            currentUser: null,
            connectionStatus: 'connecting'
        };

        // Message history
        this.messages = [];
        
        // DOM elements
        this.container = null;
        this.chatWindow = null;
        this.messagesContainer = null;
        this.inputField = null;
        this.sendButton = null;
        
        // Initialize widget
        this.init();
    }

    /**
     * Initialize the chat widget
     */
    init() {
        this.createWidget();
        this.bindEvents();
        this.checkAPIConnection();
        
        if (this.config.autoOpen) {
            this.openChat();
        }
        
        // Show welcome message after a short delay
        setTimeout(() => {
            this.addMessage(this.config.welcomeMessage, 'bot');
        }, 1000);

        console.log('🧠 BrainGenTechnology RAG Chat Widget initialized');
    }

    /**
     * Create the chat widget HTML structure
     */
    createWidget() {
        // Create main container
        this.container = document.createElement('div');
        this.container.className = `rag-chat-widget rag-chat-widget--${this.config.theme} rag-chat-widget--${this.config.position}`;
        this.container.innerHTML = this.getWidgetHTML();

        // Add to page
        document.body.appendChild(this.container);

        // Get DOM references
        this.chatWindow = this.container.querySelector('.rag-chat-window');
        this.messagesContainer = this.container.querySelector('.rag-chat-messages');
        this.inputField = this.container.querySelector('.rag-chat-input');
        this.sendButton = this.container.querySelector('.rag-chat-send');
        this.toggleButton = this.container.querySelector('.rag-chat-toggle');
    }

    /**
     * Get the widget HTML template
     */
    getWidgetHTML() {
        return `
            <!-- Chat Toggle Button -->
            <button class="rag-chat-toggle" aria-label="Open chat">
                <svg class="rag-chat-icon rag-chat-icon--chat" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM8 11H6V9h2v2zm4 0h-2V9h2v2zm4 0h-2V9h2v2z"/>
                </svg>
                <svg class="rag-chat-icon rag-chat-icon--close" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                </svg>
                <div class="rag-chat-notification" style="display: none;">1</div>
            </button>

            <!-- Chat Window -->
            <div class="rag-chat-window" style="display: none;">
                <!-- Header -->
                <div class="rag-chat-header">
                    <div class="rag-chat-header-info">
                        <div class="rag-chat-avatar">
                            <img src="/assets/LogoBrainBlanc.png" alt="${this.config.brandName}" />
                        </div>
                        <div class="rag-chat-title">
                            <h4>${this.config.brandName}</h4>
                            <div class="rag-chat-status">
                                <span class="rag-chat-status-indicator"></span>
                                <span class="rag-chat-status-text">AI Assistant</span>
                            </div>
                        </div>
                    </div>
                    <div class="rag-chat-actions">
                        <button class="rag-chat-minimize" aria-label="Minimize chat">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 19h12v2H6z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="rag-chat-messages" id="rag-chat-messages-${this.config.sessionId}">
                    <!-- Messages will be inserted here -->
                </div>

                <!-- Typing Indicator -->
                <div class="rag-chat-typing" style="display: none;">
                    <div class="rag-chat-typing-avatar">
                        <img src="/assets/LogoBrainBlanc.png" alt="AI" />
                    </div>
                    <div class="rag-chat-typing-content">
                        <div class="rag-chat-typing-dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                <div class="rag-chat-input-area">
                    <div class="rag-chat-input-wrapper">
                        <div class="rag-chat-input-container">
                            <div class="rag-chat-input-field">
                                <textarea 
                                    class="rag-chat-input" 
                                    placeholder="${this.config.placeholderText}"
                                    maxlength="${this.config.maxMessageLength}"
                                    rows="1"
                                ></textarea>
                                <div class="rag-chat-input-actions">
                                    <button class="rag-chat-voice-btn" aria-label="Voice input" title="Voice input">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 14c1.66 0 2.99-1.34 2.99-3L15 5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3zm5.3-3c0 3-2.54 5.1-5.3 5.1S6.7 14 6.7 11H5c0 3.41 2.72 6.23 6 6.72V21h2v-3.28c3.28-.48 6-3.3 6-6.72h-1.7z"/>
                                        </svg>
                                    </button>
                                    <button class="rag-chat-send" disabled aria-label="Send message" title="Send message">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M2,21L23,12L2,3V10L17,12L2,14V21Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="rag-chat-input-suggestions" style="display: none;">
                                <button class="rag-chat-suggestion" data-suggestion="What AI services do you offer?">
                                    💡 What AI services do you offer?
                                </button>
                                <button class="rag-chat-suggestion" data-suggestion="Tell me about Brain Assistant">
                                    🤖 Tell me about Brain Assistant
                                </button>
                                <button class="rag-chat-suggestion" data-suggestion="How can AI help my business?">
                                    🚀 How can AI help my business?
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="rag-chat-footer">
                        <div class="rag-chat-powered">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9l-5 4.87L18.18 22 12 18.75 5.82 22 7 13.87 2 9l6.91-.74L12 2z"/>
                            </svg>
                            <span>Powered by ${this.config.brandName} AI</span>
                        </div>
                        <div class="rag-chat-status-bar">
                            <span class="rag-chat-character-count">0/${this.config.maxMessageLength}</span>
                            <div class="rag-chat-typing-status" style="display: none;">
                                <span>AI is thinking...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Bind event listeners
     */
    bindEvents() {
        // Toggle chat
        this.toggleButton.addEventListener('click', () => this.toggleChat());
        
        // Minimize chat
        const minimizeButton = this.container.querySelector('.rag-chat-minimize');
        minimizeButton.addEventListener('click', () => this.closeChat());

        // Send message
        this.sendButton.addEventListener('click', () => this.sendMessage());
        
        // Input field events
        this.inputField.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        this.inputField.addEventListener('input', () => {
            this.handleInputChange();
        });

        // Auto-resize textarea
        this.inputField.addEventListener('input', () => {
            this.autoResizeTextarea();
        });

        // Click outside to close (optional)
        document.addEventListener('click', (e) => {
            if (this.state.isOpen && !this.container.contains(e.target)) {
                // Optional: Close on outside click
                // this.closeChat();
            }
        });

        // Page visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseTypingAnimation();
            }
        });
    }

    /**
     * Check API connection status
     */
    async checkAPIConnection() {
        try {
            const response = await fetch('/api/chat/health', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                }
            });

            if (response.ok) {
                this.updateConnectionStatus('connected');
            } else {
                this.updateConnectionStatus('error');
            }
        } catch (error) {
            console.warn('RAG Chat Widget: API connection check failed', error);
            this.updateConnectionStatus('error');
        }
    }

    /**
     * Update connection status indicator
     */
    updateConnectionStatus(status) {
        this.state.connectionStatus = status;
        const statusElement = this.container.querySelector('.rag-chat-status-text');
        const indicator = this.container.querySelector('.rag-chat-status-indicator');
        
        switch (status) {
            case 'connected':
                statusElement.textContent = 'Online';
                indicator.className = 'rag-chat-status-indicator rag-chat-status-indicator--online';
                break;
            case 'connecting':
                statusElement.textContent = 'Connecting...';
                indicator.className = 'rag-chat-status-indicator rag-chat-status-indicator--connecting';
                break;
            case 'error':
                statusElement.textContent = 'Offline';
                indicator.className = 'rag-chat-status-indicator rag-chat-status-indicator--offline';
                break;
        }
    }

    /**
     * Toggle chat window
     */
    toggleChat() {
        if (this.state.isOpen) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    /**
     * Open chat window
     */
    openChat() {
        this.state.isOpen = true;
        this.chatWindow.style.display = 'flex';
        this.container.classList.add('rag-chat-widget--open');
        this.inputField.focus();
        
        // Resume audio context after user interaction
        this.initAudioContext();
        
        // Track page visit
        this.trackPageVisit();
        
        // Scroll to bottom
        this.scrollToBottom();
        
        // Hide notification
        const notification = this.container.querySelector('.rag-chat-notification');
        notification.style.display = 'none';
    }

    /**
     * Close chat window
     */
    closeChat() {
        this.state.isOpen = false;
        this.chatWindow.style.display = 'none';
        this.container.classList.remove('rag-chat-widget--open');
    }

    /**
     * Handle input field changes
     */
    handleInputChange() {
        const value = this.inputField.value.trim();
        const length = value.length;
        
        // Update character count
        const counter = this.container.querySelector('.rag-chat-character-count');
        counter.textContent = `${length}/${this.config.maxMessageLength}`;
        
        // Enable/disable send button
        this.sendButton.disabled = length === 0 || length > this.config.maxMessageLength;
        
        // Update button state
        if (this.sendButton.disabled) {
            this.sendButton.classList.add('rag-chat-send--disabled');
        } else {
            this.sendButton.classList.remove('rag-chat-send--disabled');
        }
    }

    /**
     * Auto-resize textarea based on content
     */
    autoResizeTextarea() {
        this.inputField.style.height = 'auto';
        const maxHeight = 120; // Maximum height in pixels
        const newHeight = Math.min(this.inputField.scrollHeight, maxHeight);
        this.inputField.style.height = newHeight + 'px';
    }

    /**
     * Send message to RAG API
     */
    async sendMessage() {
        const message = this.inputField.value.trim();
        
        if (!message || this.state.isTyping) {
            return;
        }

        // Initialize audio context after user interaction
        this.initAudioContext();

        // Add user message to chat
        this.addMessage(message, 'user');
        
        // Clear input
        this.inputField.value = '';
        this.handleInputChange();
        this.autoResizeTextarea();
        
        // Show typing indicator
        this.showTypingIndicator();
        
        try {
            // Send to API
            const response = await fetch(this.config.apiEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({
                    message: message,
                    session_id: this.config.sessionId
                })
            });

            const data = await response.json();
            
            // Hide typing indicator
            this.hideTypingIndicator();
            
            if (data.success) {
                // Add bot response with typing animation
                await this.addMessage(data.answer, 'bot', {
                    sources: data.sources || [],
                    animated: true
                });
                
                // Update connection status
                this.updateConnectionStatus('connected');
                
                // Check if we should auto-qualify
                this.checkAutoQualification();
                
            } else {
                // Handle error response
                await this.addMessage(
                    data.answer || 'I apologize, but I encountered an issue. Please try again.',
                    'bot',
                    { isError: true }
                );
            }
            
        } catch (error) {
            console.error('Chat API Error:', error);
            this.hideTypingIndicator();
            this.updateConnectionStatus('error');
            
            // Show error message
            await this.addMessage(
                'I\'m sorry, but I\'m having trouble connecting right now. Please check your internet connection and try again.',
                'bot',
                { isError: true }
            );
        }
    }

    /**
     * Add message to chat
     */
    async addMessage(content, sender, options = {}) {
        const messageId = `msg_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
        const message = {
            id: messageId,
            content: content,
            sender: sender,
            timestamp: new Date(),
            ...options
        };

        // Add to message history
        this.messages.push(message);
        this.state.messageCount++;

        // Create message element
        const messageElement = this.createMessageElement(message);
        this.messagesContainer.appendChild(messageElement);

        // Animate message appearance
        setTimeout(() => {
            messageElement.classList.add('rag-chat-message--visible');
        }, 50);

        // If bot message with animation
        if (sender === 'bot' && options.animated) {
            await this.animateTyping(messageElement, content);
        }

        // Scroll to bottom
        this.scrollToBottom();

        // Play notification sound for bot messages
        if (sender === 'bot' && this.config.enableSounds && !this.state.isOpen) {
            this.playNotificationSound();
        }

        // Show notification if chat is closed
        if (sender === 'bot' && !this.state.isOpen) {
            this.showNotification();
        }
    }

    /**
     * Create message HTML element
     */
    createMessageElement(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `rag-chat-message rag-chat-message--${message.sender}`;
        messageDiv.setAttribute('data-message-id', message.id);

        const timestamp = message.timestamp.toLocaleTimeString([], { 
            hour: '2-digit', 
            minute: '2-digit' 
        });

        let sourcesHTML = '';
        if (message.sources && message.sources.length > 0) {
            sourcesHTML = `
                <div class="rag-chat-sources">
                    <details>
                        <summary>Sources (${message.sources.length})</summary>
                        <ul>
                            ${message.sources.map(source => `
                                <li>
                                    <strong>${source.source || 'Document'}</strong>
                                    <p>${source.content}</p>
                                </li>
                            `).join('')}
                        </ul>
                    </details>
                </div>
            `;
        }

        messageDiv.innerHTML = `
            ${message.sender === 'bot' ? `
                <div class="rag-chat-message-avatar">
                    <img src="/assets/LogoBrainBlanc.png" alt="AI Assistant" />
                </div>
            ` : ''}
            <div class="rag-chat-message-content">
                <div class="rag-chat-message-bubble ${message.isError ? 'rag-chat-message-bubble--error' : ''}">
                    <div class="rag-chat-message-text">${this.formatMessageContent(message.content)}</div>
                    ${sourcesHTML}
                </div>
                <div class="rag-chat-message-time">${timestamp}</div>
            </div>
        `;

        return messageDiv;
    }

    /**
     * Format message content (support basic markdown)
     */
    formatMessageContent(content) {
        return content
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`(.*?)`/g, '<code>$1</code>')
            .replace(/\n/g, '<br>');
    }

    /**
     * Animate typing effect for bot messages
     */
    async animateTyping(messageElement, content) {
        if (!this.config.enableTypingIndicator) {
            return;
        }

        const textElement = messageElement.querySelector('.rag-chat-message-text');
        const formattedContent = this.formatMessageContent(content);
        
        textElement.innerHTML = '';
        
        // Simple typing animation
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = formattedContent;
        const plainText = tempDiv.textContent || tempDiv.innerText || '';
        
        for (let i = 0; i <= plainText.length; i++) {
            await new Promise(resolve => setTimeout(resolve, this.config.typingSpeed));
            textElement.innerHTML = this.formatMessageContent(plainText.substring(0, i));
            this.scrollToBottom();
        }
    }

    /**
     * Show typing indicator
     */
    showTypingIndicator() {
        this.state.isTyping = true;
        const typingElement = this.container.querySelector('.rag-chat-typing');
        typingElement.style.display = 'flex';
        this.scrollToBottom();
    }

    /**
     * Hide typing indicator
     */
    hideTypingIndicator() {
        this.state.isTyping = false;
        const typingElement = this.container.querySelector('.rag-chat-typing');
        typingElement.style.display = 'none';
    }

    /**
     * Pause typing animation
     */
    pauseTypingAnimation() {
        // Implementation for pausing animations when tab is not visible
    }

    /**
     * Check if auto-qualification should trigger
     */
    checkAutoQualification() {
        if (this.state.isQualified || this.state.messageCount < this.config.autoQualifyAfter) {
            return;
        }

        // Auto-qualify lead after enough messages
        setTimeout(() => {
            this.qualifyLead();
        }, 2000);
    }

    /**
     * Qualify lead based on conversation
     */
    async qualifyLead() {
        if (this.state.isQualified) {
            return;
        }

        try {
            const response = await fetch(this.config.qualificationEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({
                    session_id: this.config.sessionId
                })
            });

            const data = await response.json();
            
            if (data.success && data.qualification) {
                this.state.isQualified = true;
                this.handleQualificationResult(data.qualification);
            }
            
        } catch (error) {
            console.warn('Lead qualification failed:', error);
        }
    }

    /**
     * Handle qualification results
     */
    handleQualificationResult(qualification) {
        console.log('Lead qualification result:', qualification);
        
        // Store qualification data
        this.state.qualification = qualification;
        
        // Trigger custom events for external integrations
        document.dispatchEvent(new CustomEvent('ragChatLeadQualified', {
            detail: {
                sessionId: this.config.sessionId,
                qualification: qualification
            }
        }));
        
        // Optional: Show qualification feedback to user
        if (qualification.sales_ready) {
            setTimeout(() => {
                this.addMessage(
                    "I see you're interested in our enterprise solutions! Would you like to schedule a consultation with one of our specialists?",
                    'bot'
                );
            }, 3000);
        }
    }

    /**
     * Track page visits for context
     */
    trackPageVisit() {
        const currentPage = window.location.pathname;
        const visitTime = new Date().toISOString();
        
        // Store in session storage
        let pageVisits = JSON.parse(sessionStorage.getItem('rag_chat_pages') || '[]');
        pageVisits.push({ page: currentPage, time: visitTime });
        
        // Keep only last 10 page visits
        if (pageVisits.length > 10) {
            pageVisits = pageVisits.slice(-10);
        }
        
        sessionStorage.setItem('rag_chat_pages', JSON.stringify(pageVisits));
    }

    /**
     * Show notification for new messages
     */
    showNotification() {
        const notification = this.container.querySelector('.rag-chat-notification');
        notification.style.display = 'block';
        notification.classList.add('rag-chat-notification--bounce');
        
        setTimeout(() => {
            notification.classList.remove('rag-chat-notification--bounce');
        }, 1000);
    }

    /**
     * Initialize audio context after user interaction
     */
    async initAudioContext() {
        if (!this.config.enableSounds) return;
        
        try {
            if (!this.audioContext) {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (AudioContextClass) {
                    this.audioContext = new AudioContextClass();
                }
            }
            
            if (this.audioContext && this.audioContext.state === 'suspended') {
                await this.audioContext.resume();
            }
        } catch (error) {
            console.warn('Could not initialize audio context:', error.message);
        }
    }

    /**
     * Play notification sound
     */
    playNotificationSound() {
        if (!this.config.enableSounds) return;
        
        try {
            // Only create AudioContext after user interaction
            if (!this.audioContext) {
                const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (AudioContextClass) {
                    this.audioContext = new AudioContextClass();
                }
            }
            
            // Check if context exists and is not suspended
            if (!this.audioContext || this.audioContext.state === 'suspended') {
                // Skip sound if no user interaction yet or context not available
                return;
            }
            
            // Simple notification sound
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);
            
            oscillator.frequency.value = 800;
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0.1, this.audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.3);
            
            oscillator.start(this.audioContext.currentTime);
            oscillator.stop(this.audioContext.currentTime + 0.3);
        } catch (error) {
            // Silently fail if audio context creation fails
            console.warn('Audio notification not available:', error.message);
        }
    }

    /**
     * Scroll chat to bottom
     */
    scrollToBottom() {
        setTimeout(() => {
            this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
        }, 50);
    }

    /**
     * Generate unique session ID
     */
    generateSessionId() {
        return `rag_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
    }

    /**
     * Get CSRF token for Laravel
     */
    getCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }

    /**
     * Public API methods
     */
    
    // Open chat programmatically
    open() {
        this.openChat();
    }
    
    // Close chat programmatically
    close() {
        this.closeChat();
    }
    
    // Send message programmatically
    async sendProgrammaticMessage(message) {
        this.inputField.value = message;
        await this.sendMessage();
    }
    
    // Get conversation history
    getConversationHistory() {
        return this.messages;
    }
    
    // Get qualification status
    getQualificationStatus() {
        return {
            isQualified: this.state.isQualified,
            qualification: this.state.qualification
        };
    }
    
    // Clear conversation
    clearConversation() {
        this.messages = [];
        this.messagesContainer.innerHTML = '';
        this.state.messageCount = 0;
        this.state.isQualified = false;
        this.state.qualification = null;
    }
    
    // Destroy widget
    destroy() {
        if (this.container && this.container.parentNode) {
            this.container.parentNode.removeChild(this.container);
        }
    }
}

// Auto-initialize if config is provided in window
if (window.ragChatConfig) {
    document.addEventListener('DOMContentLoaded', () => {
        window.ragChatWidget = new BrainGenRAGChatWidget(window.ragChatConfig);
    });
}

// Export for manual initialization
window.BrainGenRAGChatWidget = BrainGenRAGChatWidget;