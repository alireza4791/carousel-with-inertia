<script>
  const carousel = document.querySelector(".carousel");
  const params = {
    inertiaMultiplier: 0.955,
    inertiaThreshold: 0.5
  }

  let isDown = false;
  let startX;
  let scrollLeft;
  let timeoutId;
  let touchStartX;
  let touchScrollLeft;
  var velX = 0;
  var momentumID;

  carousel.addEventListener("mousedown", handleMouseDown);
  carousel.addEventListener("touchstart", handleTouchStart);
  carousel.addEventListener("mouseleave", handleMouseLeave);
  carousel.addEventListener("mouseup", handleMouseUp);
  carousel.addEventListener("touchend", handleTouchEnd);
  carousel.addEventListener("mousemove", handleMouseMove);
  carousel.addEventListener("touchmove", handleTouchMove);
  carousel.addEventListener("wheel", handleWheel);

  function beginMomentumTracking() {
    cancelMomentumTracking();
    momentumID = requestAnimationFrame(momentumLoop);
  }

  function cancelMomentumTracking() {
    cancelAnimationFrame(momentumID);
  }

  function momentumLoop() {
    carousel.scrollLeft += velX;
    velX *= params.inertiaMultiplier;
    if (Math.abs(velX) > params.inertiaThreshold) {
      momentumID = requestAnimationFrame(momentumLoop);
    }
  }

  function handleMouseDown(e) {
    isDown = true;
    const slider = e.currentTarget;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
    cancelMomentumTracking();
  }

  function handleTouchStart(e) {
    isDown = true;
    const slider = e.currentTarget;
    const touch = e.touches[0];
    touchStartX = touch.pageX - slider.offsetLeft;
    touchScrollLeft = slider.scrollLeft;
    cancelMomentumTracking();
  }

  function handleMouseLeave() {
    isDown = false;
  }

  function handleMouseUp() {
    isDown = false;
    beginMomentumTracking();
  }

  function handleTouchEnd() {
    isDown = false;
    beginMomentumTracking();
  }

  function handleMouseMove(e) {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - this.offsetLeft;
    const walk = (x - startX) * 3;
    const prevScrollLeft = this.scrollLeft;
    this.scrollLeft = scrollLeft - walk;
    velX = this.scrollLeft - prevScrollLeft;
  }

  function handleTouchMove(e) {
    if (!isDown) return;
    e.preventDefault();
    const slider = e.currentTarget;
    const touch = e.touches[0];
    const x = touch.pageX - slider.offsetLeft;
    const walk = (x - touchStartX) * 3;
    const prevScrollLeft = slider.scrollLeft;
    slider.scrollLeft = touchScrollLeft - walk;
    velX = slider.scrollLeft - prevScrollLeft;
  }

  function handleWheel(e) {
    cancelMomentumTracking();
  }
</script>