<section class="body-section clients">
  <div class="w-layout-blockcontainer body-container w-container">
    <div class="clients-holder">
      <div class="clients-holder-title">
        <div>Trusted by our clients:</div>
      </div>

      <?php
      $show_default = get_field('show_default');
      $items = $show_default
        ? get_field('client_carousel_logos', 'option')
        : get_field('client_carousel_logos');

      $logo_height = 40; // fixed display height
      $total_width = 0;
      $logo_imgs = [];

      if ($items) {
        foreach ($items as $item) {
          if (!empty($item['logos'])) {
            foreach ($item['logos'] as $inner) {
              if (!empty($inner['logo'])) {
                $logo = $inner['logo'];
                $url = is_array($logo) ? $logo['url'] : $logo;
                $image_id = is_array($logo) ? ($logo['ID'] ?? attachment_url_to_postid($url)) : attachment_url_to_postid($url);
                $meta = wp_get_attachment_metadata($image_id);

                if ($meta && isset($meta['width'], $meta['height']) && $meta['height'] > 0) {
                  $aspect_ratio = $meta['width'] / $meta['height'];
                  $scaled_width = $logo_height * $aspect_ratio;
                  $total_width += $scaled_width + 32;
                } else {
                  $total_width += 40 + 32;
                }

                $logo_imgs[] = [
                  'url' => $url,
                  'alt' => $inner['logo_name'] ?? '',
                ];
              }
            }
          }
        }
      }

      $loop_logos = array_merge($logo_imgs, $logo_imgs);// duplicate for smooth loop
      ?>

      <div data-w-id="49f10458-bffe-1815-1165-fdb4b11a82b6" class="clients-holder-track">
        <?php if (!empty($loop_logos)): ?>
          <div class="clients-holder-inner" style="min-width: <?php echo ceil($total_width * 2); ?>px;">
            <?php foreach ($loop_logos as $img): ?>
              <img
                src="<?php echo esc_url($img['url']); ?>"
                loading="lazy"
                alt="<?php echo esc_attr($img['alt']); ?>"
                class="client-logo sm"
              >
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>