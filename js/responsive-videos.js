(function($) {
    // See https://css-tricks.com/NetMag/FluidWidthVideo/Article-FluidWidthVideo.php
    $(document).ready(function($) {
        // Get all videos.
        var $allVideos = $("iframe[src^='https://player.vimeo.com'], iframe[src^='https://www.youtube.com']"),
            $fluidEl = $(".entry-content"), // the fluid-width element.
            firstVideo = $allVideos.get(0),
            $firstVideoWrap = $(firstVideo).parents('p')

        // Save aspect ratio as data attributes for each video.
        $allVideos.each(function() {
          $(this).data('aspectRatio', this.height / this.width).removeAttr('height').removeAttr('width');
        });

        // Preserve aspect ratio on window resize.
        $(window).resize(function() {

          var newWidth = $fluidEl.width();

          // Resize all videos according to their own aspect ratio
          $allVideos.each(function() {
            var $el = $(this),
                aspectRatio = $el.data('aspectRatio')
            $el.width(newWidth).height(newWidth * aspectRatio);
          });

        // Kick off one resize to fix all videos on page load
        }).resize();

        // Keep video in view on page scroll.
        $(window).on('scroll', function() {
            var videoHeight = $firstVideoWrap.outerHeight(),
                windowScrollTop = $(window).scrollTop(),
                videoMiddle = (videoHeight / 2) + $firstVideoWrap.offset().top;

            if (windowScrollTop > videoMiddle) {
                $firstVideoWrap.height(videoHeight);
                $(firstVideo).addClass('stuck');
            } else {
                $firstVideoWrap.height('auto');
                $(firstVideo).removeClass('stuck');
            }
        });
    });
}(jQuery));
