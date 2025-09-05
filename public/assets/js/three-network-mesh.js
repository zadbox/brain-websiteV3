/*
 * Three.js White Particles with Magnetic Interaction
 * Small white points (+ some fixed) that gently react to the cursor
 */
(function () {
  console.log('🌌 Three.js Magnetic Points – init');
  
  const BrainThreeNetwork = {
    initialized: false,
    
    init(containerId) {
      if (this.initialized) {
        console.log('⚠️ Comet system already initialized');
        return true;
      }
      
      console.log('🌟 Initializing magnetic particle field...', containerId);
      
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
        
        // Style the canvas for background effect
        const canvas = renderer.domElement;
        canvas.style.position = 'fixed';
        canvas.style.top = '0';
        canvas.style.left = '0';
        canvas.style.width = '100%';
        canvas.style.height = '100%';
        canvas.style.zIndex = '-1'; // Put behind content
        canvas.style.pointerEvents = 'none';
        canvas.style.display = 'block';
        canvas.style.visibility = 'visible';
        // Make stars fully visible
        canvas.style.opacity = '1';
        
        container.appendChild(canvas);
        camera.position.z = 500;
        
        console.log('✅ Renderer setup complete');
        
        // Enhanced magnetic white particles config for better visibility
        const CFG = {
          COUNT: Math.max(200, Math.min(400, Math.floor((window.innerWidth * window.innerHeight) / 12000))), // More particles
          SIZE: 4.5,      // Increased from 2.6 for much better visibility
          SPEED: 0.25,
          FIXED_RATIO: 0.25,
          MAG_RADIUS: 160,
          MAG_STRENGTH: 0.55,
          SWIRL: 0.06,
          FRICTION: 0.995,
          MAX_SPEED: 1.4,
          COLOR: 0xffffff
        };

        // Enhanced soft circular texture for better visibility
        function makeDotTexture(){
          const c=document.createElement('canvas'); c.width=c.height=64; const g=c.getContext('2d');
          const grd=g.createRadialGradient(32,32,0,32,32,32);
          // Enhanced gradient for better visibility
          grd.addColorStop(0.0,'rgba(255,255,255,1)');
          grd.addColorStop(0.3,'rgba(255,255,255,0.9)');
          grd.addColorStop(0.7,'rgba(255,255,255,0.4)');
          grd.addColorStop(1.0,'rgba(255,255,255,0)');
          g.fillStyle=grd; g.fillRect(0,0,64,64);
          const t=new THREE.CanvasTexture(c); t.minFilter=THREE.LinearFilter; t.magFilter=THREE.LinearFilter; t.generateMipmaps=false; return t;
        }
        const dotTex = makeDotTexture();

        // Particles (Points)
        const positions = new Float32Array(CFG.COUNT * 3);
        const velocities = new Float32Array(CFG.COUNT * 3);
        const fixed = new Uint8Array(CFG.COUNT);
        const halfW = window.innerWidth/2, halfH = window.innerHeight/2;
        for (let i = 0; i < CFG.COUNT; i++) {
          const ix = i*3;
          positions[ix]   = (Math.random()*2-1)*halfW;
          positions[ix+1] = (Math.random()*2-1)*halfH;
          positions[ix+2] = (Math.random()-0.5)*60; // shallow depth
          velocities[ix]   = (Math.random()-0.5)*CFG.SPEED;
          velocities[ix+1] = (Math.random()-0.5)*CFG.SPEED;
          velocities[ix+2] = 0;
          fixed[i] = Math.random() < CFG.FIXED_RATIO ? 1 : 0;
        }
        const pGeo = new THREE.BufferGeometry();
        pGeo.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
        const pMat = new THREE.PointsMaterial({ size: CFG.SIZE, color: CFG.COLOR, transparent: true, opacity: 1.0, blending: THREE.AdditiveBlending, depthWrite: false, sizeAttenuation: true, map: dotTex, alphaTest: 0.01 });
        const points = new THREE.Points(pGeo, pMat);
        scene.add(points);
        // No extra halo to avoid blur — keep points crisp

        // Mouse magnetic interaction
        const mouseNDC = new THREE.Vector2();
        const ray = new THREE.Raycaster();
        const plane = new THREE.Plane(new THREE.Vector3(0,0,1), 0);
        const mouse3 = new THREE.Vector3(0,0,0);
        let mouseActive = false;
        function updateMouse(e){
          mouseNDC.x=(e.clientX/window.innerWidth)*2-1;
          mouseNDC.y=-(e.clientY/window.innerHeight)*2+1;
          ray.setFromCamera(mouseNDC, camera); ray.ray.intersectPlane(plane, mouse3); mouseActive=true;
        }
        window.addEventListener('mousemove', updateMouse, {passive:true});
        window.addEventListener('mouseleave', ()=>{mouseActive=false;});

        console.log('✅ Magnetic particle field ready');

        // Animation loop
        let frame = 0;
        function animate() {
          requestAnimationFrame(animate);
          frame++;
          
          // Update particles
          const pos = pGeo.attributes.position.array;
          for (let i=0;i<CFG.COUNT;i++){
            const ix=i*3; let x=pos[ix], y=pos[ix+1];
            if (!fixed[i]){
              // magnetic pull with slight swirl
              if (mouseActive){
                const dx=x-mouse3.x, dy=y-mouse3.y; const d=Math.hypot(dx,dy)||1;
                if (d<CFG.MAG_RADIUS){
                  const nx=dx/d, ny=dy/d; // outward
                  // attraction toward mouse (subtract outward normal)
                  velocities[ix]   -= nx * CFG.MAG_STRENGTH*(1-d/CFG.MAG_RADIUS);
                  velocities[ix+1] -= ny * CFG.MAG_STRENGTH*(1-d/CFG.MAG_RADIUS);
                  // swirl
                  velocities[ix]   += -ny * CFG.SWIRL * 0.5;
                  velocities[ix+1] +=  nx * CFG.SWIRL * 0.5;
                }
              }
              // integrate + friction + cap
              velocities[ix]   *= CFG.FRICTION;
              velocities[ix+1] *= CFG.FRICTION;
              const sp=Math.hypot(velocities[ix], velocities[ix+1]);
              if (sp>CFG.MAX_SPEED){ const s=CFG.MAX_SPEED/sp; velocities[ix]*=s; velocities[ix+1]*=s; }
              x+=velocities[ix]; y+=velocities[ix+1];
              // soft bounds
              if (x<-halfW || x>halfW) velocities[ix]*=-0.98;
              if (y<-halfH || y>halfH) velocities[ix+1]*=-0.98;
              pos[ix]=x; pos[ix+1]=y;
            }
          }
          pGeo.attributes.position.needsUpdate = true;

          renderer.render(scene, camera);
          
          // Log status occasionally
          if (frame % 240 === 0) console.log('✨ Magnetic points frame', frame);
        }
        
        // Resize handler
        window.addEventListener('resize', () => {
          camera.aspect = window.innerWidth / window.innerHeight;
          camera.updateProjectionMatrix();
          renderer.setSize(window.innerWidth, window.innerHeight);
        });
        
        animate();
        console.log('✅ Magnetic particle field initialized!');
        this.initialized = true;
        return true;
        
      } catch (error) {
        console.error('❌ Error:', error);
        return false;
      }
    }
  };

  // Export for manual initialization
  window.BrainThreeNetwork = BrainThreeNetwork;
  console.log('🚀 Mesh-based Three.js Comet Script Ready');
})();