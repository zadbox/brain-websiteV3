/*
 * Three.js background: stylish shooting comets + interconnected neural network
 * - Full-viewport, fixed behind content (container: #three-network-bg)
 * - No post-processing; uses additive blending for glow-like look
 */
(function () {
  const BG = {
    init(containerId = 'three-network-bg') {
      const container = document.getElementById(containerId);
      if (!container || !window.THREE) return false;

      // Scene / Camera / Renderer
      const scene = new THREE.Scene();
      const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 4000);
      camera.position.z = 900;

      const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
      renderer.setPixelRatio(Math.min(2, window.devicePixelRatio || 1));
      renderer.setSize(window.innerWidth, window.innerHeight);
      renderer.setClearColor(0x000000, 0);
      const canvas = renderer.domElement;
      Object.assign(canvas.style, {
        position: 'fixed', top: '0', left: '0', width: '100%', height: '100%',
        zIndex: '-5', pointerEvents: 'none'
      });
      container.appendChild(canvas);

      // Shared colors
      const C = {
        // White, star-like aesthetic
        point: new THREE.Color(0xffffff),
        line: new THREE.Color(0xffffff),
        comet: new THREE.Color(0xffffff)
      };

      // Network config
      const NET = {
        // Reduced count, still connected
        COUNT: Math.max(160, Math.min(260, Math.floor((window.innerWidth * window.innerHeight) / 16000))),
        SPEED: 0.18,
        LINK_DIST: 260,
        MAX_LINKS: 7,
      };
      const halfW = window.innerWidth / 2;
      const halfH = window.innerHeight / 2;

      // Nodes
      const nodePositions = new Float32Array(NET.COUNT * 3);
      const nodeVel = new Float32Array(NET.COUNT * 3);
      for (let i = 0; i < NET.COUNT; i++) {
        const ix = i * 3;
        nodePositions[ix + 0] = (Math.random() * 2 - 1) * halfW;
        nodePositions[ix + 1] = (Math.random() * 2 - 1) * halfH;
        nodePositions[ix + 2] = (Math.random() - 0.5) * 80; // slight depth
        nodeVel[ix + 0] = (Math.random() - 0.5) * NET.SPEED;
        nodeVel[ix + 1] = (Math.random() - 0.5) * NET.SPEED;
        nodeVel[ix + 2] = 0;
      }
      const nodeGeo = new THREE.BufferGeometry();
      nodeGeo.setAttribute('position', new THREE.Float32BufferAttribute(nodePositions, 3));
      const nodeMat = new THREE.PointsMaterial({
        size: 2.0,
        color: C.point,
        transparent: true,
        opacity: 0.9,
        blending: THREE.AdditiveBlending,
        depthWrite: false,
        sizeAttenuation: true,
      });
      const nodes = new THREE.Points(nodeGeo, nodeMat);
      scene.add(nodes);

      // Network lines (dynamic)
      const maxSegments = NET.COUNT * NET.MAX_LINKS;
      const linkPositions = new Float32Array(maxSegments * 6);
      const linkGeo = new THREE.BufferGeometry();
      linkGeo.setAttribute('position', new THREE.Float32BufferAttribute(linkPositions, 3));
      linkGeo.setDrawRange(0, 0);
      const linkMat = new THREE.LineBasicMaterial({
        color: C.line, transparent: true, opacity: 0.42,
        blending: THREE.AdditiveBlending, depthTest: false, depthWrite: false,
      });
      const links = new THREE.LineSegments(linkGeo, linkMat);
      scene.add(links);

      // Comets
      const COMET = {
        // Less frequent comets, brighter white
        COUNT: 8,
        SPEED_MIN: 3.8,
        SPEED_MAX: 7.0,
        TRAIL: 80,
        HEAD_SIZE: 6.2,
        GLOW_SIZE: 26,
        OPACITY: 0.98,
        TRAIL_OPACITY: 0.8,
        SPAWN_RATE: 0.012,
        STREAK_THICKNESS: 7,
        STREAK_BASE: 140,
        STREAK_FACTOR: 45
      };

      // Generate small canvas textures for comet streak and glow
      function makeStreakTexture() {
        const c = document.createElement('canvas');
        c.width = 256; c.height = 32;
        const g = c.getContext('2d');
        const grd = g.createLinearGradient(0, 0, c.width, 0);
        grd.addColorStop(0.0, 'rgba(255,255,255,0)');
        grd.addColorStop(0.15, 'rgba(255,255,255,0.35)');
        grd.addColorStop(0.5, 'rgba(255,255,255,0.9)');
        grd.addColorStop(0.85, 'rgba(255,255,255,0.35)');
        grd.addColorStop(1.0, 'rgba(255,255,255,0)');
        g.fillStyle = grd;
        g.fillRect(0, 8, c.width, 16);
        return new THREE.CanvasTexture(c);
      }
      function makeGlowTexture() {
        const c = document.createElement('canvas');
        c.width = c.height = 128;
        const g = c.getContext('2d');
        const grd = g.createRadialGradient(64,64,0,64,64,64);
        grd.addColorStop(0.0,'rgba(255,255,255,0.5)');
        grd.addColorStop(1.0,'rgba(255,255,255,0)');
        g.fillStyle = grd; g.fillRect(0,0,c.width,c.height);
        return new THREE.CanvasTexture(c);
      }
      const streakTex = makeStreakTexture();
      const glowTex = makeGlowTexture();
      const comets = [];
      function newComet() {
        const side = Math.floor(Math.random() * 4);
        const margin = 200;
        let x=0,y=0;
        if (side === 0) { x = (Math.random()*2-1)*halfW; y = halfH + margin; }
        else if (side === 1) { x = halfW + margin; y = (Math.random()*2-1)*halfH; }
        else if (side === 2) { x = (Math.random()*2-1)*halfW; y = -halfH - margin; }
        else { x = -halfW - margin; y = (Math.random()*2-1)*halfH; }
        const start = new THREE.Vector3(x, y, (Math.random()-0.5)*60);
        const dir = new THREE.Vector3((Math.random()-0.5)*0.3, (side===0?-1:side===2?1:(Math.random()-0.5)*0.3), 0).normalize();
        const speed = COMET.SPEED_MIN + Math.random()*(COMET.SPEED_MAX-COMET.SPEED_MIN);

        // Trail line (afterglow)
        const trailGeo = new THREE.BufferGeometry();
        const trailPos = new Float32Array(COMET.TRAIL * 3);
        for (let i=0;i<COMET.TRAIL;i++){ trailPos[i*3]=start.x; trailPos[i*3+1]=start.y; trailPos[i*3+2]=start.z; }
        trailGeo.setAttribute('position', new THREE.Float32BufferAttribute(trailPos,3));
        const trailMat = new THREE.LineBasicMaterial({ color: C.comet, transparent:true, opacity: COMET.TRAIL_OPACITY, blending: THREE.AdditiveBlending, depthWrite:false });
        const trail = new THREE.Line(trailGeo, trailMat);
        scene.add(trail);

        // Streak sprite oriented along direction
        const streak = new THREE.Sprite(new THREE.SpriteMaterial({ map: streakTex, color: C.comet, transparent: true, opacity: 0.85, blending: THREE.AdditiveBlending, depthWrite: false }));
        streak.position.copy(start);
        scene.add(streak);

        // Soft glow sprite around head
        const glow = new THREE.Sprite(new THREE.SpriteMaterial({ map: glowTex, color: C.comet, transparent: true, opacity: 0.28, blending: THREE.AdditiveBlending, depthWrite: false }));
        glow.position.copy(start);
        scene.add(glow);

        return { pos:start, dir, speed, trail, trailPos, streak, glow, life: 600+Math.random()*400, age:0, wobble: Math.random()*Math.PI*2 };
      }
      // Seed comets
      for (let i=0;i<COMET.COUNT;i++) comets.push(newComet());

      // Twinkling stars (some fixed, some slowly drifting)
      const TWINKLE = {
        COUNT: 70,
        FIXED_RATIO: 0.55,
        SPEED: 0.04,
        SIZE_MIN: 8,
        SIZE_MAX: 16,
        OPACITY_MIN: 0.25,
        OPACITY_MAX: 0.95,
      };
      const stars = [];
      for (let i=0;i<TWINKLE.COUNT;i++){
        const s = new THREE.Sprite(new THREE.SpriteMaterial({ map: glowTex, color: C.point, transparent:true, opacity: 0.6, blending: THREE.AdditiveBlending, depthWrite:false }));
        s.position.set((Math.random()*2-1)*halfW, (Math.random()*2-1)*halfH, (Math.random()-0.5)*40);
        const size = TWINKLE.SIZE_MIN + Math.random()*(TWINKLE.SIZE_MAX-TWINKLE.SIZE_MIN);
        s.scale.set(size, size, 1);
        scene.add(s);
        stars.push({ sprite:s, 
          fixed: Math.random() < TWINKLE.FIXED_RATIO, 
          phase: Math.random()*Math.PI*2, 
          speed: 0.5 + Math.random()*1.2, 
          vx: (Math.random()-0.5)*TWINKLE.SPEED, 
          vy: (Math.random()-0.5)*TWINKLE.SPEED,
          baseSize: size
        });
      }

      // Shooting stars system (reuses some star sprites)
      const SHOOT = {
        RATIO: 0.12,             // ~12% of stars can become shooters
        SPEED_MIN: 6.0,          // px/frame
        SPEED_MAX: 11.0,
        FADE: 0.02,              // opacity decrement per frame
        INTERVAL_MIN: 180,       // min frames between spawns for a star
        INTERVAL_MAX: 540,       // max frames between spawns
        MARGIN: 40,              // spawn just above top edge
        STREAK_THICKNESS: 7,
        STREAK_BASE: 140,
        STREAK_FACTOR: 45,
      };
      const shooters = [];
      const rRange = (a,b)=> a + Math.random()*(b-a);
      const rInt = (a,b)=> Math.floor(rRange(a,b));

      function scheduleShooter(star, frame){
        star.active = false;
        star.nextSpawn = frame + rInt(SHOOT.INTERVAL_MIN, SHOOT.INTERVAL_MAX);
      }
      function activateShooter(star){
        const speed = rRange(SHOOT.SPEED_MIN, SHOOT.SPEED_MAX);
        const dirX = Math.random()<0.5 ? -1 : 1;
        star.vx = dirX * speed * 0.8;
        star.vy = -speed;
        star.sprite.position.set(rRange(-halfW, halfW), halfH + SHOOT.MARGIN, (Math.random()-0.5)*40);
        star.sprite.material.opacity = 1;
        const len = SHOOT.STREAK_BASE + speed * SHOOT.STREAK_FACTOR;
        star.sprite.scale.set(len, SHOOT.STREAK_THICKNESS, 1);
        star.sprite.material.rotation = Math.atan2(star.vy, star.vx);
        star.active = true;
      }
      function markShootingCandidates(frame=0){
        for (const st of stars){
          if (Math.random() < SHOOT.RATIO){
            st.isShooter = true; st.active = false; shooters.push(st);
            scheduleShooter(st, frame + rInt(0, SHOOT.INTERVAL_MAX));
          } else {
            st.isShooter = false; st.active = false;
          }
        }
      }
      markShootingCandidates(0);

      // Mouse magnetic nudge (subtle)
      const mouse = new THREE.Vector3(0,0,0);
      const mouseNDC = new THREE.Vector2();
      const ray = new THREE.Raycaster();
      const plane = new THREE.Plane(new THREE.Vector3(0,0,1), 0);
      let mouseActive=false;
      function onMouse(e){
        mouseNDC.x = (e.clientX/window.innerWidth)*2-1;
        mouseNDC.y = -(e.clientY/window.innerHeight)*2+1;
        ray.setFromCamera(mouseNDC, camera); ray.ray.intersectPlane(plane, mouse);
        mouseActive=true;
      }
      window.addEventListener('mousemove', onMouse);
      window.addEventListener('mouseleave', ()=>{mouseActive=false;});

      // Resize
      window.addEventListener('resize', ()=>{
        camera.aspect = window.innerWidth/window.innerHeight; camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
      });

      // Animate
      let frame = 0;
      function animate(){
        requestAnimationFrame(animate);
        frame++;

        // Update nodes
        const np = nodeGeo.attributes.position.array;
        for(let i=0;i<NET.COUNT;i++){
          const ix=i*3; np[ix]+=nodeVel[ix]; np[ix+1]+=nodeVel[ix+1];
          // bounds bounce
          if (np[ix] < -halfW || np[ix] > halfW) nodeVel[ix]*=-1;
          if (np[ix+1] < -halfH || np[ix+1] > halfH) nodeVel[ix+1]*=-1;
          // subtle mouse pull
          if(mouseActive && (i%7===0)){
            const dx = mouse.x-np[ix], dy = mouse.y-np[ix+1];
            const d2 = dx*dx+dy*dy; if (d2<120*120){ nodeVel[ix]+=dx*0.00002; nodeVel[ix+1]+=dy*0.00002; }
          }
        }
        nodeGeo.attributes.position.needsUpdate = true;

        // Twinkle stars (skip active shooting stars)
        for (const st of stars){
          if (st.isShooter && st.active) continue;
          st.phase += 0.02*st.speed;
          const t = (Math.sin(st.phase)+1)/2; // 0..1
          const op = TWINKLE.OPACITY_MIN + t*(TWINKLE.OPACITY_MAX - TWINKLE.OPACITY_MIN);
          st.sprite.material.opacity = op;
          st.sprite.scale.set(st.baseSize*(0.9+0.2*t), st.baseSize*(0.9+0.2*t), 1);
          if (!st.fixed){
            st.sprite.position.x += st.vx;
            st.sprite.position.y += st.vy;
            if (st.sprite.position.x < -halfW || st.sprite.position.x > halfW) st.vx *= -1;
            if (st.sprite.position.y < -halfH || st.sprite.position.y > halfH) st.vy *= -1;
          }
        }

        // Spawn new shooting stars occasionally
        if ((frame & 1) === 0){
          for (const s of shooters){ if (!s.active && frame >= s.nextSpawn) activateShooter(s); }
        }

        // Update active shooting stars
        for (const s of shooters){
          if (!s.active) continue;
          const spr = s.sprite;
          spr.position.x += s.vx; spr.position.y += s.vy;
          spr.material.opacity = Math.max(0, spr.material.opacity - SHOOT.FADE);
          const spdLen = Math.hypot(s.vx, s.vy);
          const len = SHOOT.STREAK_BASE + spdLen * SHOOT.STREAK_FACTOR;
          spr.scale.set(len, SHOOT.STREAK_THICKNESS, 1);
          spr.material.rotation = Math.atan2(s.vy, s.vx);
          const out = (spr.position.y < -halfH - SHOOT.MARGIN) || (spr.position.x < -halfW - SHOOT.MARGIN) || (spr.position.x > halfW + SHOOT.MARGIN) || (spr.material.opacity <= 0.001);
          if (out){ scheduleShooter(s, frame); spr.material.opacity = 0.0; s.active = false; }
        }

        // Recompute links every frame (lightweight count)
        const L = NET.LINK_DIST; const L2=L*L; let seg=0;
        for(let i=0;i<NET.COUNT;i++){
          const ia=i*3; const ax=np[ia], ay=np[ia+1], az=np[ia+2]; let linksPerI=0;
          for(let j=i+1;j<NET.COUNT && linksPerI<NET.MAX_LINKS;j++){
            const ja=j*3; const bx=np[ja], by=np[ja+1], bz=np[ja+2];
            const dx=ax-bx, dy=ay-by; // pure 2D distance for denser links
            const d2=dx*dx+dy*dy; if(d2<L2){
              const k=seg*6; linkPositions[k]=ax; linkPositions[k+1]=ay; linkPositions[k+2]=az; linkPositions[k+3]=bx; linkPositions[k+4]=by; linkPositions[k+5]=bz; seg++; linksPerI++;
            }
          }
        }
        linkGeo.setDrawRange(0, seg*2); linkGeo.attributes.position.needsUpdate=true;

        // Update comets
        for(let i=comets.length-1;i>=0;i--){
          const c=comets[i]; c.age++;
          // wobble and slight mouse attraction
          c.wobble+=0.02; c.dir.x+=Math.sin(c.wobble)*0.002; c.dir.y+=Math.cos(c.wobble)*0.002; c.dir.normalize();
          if(mouseActive){ const dx=mouse.x-c.pos.x, dy=mouse.y-c.pos.y; const d=Math.hypot(dx,dy); if(d<260){ c.dir.x+=dx/d*0.01; c.dir.y+=dy/d*0.01; c.dir.normalize(); }}
          // move
          c.pos.addScaledVector(c.dir, c.speed);
          // wrap around
          if (c.pos.x<-halfW-260||c.pos.x>halfW+260||c.pos.y<-halfH-260||c.pos.y>halfH+260){ comets.splice(i,1); scene.remove(c.trail); scene.remove(c.streak); scene.remove(c.glow); continue; }
          // update trail
          const tp=c.trailPos; for(let t=(COMET.TRAIL-1)*3;t>=3;t-=3){ tp[t]=tp[t-3]; tp[t+1]=tp[t-2]; tp[t+2]=tp[t-1]; }
          tp[0]=c.pos.x; tp[1]=c.pos.y; tp[2]=c.pos.z; c.trail.geometry.attributes.position.needsUpdate=true;
          // update streak/glow sprites (position, scale, rotation)
          c.streak.position.copy(c.pos);
          c.glow.position.copy(c.pos);
          const len = (COMET.STREAK_BASE + c.speed * COMET.STREAK_FACTOR);
          c.streak.scale.set(len, COMET.STREAK_THICKNESS, 1);
          c.glow.scale.set(COMET.GLOW_SIZE, COMET.GLOW_SIZE, 1);
          c.streak.material.rotation = Math.atan2(c.dir.y, c.dir.x);
          c.glow.material.rotation = c.streak.material.rotation;
          // life
          if(c.age>c.life){ comets.splice(i,1); scene.remove(c.trail); scene.remove(c.streak); scene.remove(c.glow); }
        }
        // spawn
        if (comets.length<COMET.COUNT && Math.random()<COMET.SPAWN_RATE) comets.push(newComet());

        renderer.render(scene, camera);
      }
      animate();
      return true;
    }
  };

  // Auto init
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ()=>BG.init('three-network-bg'));
  } else {
    BG.init('three-network-bg');
  }
  window.BrainThreeNetwork = BG;
})();
