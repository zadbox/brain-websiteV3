// Galaxy background with layered stars, twinkling, parallax, and shooting stars
(function () {
  const supports = typeof window !== 'undefined' && !!window.THREE;
  if (!supports) return;

  const container = document.getElementById('neural-network-bg') || document.body;
  const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Scene setup
  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 1, 4000);
  camera.position.z = 1000;

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

  // Palette
  const COLORS = [0xffffff, 0xaec6ff, 0x9b8cff]; // white, soft blue, soft violet

  // Layer factory
  function makeStarLayer({ count, depth, size, opacity }) {
    const geo = new THREE.BufferGeometry();
    const positions = new Float32Array(count * 3);
    const colors = new Float32Array(count * 3);
    for (let i = 0; i < count; i++) {
      const ix = i * 3;
      positions[ix + 0] = (Math.random() * 2 - 1) * window.innerWidth;
      positions[ix + 1] = (Math.random() * 2 - 1) * window.innerHeight;
      positions[ix + 2] = -depth + (Math.random() - 0.5) * 50;
      const c = new THREE.Color(COLORS[Math.floor(Math.random() * COLORS.length)]);
      colors[ix + 0] = c.r; colors[ix + 1] = c.g; colors[ix + 2] = c.b;
    }
    geo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    geo.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    const mat = new THREE.PointsMaterial({ size, vertexColors: true, transparent: true, opacity, depthWrite: false, blending: THREE.AdditiveBlending, sizeAttenuation: true });
    const points = new THREE.Points(geo, mat);
    points.userData = { positions, twinklePhase: Math.random() * Math.PI * 2, twinkleSpeed: 0.5 + Math.random() * 0.8 };
    scene.add(points);
    return points;
  }

  // Layers (far to near)
  const baseCount = prefersReduced ? 200 : 450;
  const layers = [
    makeStarLayer({ count: Math.floor(baseCount * 0.6), depth: 1200, size: 1.1, opacity: 0.35 }),
    makeStarLayer({ count: Math.floor(baseCount * 0.8), depth: 900, size: 1.4, opacity: 0.45 }),
    makeStarLayer({ count: Math.floor(baseCount * 1.0), depth: 600, size: 1.8, opacity: 0.55 })
  ];

  // Twinkle: vary layer opacity subtly and offset each layer
  function updateTwinkle(dt) {
    if (prefersReduced) return;
    layers.forEach(l => {
      const mat = l.material; const ud = l.userData;
      ud.twinklePhase += dt * 0.6 * ud.twinkleSpeed;
      const t = (Math.sin(ud.twinklePhase) + 1) * 0.5; // 0..1
      const base = 0.25; const range = 0.25; // subtle
      mat.opacity = base + t * range;
    });
  }

  // Shooting stars with sprite streak
  function makeStreakTexture() {
    const c = document.createElement('canvas'); c.width = 256; c.height = 32;
    const g = c.getContext('2d');
    const grd = g.createLinearGradient(0, 0, c.width, 0);
    grd.addColorStop(0.0, 'rgba(255,255,255,0)');
    grd.addColorStop(0.2, 'rgba(173,196,255,0.25)');
    grd.addColorStop(0.5, 'rgba(255,255,255,0.9)');
    grd.addColorStop(0.8, 'rgba(173,196,255,0.25)');
    grd.addColorStop(1.0, 'rgba(255,255,255,0)');
    g.fillStyle = grd; g.fillRect(0, 8, c.width, 16); return new THREE.CanvasTexture(c);
  }
  const streakTex = makeStreakTexture();

  const SHOOT = {
    COUNT: prefersReduced ? 3 : 8,
    SPEED_MIN: 6.0,
    SPEED_MAX: 12.0,
    THICK: 7,
    BASE: 140,
    FACTOR: 45,
    OPACITY: 0.9,
    FADE: 0.02,
    INTERVAL_MIN: 180,
    INTERVAL_MAX: 540,
    MARGIN: 40
  };
  const shooters = [];
  function newShooter(delay = 0) {
    const spr = new THREE.Sprite(new THREE.SpriteMaterial({ map: streakTex, color: 0xffffff, transparent: true, opacity: 0.0, blending: THREE.AdditiveBlending, depthWrite: false }));
    spr.scale.set(SHOOT.BASE, SHOOT.THICK, 1);
    scene.add(spr);
    const obj = { spr, vx: 0, vy: 0, speed: 0, active: false, next: performance.now() + delay };
    shooters.push(obj);
  }
  for (let i = 0; i < SHOOT.COUNT; i++) newShooter(i * 500);

  function spawnShooter(s) {
    const speed = SHOOT.SPEED_MIN + Math.random() * (SHOOT.SPEED_MAX - SHOOT.SPEED_MIN);
    const dirX = Math.random() < 0.5 ? -1 : 1;
    s.vx = dirX * speed * (0.8 + Math.random() * 0.2);
    s.vy = -speed;
    s.speed = speed;
    s.spr.position.set((Math.random() * 2 - 1) * (window.innerWidth / 2), (window.innerHeight / 2) + SHOOT.MARGIN, -700 + Math.random() * 200);
    s.spr.material.opacity = SHOOT.OPACITY;
    s.active = true;
  }

  // Parallax target
  const parallax = { x: 0, y: 0 };
  window.addEventListener('mousemove', (e) => {
    const nx = (e.clientX / window.innerWidth) * 2 - 1;
    const ny = (e.clientY / window.innerHeight) * 2 - 1;
    parallax.x = nx * 20;
    parallax.y = ny * 20;
  }, { passive: true });

  window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
  });

  let last = performance.now();
  function animate(now) {
    requestAnimationFrame(animate);
    const dt = Math.min(0.05, (now - last) / 1000);
    last = now;

    // Subtle parallax by moving layers opposite mouse
    layers.forEach((l, i) => {
      const f = (i + 1) * 0.15;
      l.position.x += ((-parallax.x * f) - l.position.x) * 0.05;
      l.position.y += (( parallax.y * f) - l.position.y) * 0.05;
    });

    updateTwinkle(dt);

    // Shooting stars
    const tnow = now;
    for (const s of shooters) {
      if (!s.active) {
        if (tnow >= s.next) spawnShooter(s);
        continue;
      }
      const len = SHOOT.BASE + s.speed * SHOOT.FACTOR;
      s.spr.scale.set(len, SHOOT.THICK, 1);
      s.spr.material.rotation = Math.atan2(s.vy, s.vx);
      s.spr.position.x += s.vx;
      s.spr.position.y += s.vy;
      s.spr.material.opacity = Math.max(0, s.spr.material.opacity - SHOOT.FADE);
      const off = SHOOT.MARGIN;
      if (s.spr.material.opacity <= 0.01 || s.spr.position.y < -window.innerHeight / 2 - off || s.spr.position.x < -window.innerWidth / 2 - off || s.spr.position.x > window.innerWidth / 2 + off) {
        s.active = false; s.spr.material.opacity = 0.0; s.next = tnow + (SHOOT.INTERVAL_MIN + Math.random() * (SHOOT.INTERVAL_MAX - SHOOT.INTERVAL_MIN)) * (prefersReduced ? 2 : 1);
        // reset somewhere off-screen to avoid flashes
        s.spr.position.set(0, -window.innerHeight / 2 - 500, -800);
      }
    }

    renderer.render(scene, camera);
  }
  requestAnimationFrame(animate);
})();

