<?php


if(!class_exists('Inferno_Preview')) {
    class Inferno_Preview {

        private $output;

        /**
         * @var $args array()
         * $args['link'] 'image' | 'post'
         * todo: change img_width to width and img_height to height
         */
        public function __construct($src = false, $width = false, $height = false, $effect = 'default', $link = false, $crop = true)
        { 
            global $post;

            if(!$width && !$height) $width = 250;

            $output = null;

            if(!$src && !has_post_thumbnail()) return false;

            if(!$src) {
                $thumb_id = get_post_thumbnail_id($post->ID);
                $thumb = wp_get_attachment_image_src($thumb_id, 'full');
                $src = $thumb[0];
            }

            $thumb_url = aq_resize($src, $width, $height, true, true, true);
            ob_start();

            if($permalink) echo '<a href="' . $permalink . '" class="inferno-preview ' . $effect . '">';
            else echo '<div class="inferno-preview ' . $effect . '">';

            switch($effect) {
                case 'fold':
                    $this->template($template_hover, 'fold');
                    //$this->preview_fold($thumb_url);
                    break;
                case 'flip':
                    $this->preview_flip($thumb_url);
                    echo '<div class="back">';
                    //$this->template($template_hover, 'flip');
                    echo '</div>';
                    break;
                default:
                    //$this->template($template_hover);
                    $this->preview_default($thumb_url);
                    break;
            }
            if($permalink) echo '</a>';
            else echo '</div>';

            $output = ob_get_contents();
            $this->output = $output;
            ob_end_clean();
        }

        public function get_output() 
        {
            return $this->output;
        }


        private function preview_fold($img_url)
        {
            ?>
            <div class="panel panel1" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <div class="panel panel2" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <div class="panel panel3" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <div class="panel panel4shadow"></div>
            <div class="panel panel4" style="background-image: url(<?php echo $img_url; ?>);">
                <div class="overlay"></div>
            </div>
            <img src="<?php echo $img_url ?>" alt="" class="fallback" />
            <?php
        }

        private function preview_flip($img_url)
        {
            ?>
            <div class="front">
                <img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" />
            </div>
            <?php
        }

        private function preview_default($img_url)
        {
            ?>
            <img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" />
            <?php
        }
    }
}