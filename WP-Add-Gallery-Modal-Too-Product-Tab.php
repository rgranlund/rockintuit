
function woo_gallery_tab_content()
{
    // The other products tab content
    $gallery = get_field('gallery_tab');
    $size = 'thumbnail';
    $count = 1;
    $mod = 1;
    $thu = 1;
    if ($gallery) {
        echo '<h2>Gallery</h2>';
        // The new tab content

        echo '<div class="row">';

        foreach ($gallery as $image):
            // get ccustom fields
            //now show it
            echo '<div class="column">';
        echo '<img class="img-fluid hover-shadow cursor" src="' . esc_url($image['sizes']['thumbnail']) . '" alt="' . esc_attr($image['alt']) . '" onclick="openModal();currentSlide(' . $count . ')" />';
        echo '</div>';
        $count++;
        endforeach;
        echo '</div>';

        echo '<div id="myModal" class="modal">';
        echo '<span title="Close Gallery" class="close cursor" onclick="closeModal()">&times;</span>';
        echo '<div class="modal-content">';
        foreach ($gallery as $modal):
            // get ccustom fields
            //now show it
            echo '<div class="mySlides">';
        echo '<img class="img-fluid zoom" src="' . esc_url($modal['sizes']['large']) . '" alt="' . esc_attr($modal['alt']) . '"/>';
        echo '</div>';
        $mod++;
        endforeach;
        echo '<a class="prev" title="Previous Image" onclick="plusSlides(-1)">&#10094;</a>';
        echo '<a class="next" title="Next Image" onclick="plusSlides(1)">&#10095;</a>';
        /*
          echo '  <div class="caption-container"><p id="caption"></p></div>';

          echo '<div class="thumb-cont">';
          foreach ($gallery as $thumb):
          echo '<div class="column">';
          echo '<img class="img-fluid demo cursor" src="' . esc_url($thumb['sizes']['thumbnail']) . '" alt="' . esc_attr($thumb['alt']) . '" onclick="currentSlide(' . $thu . ')" />';
          echo '</div>';
          $thu++;
          endforeach;
          echo '</div>'; */
        echo '</div>';
        echo '</div>'; ?>
        <script>
            function openModal() {
                document.getElementById("myModal").style.display = "flex";
            }

            function closeModal() {
                document.getElementById("myModal").style.display = "none";
            }

            var slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
                showSlides(slideIndex += n);
            }

            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                //var dots = document.getElementsByClassName("demo");
                // var captionText = document.getElementById("caption");
                if (n > slides.length) {
                    slideIndex = 1
                }
                if (n < 1) {
                    slideIndex = slides.length
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                //for (i = 0; i < dots.length; i++) {
                //   dots[i].className = dots[i].className.replace(" active", "");
                //}
                slides[slideIndex - 1].style.display = "flex";
                // dots[slideIndex-1].className += " active";
                // captionText.innerHTML = dots[slideIndex-1].alt;
            }

            jQuery(function ($) {
                "use strict";
                $(".zoom").click(function () {
                    $(".zoom").toggleClass("zoomed");
                });
            });
        </script>
        <?php
    }
}