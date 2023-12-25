<?php

// use YouTube\YouTubeDownloader;

/**
 * Plugin Name: MC YouTube Video Downloader
 * Version: 0.1.0
 * Description: A simple and powerfull WP plugin to download youtube videos with quality.
 * Author: Muhammad Saim
 * Author URI: https://muhammadsaim.com
 * Requires PHP: 7.1
 * License: GPLv2 or later
 * Requires PHP: 7.1
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

// check plugin is initilaized through WP
if (!defined('ABSPATH')) {
    header('Location: /');
    die();
}

/**
 * A WP Plugin class to download youtube video
 */
if (!class_exists('Mc_YT_Video_Downloader')) {
    class Mc_YT_Video_Downloader
    {
        public $yt_video_id;
        public $yt_thumbnail_url;
        public $yt_sample_video;
        public $youtube_dl;
        public $youtube_api;

        /**
         * load the all required data and vendor
         */
        public function __construct()
        {
            $this->yt_sample_video = '';
            $this->yt_thumbnail_url = 'https://i3.ytimg.com/vi/';
            $this->yt_video_id = '';
            // $this->youtube_dl = new YouTubeDownloader();
            $this->youtube_api = 'https://youtube.com/get_video_info';

            // load composer's autoload
            // if (file_exists(trailingslashit(plugin_dir_path(__FILE__)) . 'vendor/autoload.php')) {
            //     require_once trailingslashit(plugin_dir_path(__FILE__)) . 'vendor/autoload.php';
            // }

            //shortcode
            add_shortcode('Mc_YouTube_Video_Downloader', [$this, 'mc_shortcode_video_downloader']);
        }

        /**
         * create a shorcode for plugin
         *
         * @param array $atts
         */
        public function mc_shortcode_video_downloader($atts)
        {
            ob_start();
            extract(
                shortcode_atts(
                    [
                        'text' => 'Get',
                    ],
                    $atts,
                    'Mc_YouTube_Video_Downloader'
                )
            );
            $this->mc_youtube_render_downloader($text);
            return ob_get_clean();
        }

        public function mc_youtube_render_downloader($text)
        {
            // css
            wp_enqueue_style('mc-youtube-video-downloader-style', trailingslashit(plugin_dir_url(__FILE__)) . 'assets/css/style.css', [], null, 'all');
            // js
            wp_enqueue_script('mona-youtube-video-downloader-script', trailingslashit(plugin_dir_url(__FILE__)) . 'assets/js/script.js', ['jquery'], true);

            ?>
<h1 class="mc-youtube-video-downloader-h1">Mc YouTube Video Downloader
    <?= $text ?>
</h1>
<?php }

        /**
         * extract youtube video id from the youtube vide URL
         *
         * @param $link
         * @return void
         */
        public function mc_get_youtube_id($link)
        {
            preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $id);
            if (!empty($id)) {
                return $id = $id[0];
            }
            return $link;
        }
    }
    new Mc_YT_Video_Downloader();
}// end if condition to check class already exists
?>