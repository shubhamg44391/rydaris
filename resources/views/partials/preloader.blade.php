<style>
    #preloaderVideo {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: block;
        z-index: 2;
        object-position: center;
        object-fit: contain; /* Mobile: shows the entire video, preventing cropping */
    }
    @media (min-width: 992px) {
        #preloaderVideo {
            object-fit: cover; /* Desktop: covers the full screen */
        }
    }
</style>

<div id="sitePreloader" class="site-preloader" style="display:none; opacity:0; position:fixed; top:0; left:0; right:0; bottom:0; width:100vw; height:100vh; height:100dvh; background:#050711; z-index:999999; overflow:hidden;">
    <div class="preloader-spinner">
        <div class="spinner-circle"></div>
        <span>Loading</span>
    </div>
    <video id="preloaderVideo" src="{{ asset('assets/loader/loader.mp4') }}" playsinline webkit-playsinline preload="auto"></video>
</div>

<script>
  (function() {
    var SHOULD_PLAY_LOGIN_VIDEO = @json(session()->has('login_success_preloader'));

    // Video loader only plays AFTER successful Login or Register
    if (!SHOULD_PLAY_LOGIN_VIDEO) return;

    function playLoaderVideo() {
      var loader = document.getElementById('sitePreloader');
      var video  = document.getElementById('preloaderVideo');

      if (!loader || !video) return;

      loader.style.cssText = 'display:block !important; opacity:1 !important; position:fixed; top:0; left:0; right:0; bottom:0; width:100vw; height:100vh; height:100dvh; z-index:999999; background:#050711; overflow:hidden; transition:opacity 0.5s ease;';

      var finished = false;
      function hideLoader() {
        if (finished) return;
        finished = true;
        loader.style.opacity = '0';
        setTimeout(function() {
          loader.style.display = 'none';
        }, 500);
      }

      // Hide preloader ONLY when video plays completely to the end
      video.addEventListener('ended', hideLoader);

      video.currentTime = 0;
      video.muted = false;
      var playPromise = video.play();
      if (playPromise !== undefined) {
        playPromise.catch(function(error) {
          console.warn("Video preloader unmuted play blocked. Trying muted.", error);
          video.muted = true;
          video.play().catch(function(err) {
            console.error("Muted video play failed.", err);
            hideLoader();
          });
        });
      }

      // Safety net only (25 seconds) in case of network loading failure
      setTimeout(function() {
        if (!finished) hideLoader();
      }, 25000);
    }

    document.addEventListener('DOMContentLoaded', function() {
      playLoaderVideo();
    });
  })();
</script>
