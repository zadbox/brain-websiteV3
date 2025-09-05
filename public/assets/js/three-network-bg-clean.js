/*
 * Three.js Comet Field Background - Clean Working Version
 * Beautiful comet effects with dynamic trails and particle systems
 * Follows memory specifications exactly
 */
(function () {
  console.log('🚀 Three.js Comet Script Loading...');
  
  const BrainThreeNetwork = {
    initialized: false,
    
    init(containerId) {
      if (this.initialized) {
        console.log('⚠️ Comet system already initialized');
        return true;
      }
      
      console.log('🌟 Initializing comet system...', containerId);
      
      const container = document.getElementById(containerId);
      if (!container) {
        console.error('❌ Container not found:', containerId);
        return false;
      }
      
      if (!window.THREE) {
        console.error('❌ Three.js not loaded');
        return false;
      }
      
      console.log('✅ Starting Three.js setup...');
      
      try {
        // Basic Three.js setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x000000, 0);
        
        // Style the canvas with enhanced visibility
        const canvas = renderer.domElement;
        canvas.style.position = 'fixed';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.zIndex = '10'; // Make it visible above other content
        canvas.style.pointerEvents = 'none';
        canvas.style.display = 'block';
        canvas.style.visibility = 'visible';
        canvas.style.opacity = '0.8'; // Slightly transparent to not overwhelm content
        
        container.appendChild(canvas);
        camera.position.z = 500;
        
        console.log('✅ Renderer setup complete');
        
        // Comet Configuration (per memory specs)
        const CONFIG = {
          COMETS: 35,
          TRAIL_LENGTH: 120, // As specified
          MIN_SPEED: 2.0,    // As specified
          MAX_SPEED: 8.0,    // As specified  
          COMET_SIZE: 12.0,  // Increased from 6.0 for better visibility
          COMET_OPACITY: 1.0, // Full opacity as specified
          TRAIL_OPACITY: 0.9, // Increased from 0.8
          SPAWN_RATE: 0.03,   // Increased spawn rate
          AREA_WIDTH: window.innerWidth * 1.2,  // 1.2x coverage as specified
          AREA_HEIGHT: window.innerHeight * 1.2,
          COLORS: [
            new THREE.Color(0xffffff), // White
            new THREE.Color(0xb7d0ff), // Light blue
            new THREE.Color(0xffd700), // Gold
            new THREE.Color(0xff69b4), // Pink
            new THREE.Color(0x00ffff), // Cyan
            new THREE.Color(0xffa500), // Orange
          ]
        };

        const comets = [];
        
        // Create comet function
        function createComet() {
          const side = Math.floor(Math.random() * 4);
          let startPos, direction;
          const margin = 200;
          
          // Spawn from screen edges
          switch(side) {
            case 0: // Top
              startPos = new THREE.Vector3(
                (Math.random() - 0.5) * CONFIG.AREA_WIDTH,
                CONFIG.AREA_HEIGHT / 2 + margin,
                (Math.random() - 0.5) * 100
              );
              direction = new THREE.Vector3(
                (Math.random() - 0.5) * 0.3,
                -1 - Math.random() * 0.5,
                0
              ).normalize();
              break;
            case 1: // Right  
              startPos = new THREE.Vector3(
                CONFIG.AREA_WIDTH / 2 + margin,
                (Math.random() - 0.5) * CONFIG.AREA_HEIGHT,
                (Math.random() - 0.5) * 100
              );
              direction = new THREE.Vector3(
                -1 - Math.random() * 0.5,
                (Math.random() - 0.5) * 0.3,
                0
              ).normalize();
              break;
            case 2: // Bottom
              startPos = new THREE.Vector3(
                (Math.random() - 0.5) * CONFIG.AREA_WIDTH,
                -CONFIG.AREA_HEIGHT / 2 - margin,
                (Math.random() - 0.5) * 100
              );
              direction = new THREE.Vector3(
                (Math.random() - 0.5) * 0.3,
                1 + Math.random() * 0.5,
                0
              ).normalize();
              break;
            case 3: // Left
              startPos = new THREE.Vector3(
                -CONFIG.AREA_WIDTH / 2 - margin,
                (Math.random() - 0.5) * CONFIG.AREA_HEIGHT,
                (Math.random() - 0.5) * 100
              );
              direction = new THREE.Vector3(
                1 + Math.random() * 0.5,
                (Math.random() - 0.5) * 0.3,
                0
              ).normalize();
              break;
          }
          
          const speed = CONFIG.MIN_SPEED + Math.random() * (CONFIG.MAX_SPEED - CONFIG.MIN_SPEED);
          const color = CONFIG.COLORS[Math.floor(Math.random() * CONFIG.COLORS.length)];
          
          // Create comet head
          const headGeo = new THREE.BufferGeometry();
          const headPos = new Float32Array([startPos.x, startPos.y, startPos.z]);
          headGeo.setAttribute('position', new THREE.BufferAttribute(headPos, 3));
          const headMat = new THREE.PointsMaterial({
            size: CONFIG.COMET_SIZE * 3, // Make comets 3x larger for visibility
            color: color,
            transparent: false, // Remove transparency for better visibility
            opacity: CONFIG.COMET_OPACITY,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
            sizeAttenuation: false // Prevent size reduction with distance
          });
          const head = new THREE.Points(headGeo, headMat);
          scene.add(head);
          
          // Create trail
          const trailPositions = new Float32Array(CONFIG.TRAIL_LENGTH * 3);
          for (let i = 0; i < CONFIG.TRAIL_LENGTH; i++) {
            trailPositions[i * 3] = startPos.x;
            trailPositions[i * 3 + 1] = startPos.y;
            trailPositions[i * 3 + 2] = startPos.z;
          }
          const trailGeo = new THREE.BufferGeometry();
          trailGeo.setAttribute('position', new THREE.BufferAttribute(trailPositions, 3));
          const trailMat = new THREE.LineBasicMaterial({
            color: color,
            transparent: false, // Remove transparency for better visibility
            opacity: CONFIG.TRAIL_OPACITY,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
            linewidth: 2 // Make trails thicker
          });
          const trail = new THREE.Line(trailGeo, trailMat);
          scene.add(trail);
          
          return {
            position: startPos.clone(),
            direction: direction,
            speed: speed,
            head: head,
            trail: trail,
            trailPositions: trailPositions,
            age: 0,
            life: 300 + Math.random() * 200
          };
        }
        
        // Initialize comets
        console.log('🌟 Creating', CONFIG.COMETS, 'comets...');
        for (let i = 0; i < CONFIG.COMETS; i++) {
          const newComet = createComet();
          comets.push(newComet);
          console.log('✨ Created comet', i + 1, 'at position:', newComet.position);
        }
        console.log('🎯 Total comets created:', comets.length);
        
        // Add bright test comet at center (as specified in memory)
        const testHeadGeo = new THREE.BufferGeometry();
        const testHeadPos = new Float32Array([0, 0, 0]);
        testHeadGeo.setAttribute('position', new THREE.BufferAttribute(testHeadPos, 3));
        const testHeadMat = new THREE.PointsMaterial({
          size: 25.0, // Even larger for visibility
          color: new THREE.Color(0xff0000), // Red as specified
          transparent: false,
          blending: THREE.AdditiveBlending,
          sizeAttenuation: false
        });
        const testHead = new THREE.Points(testHeadGeo, testHeadMat);
        scene.add(testHead);
        
        // Add a second large test comet with different color
        const testHeadGeo2 = new THREE.BufferGeometry();
        const testHeadPos2 = new Float32Array([100, 100, 0]);
        testHeadGeo2.setAttribute('position', new THREE.BufferAttribute(testHeadPos2, 3));
        const testHeadMat2 = new THREE.PointsMaterial({
          size: 30.0,
          color: new THREE.Color(0x00ff00), // Green
          transparent: false,
          blending: THREE.AdditiveBlending,
          sizeAttenuation: false
        });
        const testHead2 = new THREE.Points(testHeadGeo2, testHeadMat2);
        scene.add(testHead2);
        
        const testComet = {
          position: new THREE.Vector3(0, 0, 0),
          direction: new THREE.Vector3(1, 0, 0).normalize(),
          speed: 3,
          head: testHead,
          trail: null,
          trailPositions: null,
          age: 0,
          life: 1000
        };
        comets.push(testComet);
        
        const testComet2 = {
          position: new THREE.Vector3(100, 100, 0),
          direction: new THREE.Vector3(-1, -1, 0).normalize(),
          speed: 4,
          head: testHead2,
          trail: null,
          trailPositions: null,
          age: 0,
          life: 1000
        };
        comets.push(testComet2);
        
        console.log('🔴 Added bright test comets for visibility verification');
        
        // Animation loop
        let frame = 0;
        function animate() {
          requestAnimationFrame(animate);
          frame++;
          
          // Update comets
          for (let i = comets.length - 1; i >= 0; i--) {
            const comet = comets[i];
            comet.age++;
            
            // Move comet
            const velocity = comet.direction.clone().multiplyScalar(comet.speed);
            comet.position.add(velocity);
            
            // Update head position
            if (comet.head) {
              const headPos = comet.head.geometry.attributes.position.array;
              headPos[0] = comet.position.x;
              headPos[1] = comet.position.y;
              headPos[2] = comet.position.z;
              comet.head.geometry.attributes.position.needsUpdate = true;
            }
            
            // Update trail if exists
            if (comet.trail && comet.trailPositions) {
              const trailPos = comet.trailPositions;
              // Shift trail positions
              for (let j = CONFIG.TRAIL_LENGTH - 1; j > 0; j--) {
                trailPos[j * 3] = trailPos[(j - 1) * 3];
                trailPos[j * 3 + 1] = trailPos[(j - 1) * 3 + 1];
                trailPos[j * 3 + 2] = trailPos[(j - 1) * 3 + 2];
              }
              trailPos[0] = comet.position.x;
              trailPos[1] = comet.position.y;
              trailPos[2] = comet.position.z;
              comet.trail.geometry.attributes.position.needsUpdate = true;
            }
            
            // Remove dead comets (except test comet)
            if (comet !== testComet && (comet.age > comet.life || 
                Math.abs(comet.position.x) > CONFIG.AREA_WIDTH || 
                Math.abs(comet.position.y) > CONFIG.AREA_HEIGHT)) {
              if (comet.head) scene.remove(comet.head);
              if (comet.trail) scene.remove(comet.trail);
              comets.splice(i, 1);
            }
          }
          
          // Spawn new comets
          if (Math.random() < CONFIG.SPAWN_RATE && comets.length < CONFIG.COMETS * 1.5) {
            comets.push(createComet());
          }
          
          renderer.render(scene, camera);
          
          // Log occasional status
          if (frame % 120 === 0) {
            console.log('💫 Frame:', frame, 'Comets:', comets.length);
          }
        }
        
        // Resize handler
        window.addEventListener('resize', () => {
          camera.aspect = window.innerWidth / window.innerHeight;
          camera.updateProjectionMatrix();
          renderer.setSize(window.innerWidth, window.innerHeight);
        });
        
        animate();
        console.log('✅ Comet system initialized!');
        this.initialized = true;
        return true;
        
      } catch (error) {
        console.error('❌ Error:', error);
        return false;
      }
    }
  };

  // Only manual initialization - no auto-init to prevent conflicts
  console.log('🚀 Three.js Comet Script Ready - waiting for manual init');
  
  // Export for manual initialization
  window.BrainThreeNetwork = BrainThreeNetwork;
})();})();