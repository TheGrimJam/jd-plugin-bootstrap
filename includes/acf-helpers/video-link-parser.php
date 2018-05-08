<?php

/* Parser for vimeo, youtube, and other video links */

function jd_get_video_url($url) {
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $video_id = $match[1];
            $output = 'https://www.youtube.com/embed/' . $video_id . '?autoplay=1&frameborder=0';
            return $output;
    }
    else if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $match)) {
        $video_id = $match[5];
        return "https://player.vimeo.com/video/" . $match[5];
    }
    return false;
}
