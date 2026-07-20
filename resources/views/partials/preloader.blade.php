
<div id="sitePreloader" class="site-preloader" style="display:none; opacity:0;">
    
    <div class="preloader-spinner">
        <div class="spinner-circle"></div>
        <span>Loading</span>
    </div>
    <video id="preloaderVideo" src="{{ asset('assets/loader/loader.mp4') }}" playsinline webkit-playsinline preload="auto" style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:contain; object-position:center; display:block; z-index: 2;"></video>
</div>

<script>
  (function() {
    var STORAGE_KEY = 'rydaris_loader_shown';

    window.__rydarisShowLoader = function(navigateTo) {
      // Mark as shown for this session
      try { sessionStorage.setItem(STORAGE_KEY, '1'); } catch(e) {}

      var loader = document.getElementById('sitePreloader');
      var video  = document.getElementById('preloaderVideo');

      if (!loader || !video) {
        window.location.href = navigateTo;
        return;
      }

      // Show loader fullscreen
      loader.style.cssText = 'display:block !important; opacity:0; position:fixed; top:0; left:0; width:100vw; height:100vh; z-index:999999; background:#050711; overflow:hidden; transition:opacity 0.3s ease;';

      requestAnimationFrame(function() {
        requestAnimationFrame(function() {
          loader.style.opacity = '1';
        });
      });

      var navigated = false;
      function doNavigate() {
        if (navigated) return;
        navigated = true;
        window.location.href = navigateTo;
      }

      // Play video with sound
      video.currentTime = 0;
      video.muted = false;
      var playPromise = video.play();
      if (playPromise !== undefined) {
        playPromise.catch(function(error) {
          console.warn("Video preloader unmuted play blocked. Trying muted.", error);
          video.muted = true;
          video.play().catch(function(err) {
            console.error("Muted video play failed. Navigating.", err);
            doNavigate();
          });
        });
      }

      video.addEventListener('ended', doNavigate);
      setTimeout(doNavigate, 10000);
    };

    // Intercept ALL internal anchor clicks — first time per session only
    document.addEventListener('DOMContentLoaded', function() {
      document.body.addEventListener('click', function(e) {

        // Already shown this session? Skip
        var alreadyShown = false;
        try { alreadyShown = !!sessionStorage.getItem(STORAGE_KEY); } catch(ex) {}
        if (alreadyShown) return;

        // Find the clicked anchor
        var target = e.target.closest('a');
        if (!target) return;

        var href = target.getAttribute('href');
        if (!href || href.trim() === '') return;

        // Skip hash, mailto, tel, javascript, new-tab
        if (
          href === '#' ||
          href.startsWith('#') ||
          href.startsWith('mailto:') ||
          href.startsWith('tel:') ||
          href.startsWith('javascript:') ||
          target.getAttribute('target') === '_blank'
        ) return;

        // *** KEY FIX: Check if it's the SAME hostname (Laravel route() generates full URLs) ***
        try {
          var linkUrl = new URL(href, window.location.href);
          // If different hostname = truly external, skip
          if (linkUrl.hostname !== window.location.hostname) return;
          // Same hostname = internal link, use full URL
          href = linkUrl.href;
        } catch(err) {
          return; // invalid URL
        }

        // Valid internal link — intercept and show loader!
        e.preventDefault();
        e.stopPropagation();

        window.__rydarisShowLoader(href);
      }, true);
    });
  })();
</script>
