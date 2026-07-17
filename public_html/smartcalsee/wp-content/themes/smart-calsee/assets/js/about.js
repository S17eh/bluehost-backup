  document.addEventListener('DOMContentLoaded', function () {

  (function() {
    const container = document.querySelector('.globel-about-container');
    if (!container) return; // skip WebGL ribbon/globe when no container is on the page

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(
      45,
      (container.clientWidth || 600) / (container.clientHeight || 420),
      0.1,
      1000
    );
    camera.position.z = 3;

    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setPixelRatio(window.devicePixelRatio || 1);
    renderer.setSize(container.clientWidth || 600, container.clientHeight || 420);
    container.appendChild(renderer.domElement);

    // Lighting
    const light = new THREE.AmbientLight(0xffffff, 1.2);
    scene.add(light);

    // Load local image texture
    const textureLoader = new THREE.TextureLoader();
    const globeBase = (typeof ThemeData !== 'undefined' && ThemeData.assetsUrl)
      ? ThemeData.assetsUrl
      : '/wp-content/themes/smart-calsee/assets/image/';
    const texture = textureLoader.load(globeBase + 'mask_group.png');

    // Material
    const material = new THREE.MeshPhongMaterial({
      map: texture,
      transparent: true,
      opacity: 0.9,
      side: THREE.DoubleSide
    });

    // Half-sphere geometry
    const geometry = new THREE.SphereGeometry(
      1, 64, 64, 0, Math.PI * 2, 0, Math.PI / 2
    );

    const globe = new THREE.Mesh(geometry, material);
    scene.add(globe);

    // Animation loop
    function animate() {
      requestAnimationFrame(animate);
      globe.rotation.y += 0.005;
      renderer.render(scene, camera);
    }
    animate();

    // Responsive
    window.addEventListener("resize", () => {
      const width = container.clientWidth || 600;
      const height = container.clientHeight || 420;
      renderer.setSize(width, height);
      camera.aspect = width / height;
      camera.updateProjectionMatrix();
    });
  })();
  
});
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("readMoreBtn");
    const content = document.getElementById("visionText");

    if (btn && content) {
        btn.addEventListener("click", function () {

            if (content.classList.contains("collapsed")) {
                content.classList.remove("collapsed");
                content.classList.add("expanded");
                btn.textContent = "Read Less";
            } else {
                content.classList.remove("expanded");
                content.classList.add("collapsed");
                btn.textContent = "Read More";
            }

        });
    }

});