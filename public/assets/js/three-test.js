// Minimal Three.js Test
console.log('🧪 Three.js Test Script Loading...');

window.addEventListener('load', function() {
  console.log('🚀 Testing Three.js...');
  
  if (!window.THREE) {
    console.error('❌ Three.js not available');
    return;
  }
  
  console.log('✅ Three.js version:', THREE.REVISION);
  
  const container = document.getElementById('three-network-bg');
  if (!container) {
    console.error('❌ Container not found');
    return;
  }
  
  console.log('✅ Container found:', container);
  
  try {
    // Basic Three.js setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0);
    
    // Style the canvas
    const canvas = renderer.domElement;
    canvas.style.position = 'fixed';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.zIndex = '-1';
    canvas.style.pointerEvents = 'none';
    
    container.appendChild(canvas);
    console.log('✅ Canvas added to DOM');
    
    // Create a simple spinning cube
    const geometry = new THREE.BoxGeometry(100, 100, 100);
    const material = new THREE.MeshBasicMaterial({ 
      color: 0xff0000, 
      wireframe: true 
    });
    const cube = new THREE.Mesh(geometry, material);
    scene.add(cube);
    
    camera.position.z = 300;
    
    console.log('✅ Scene setup complete');
    
    // Animation loop
    function animate() {
      requestAnimationFrame(animate);
      
      cube.rotation.x += 0.01;
      cube.rotation.y += 0.01;
      
      renderer.render(scene, camera);
    }
    
    animate();
    console.log('🎯 Animation started - you should see a red wireframe cube!');
    
  } catch (error) {
    console.error('❌ Three.js test failed:', error);
  }
});