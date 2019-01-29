<?php
    //echo $this->Rss->header();
    if (!isset($channel)) {
        $channel = array();
    }
    if (!isset($channel['title'])) {
        $channel['title'] = $title_for_layout . ' - ' . Configure::read('site.name');
    }
    $channelEl = $this->Rss->channel(array(), $channel, $content_for_layout);
    echo $this->Rss->document(array(), $channelEl);
?>