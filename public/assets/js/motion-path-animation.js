/**
 * Motion Path Animation System
 * Recreates anime.js functionality for SVG motion paths
 * Creates text paths and animates objects along them
 */

class MotionPathAnimation {
    constructor() {
        this.animations = new Map();
        this.paths = new Map();
    }

    // Create drawable SVG paths (like svg.createDrawable)
    createDrawable(selector) {
        const elements = typeof selector === 'string' 
            ? document.querySelectorAll(selector) 
            : [selector];
        
        return Array.from(elements).map(element => {
            const totalLength = element.getTotalLength();
            
            // Set initial state
            element.style.strokeDasharray = totalLength;
            element.style.strokeDashoffset = totalLength;
            
            // Create proxy with draw property
            return new Proxy(element, {
                set(target, property, value) {
                    if (property === 'draw') {
                        const [start, end] = value.split(' ').map(Number);
                        const drawLength = totalLength * (end - start);
                        const offset = totalLength * (1 - end);
                        
                        target.style.strokeDasharray = drawLength + ' ' + totalLength;
                        target.style.strokeDashoffset = offset;
                        
                        return true;
                    }
                    return Reflect.set(target, property, value);
                },
                get(target, property) {
                    if (property === 'draw') {
                        return target._currentDraw || '0 0';
                    }
                    return Reflect.get(target, property);
                }
            });
        });
    }

    // Create motion path data (like svg.createMotionPath)
    createMotionPath(pathSelector) {
        const pathElement = typeof pathSelector === 'string' 
            ? document.querySelector(pathSelector) 
            : pathSelector;
        
        if (!pathElement) {
            console.error('Path element not found');
            return {};
        }

        const totalLength = pathElement.getTotalLength();
        const pathData = [];
        
        // Sample points along the path for motion
        for (let i = 0; i <= 100; i++) {
            const point = pathElement.getPointAtLength((i / 100) * totalLength);
            pathData.push({
                x: point.x,
                y: point.y,
                progress: i / 100
            });
        }

        return {
            // Return transform properties for animation
            translateX: (progress) => {
                const index = Math.floor(progress * (pathData.length - 1));
                return pathData[index]?.x || 0;
            },
            translateY: (progress) => {
                const index = Math.floor(progress * (pathData.length - 1));
                return pathData[index]?.y || 0;
            },
            pathData: pathData
        };
    }

    // Animation function (like anime.js animate)
    animate(target, options) {
        const elements = typeof target === 'string' 
            ? document.querySelectorAll(target) 
            : Array.isArray(target) ? target : [target];

        elements.forEach((element, elementIndex) => {
            const animation = {
                element: element,
                options: {
                    duration: 3000,
                    ease: 'linear',
                    loop: false,
                    delay: 0,
                    ...options
                },
                startTime: null,
                isRunning: false
            };

            // Handle staggered delays
            if (options.delay && typeof options.delay === 'function') {
                animation.options.delay = options.delay(elementIndex);
            }

            this.startAnimation(animation);
        });
    }

    startAnimation(animation) {
        const { element, options } = animation;
        
        setTimeout(() => {
            animation.startTime = performance.now();
            animation.isRunning = true;
            
            const animateFrame = (currentTime) => {
                if (!animation.isRunning) return;
                
                const elapsed = currentTime - animation.startTime;
                let progress = elapsed / options.duration;
                
                // Apply easing
                progress = this.applyEasing(Math.min(progress, 1), options.ease);
                
                // Apply animations based on options
                if (options.draw && element.draw !== undefined) {
                    // Handle drawable animation
                    const [startDraw, endDraw] = options.draw;
                    const currentStart = startDraw + (endDraw - startDraw) * progress;
                    element.draw = `0 ${currentStart}`;
                }
                
                // Handle motion path animation
                if (options.translateX || options.translateY) {
                    const x = typeof options.translateX === 'function' 
                        ? options.translateX(progress) 
                        : (options.translateX || 0);
                    const y = typeof options.translateY === 'function' 
                        ? options.translateY(progress) 
                        : (options.translateY || 0);
                    
                    element.style.transform = `translate(${x}px, ${y}px)`;
                }
                
                // Handle opacity
                if (options.opacity !== undefined) {
                    const startOpacity = parseFloat(getComputedStyle(element).opacity) || 0;
                    const targetOpacity = Array.isArray(options.opacity) ? options.opacity[1] : options.opacity;
                    element.style.opacity = startOpacity + (targetOpacity - startOpacity) * progress;
                }
                
                // Handle scale
                if (options.scale !== undefined) {
                    const scale = Array.isArray(options.scale) 
                        ? options.scale[0] + (options.scale[1] - options.scale[0]) * progress
                        : options.scale;
                    element.style.transform += ` scale(${scale})`;
                }
                
                if (progress < 1) {
                    requestAnimationFrame(animateFrame);
                } else {
                    // Animation complete
                    animation.isRunning = false;
                    
                    if (options.loop) {
                        setTimeout(() => {
                            this.startAnimation(animation);
                        }, options.loopDelay || 0);
                    }
                    
                    if (options.complete) {
                        options.complete();
                    }
                }
            };
            
            requestAnimationFrame(animateFrame);
        }, options.delay || 0);
    }

    applyEasing(t, ease) {
        const easingFunctions = {
            linear: t => t,
            easeInQuad: t => t * t,
            easeOutQuad: t => 1 - (1 - t) * (1 - t),
            easeInOutQuad: t => t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2,
            easeInCubic: t => t * t * t,
            easeOutCubic: t => 1 - Math.pow(1 - t, 3),
            easeInOutCubic: t => t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2
        };
        
        return (easingFunctions[ease] || easingFunctions.linear)(t);
    }

    // Stagger function for delays
    stagger(delay, options = {}) {
        return (index) => {
            const base = options.start || 0;
            const direction = options.direction || 'normal';
            const from = options.from || 'first';
            
            if (direction === 'reverse') {
                return base + delay * (options.total - index - 1);
            }
            
            return base + delay * index;
        };
    }

    // Create text paths for letters
    createTextPath(text, options = {}) {
        const {
            fontSize = 100,
            letterSpacing = 20,
            startX = 50,
            startY = 100,
            style = 'modern'
        } = options;

        let currentX = startX;
        const paths = [];

        for (let i = 0; i < text.length; i++) {
            const char = text[i].toUpperCase();
            
            if (char === ' ') {
                currentX += letterSpacing * 1.5;
                continue;
            }
            
            const letterPath = this.getLetterPath(char, currentX, startY, fontSize, style);
            if (letterPath) {
                paths.push({
                    letter: char,
                    path: letterPath,
                    x: currentX,
                    y: startY
                });
            }
            
            currentX += this.getLetterWidth(char, fontSize) + letterSpacing;
        }

        return paths;
    }

    getLetterPath(letter, x, y, size, style) {
        const scale = size / 100;
        
        // Modern style letter paths
        const letterPaths = {
            'B': `M ${x} ${y} L ${x} ${y - 80*scale} M ${x} ${y - 80*scale} L ${x + 40*scale} ${y - 80*scale} Q ${x + 60*scale} ${y - 80*scale} ${x + 60*scale} ${y - 60*scale} Q ${x + 60*scale} ${y - 40*scale} ${x + 40*scale} ${y - 40*scale} L ${x} ${y - 40*scale} M ${x + 40*scale} ${y - 40*scale} Q ${x + 60*scale} ${y - 40*scale} ${x + 60*scale} ${y - 20*scale} Q ${x + 60*scale} ${y} ${x + 40*scale} ${y} L ${x} ${y}`,
            
            'R': `M ${x} ${y} L ${x} ${y - 80*scale} M ${x} ${y - 80*scale} L ${x + 40*scale} ${y - 80*scale} Q ${x + 60*scale} ${y - 80*scale} ${x + 60*scale} ${y - 60*scale} Q ${x + 60*scale} ${y - 40*scale} ${x + 40*scale} ${y - 40*scale} L ${x} ${y - 40*scale} M ${x + 40*scale} ${y - 40*scale} L ${x + 60*scale} ${y}`,
            
            'A': `M ${x} ${y} L ${x + 30*scale} ${y - 80*scale} L ${x + 60*scale} ${y} M ${x + 15*scale} ${y - 30*scale} L ${x + 45*scale} ${y - 30*scale}`,
            
            'I': `M ${x} ${y - 80*scale} L ${x + 40*scale} ${y - 80*scale} M ${x + 20*scale} ${y - 80*scale} L ${x + 20*scale} ${y} M ${x} ${y} L ${x + 40*scale} ${y}`,
            
            'N': `M ${x} ${y} L ${x} ${y - 80*scale} L ${x + 50*scale} ${y} L ${x + 50*scale} ${y - 80*scale}`,
            
            'G': `M ${x + 50*scale} ${y - 80*scale} Q ${x} ${y - 80*scale} ${x} ${y - 40*scale} Q ${x} ${y} ${x + 50*scale} ${y} L ${x + 50*scale} ${y - 30*scale} L ${x + 30*scale} ${y - 30*scale}`,
            
            'E': `M ${x} ${y} L ${x} ${y - 80*scale} M ${x} ${y - 80*scale} L ${x + 50*scale} ${y - 80*scale} M ${x} ${y - 40*scale} L ${x + 40*scale} ${y - 40*scale} M ${x} ${y} L ${x + 50*scale} ${y}`,
            
            'T': `M ${x} ${y - 80*scale} L ${x + 60*scale} ${y - 80*scale} M ${x + 30*scale} ${y - 80*scale} L ${x + 30*scale} ${y}`,
            
            'C': `M ${x + 50*scale} ${y - 80*scale} Q ${x} ${y - 80*scale} ${x} ${y - 40*scale} Q ${x} ${y} ${x + 50*scale} ${y}`,
            
            'H': `M ${x} ${y} L ${x} ${y - 80*scale} M ${x + 50*scale} ${y} L ${x + 50*scale} ${y - 80*scale} M ${x} ${y - 40*scale} L ${x + 50*scale} ${y - 40*scale}`,
            
            'O': `M ${x} ${y - 40*scale} Q ${x} ${y - 80*scale} ${x + 25*scale} ${y - 80*scale} Q ${x + 50*scale} ${y - 80*scale} ${x + 50*scale} ${y - 40*scale} Q ${x + 50*scale} ${y} ${x + 25*scale} ${y} Q ${x} ${y} ${x} ${y - 40*scale}`,
            
            'L': `M ${x} ${y} L ${x} ${y - 80*scale} M ${x} ${y} L ${x + 50*scale} ${y}`,
            
            'Y': `M ${x} ${y - 80*scale} L ${x + 25*scale} ${y - 40*scale} L ${x + 50*scale} ${y - 80*scale} M ${x + 25*scale} ${y - 40*scale} L ${x + 25*scale} ${y}`
        };
        
        return letterPaths[letter] || '';
    }

    getLetterWidth(letter, size) {
        const scale = size / 100;
        const widths = {
            'B': 60 * scale, 'R': 60 * scale, 'A': 60 * scale, 'I': 40 * scale, 'N': 50 * scale,
            'G': 50 * scale, 'E': 50 * scale, 'T': 60 * scale, 'C': 50 * scale, 'H': 50 * scale,
            'O': 50 * scale, 'L': 50 * scale, 'Y': 50 * scale
        };
        return widths[letter] || 50 * scale;
    }

    // Create complete path for entire text
    createCompletePath(text, options = {}) {
        const paths = this.createTextPath(text, options);
        let combinedPath = '';
        
        paths.forEach(({path}) => {
            combinedPath += (combinedPath ? ' M ' : '') + path.replace(/^M /, '');
        });
        
        return combinedPath;
    }

    // Main animation function (like anime.js animate)
    animate(target, options = {}) {
        const elements = typeof target === 'string' 
            ? document.querySelectorAll(target) 
            : Array.isArray(target) ? target : [target];

        const animation = {
            elements: elements,
            options: {
                duration: 3000,
                ease: 'linear',
                loop: false,
                delay: 0,
                ...options
            },
            startTime: null,
            isRunning: false
        };

        // Start animation
        this.startMotionAnimation(animation);
        
        return animation; // Return animation object for control
    }

    startMotionAnimation(animation) {
        const { elements, options } = animation;
        
        elements.forEach((element, index) => {
            const elementDelay = typeof options.delay === 'function' 
                ? options.delay(index) 
                : options.delay || 0;
                
            setTimeout(() => {
                animation.startTime = performance.now();
                animation.isRunning = true;
                
                const animateFrame = (currentTime) => {
                    if (!animation.isRunning) return;
                    
                    const elapsed = currentTime - animation.startTime;
                    let progress = elapsed / options.duration;
                    
                    // Apply easing
                    progress = this.applyEasing(Math.min(progress, 1), options.ease);
                    
                    // Apply transformations
                    this.applyAnimationFrame(element, progress, options);
                    
                    if (progress < 1) {
                        requestAnimationFrame(animateFrame);
                    } else {
                        // Animation complete
                        animation.isRunning = false;
                        
                        if (options.loop) {
                            setTimeout(() => {
                                this.startMotionAnimation(animation);
                            }, options.loopDelay || 0);
                        }
                        
                        if (options.complete) {
                            options.complete();
                        }
                    }
                };
                
                requestAnimationFrame(animateFrame);
            }, elementDelay);
        });
    }

    applyAnimationFrame(element, progress, options) {
        let transform = '';
        
        // Handle motion path
        if (options.translateX || options.translateY) {
            const x = typeof options.translateX === 'function' 
                ? options.translateX(progress) 
                : options.translateX || 0;
            const y = typeof options.translateY === 'function' 
                ? options.translateY(progress) 
                : options.translateY || 0;
            
            transform += `translate(${x}px, ${y}px)`;
        }
        
        // Handle scale
        if (options.scale !== undefined) {
            const scale = Array.isArray(options.scale) 
                ? options.scale[0] + (options.scale[1] - options.scale[0]) * progress
                : options.scale;
            transform += ` scale(${scale})`;
        }
        
        // Handle rotation
        if (options.rotate !== undefined) {
            const rotation = Array.isArray(options.rotate) 
                ? options.rotate[0] + (options.rotate[1] - options.rotate[0]) * progress
                : options.rotate * progress;
            transform += ` rotate(${rotation}deg)`;
        }
        
        if (transform) {
            element.style.transform = transform;
        }
        
        // Handle draw property for SVG paths
        if (options.draw && element.draw !== undefined) {
            const [startVal, endVal] = Array.isArray(options.draw) ? options.draw : [0, options.draw];
            const currentVal = startVal + (endVal - startVal) * progress;
            element.draw = `0 ${currentVal}`;
        }
        
        // Handle opacity
        if (options.opacity !== undefined) {
            const opacity = Array.isArray(options.opacity) 
                ? options.opacity[0] + (options.opacity[1] - options.opacity[0]) * progress
                : options.opacity;
            element.style.opacity = opacity;
        }
    }

    applyEasing(t, ease) {
        const easingFunctions = {
            linear: t => t,
            easeInQuad: t => t * t,
            easeOutQuad: t => 1 - (1 - t) * (1 - t),
            easeInOutQuad: t => t < 0.5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2,
            easeInCubic: t => t * t * t,
            easeOutCubic: t => 1 - Math.pow(1 - t, 3),
            easeInOutCubic: t => t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2
        };
        
        return (easingFunctions[ease] || easingFunctions.linear)(t);
    }

    // Stagger utility
    stagger(delay, options = {}) {
        return this.stagger.bind(this, delay, options);
    }
}

// Create global instance
const motionPath = new MotionPathAnimation();

// Export global functions to match anime.js API
window.svg = {
    createDrawable: (selector) => motionPath.createDrawable(selector),
    createMotionPath: (pathSelector) => motionPath.createMotionPath(pathSelector)
};

window.animate = (target, options) => motionPath.animate(target, options);
window.stagger = (delay, options) => motionPath.stagger(delay, options);

// Export the class for custom usage
window.MotionPathAnimation = MotionPathAnimation;