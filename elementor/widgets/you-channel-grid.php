<?php

class NezaYouChannelGrid extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'neza-you-channel-grid';
    }

    public function get_title()
    {
        return esc_html__('Youtube Channel Grid', 'neza');
    }

    public function get_icon()
    {
        return 'eicon-youtube';
    }

    public function get_categories()
    {
        return ['general'];
    }

    public function register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'neza'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Number of videos
        $this->add_control(
            'number_of_videos',
            [
                'label' => esc_html__('Number of Videos', 'neza'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        // Channel ID
        $this->add_control(
            'channel_id',
            [
                'label' => esc_html__('Channel ID', 'neza'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        // API key
        $this->add_control(
            'api_key',
            [
                'label' => esc_html__('API Key', 'neza'),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->end_controls_section();

        // Style
        $this->start_controls_section(
            'box_section',
            [
                'label' => esc_html__('Box Style', 'neza'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Register a new control for the flex-direction
        $this->add_control(
            'feeds_direction',
            [
                'label' => __('Grid Direction', 'neza'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'row' => __('Row', 'neza'),
                    'column' => __('Column', 'neza'),
                ],
                'default' => 'row',
            ]
        );

        // Feed direction
        $this->add_control(
            'feed_direction',
            [
                'label' => __('Feed Direction', 'neza'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'row' => __('Row', 'neza'),
                    'column' => __('Column', 'neza'),
                ],
                'default' => 'row',
            ]
        );

        $this->add_responsive_control(
            'you_feed_width',
            [
                'label' => __('Feed Width', 'neza'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .you-feed' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'you_feed_height',
            [
                'label' => __('Feed Height', 'neza'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .you-feed' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Background setting for .you-feed-img
        $this->add_control(
            'you_feed_img_background',
            [
                'label' => __('Image Background', 'neza'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .you-feed-img' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Stylize a.play-icon
        $this->add_control(
            'play_icon_styles',
            [
                'label' => __('Play Icon', 'neza'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'default' => __('Default', 'neza'),
                    'style1' => __('Style 1', 'neza'),
                    'style2' => __('Style 2', 'neza'),
                ],
                'default' => 'default',
                'selectors' => [
                    '{{WRAPPER}} .play-icon' => '/* Your play icon styles here */',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'video_content',
            [
                'label' => esc_html__('Video Content', 'neza'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography and color for h3.title in normal and hover state
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'neza'),
                'selector' => '{{WRAPPER}} h3.title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'neza'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h3.title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Title Hover Color', 'neza'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} h3.title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function neza_latest_youtube_videos($videolist_info)
    {
        $transient_key = $videolist_info['transient_key'];
        if (isset($videolist_info['transient_key']))
            $transient_key = 'test1';
        else
            $transient_key = 'latest_videos';

        if (isset($videolist_info['api_key']))
            $api_key = $videolist_info['api_key'];
        else
            return null;

        if (isset($videolist_info['channel_id']))
            $channel_id = $videolist_info['channel_id'];
        else
            return null;

        $count = 30;

        // Set the transient key for storing the JSON data

        $json_data = get_transient($transient_key);
        // Check if the JSON data is stored in the transient

        if (false === $json_data || intval($json_data['pageInfo']['resultsPerPage']) != intval($count)) {

            // Transient doesn't exist or has expired, fetch new data from YouTube API

            // Construct the API request URL
            $api_url = 'https://www.googleapis.com/youtube/v3/search?';
            $api_url .= 'channelId=' . $channel_id;
            $api_url .= '&order=date';
            $api_url .= '&maxResults=' . intval($count);
            $api_url .= '&part=snippet';
            $api_url .= '&key=' . $api_key;

            // Fetch the data from the API
            $response = wp_remote_get($api_url);

            // Check for errors in the API request
            if (is_wp_error($response)) {
                // Handle API request error
                return false;
            }

            // Get the response body
            $api_data = wp_remote_retrieve_body($response);

            // Decode the JSON data
            $json_data = json_decode($api_data, true);

            // Set the transient with the JSON data, valid for 24 hours
            set_transient($transient_key, $json_data, DAY_IN_SECONDS);

            // Extract the necessary data from the JSON
        }

        $videos = array();
        foreach ($json_data['items'] as $item) {
            $video_id = $item['id']['videoId'];
            $title = $item['snippet']['title'];
            $video_link = 'https://www.youtube.com/watch?v=' . $video_id;

            $videos[] = array(
                'video_id' => $video_id,
                'title' => $title,
                'video_link' => $video_link,
            );
        }
        return apply_filters('youtube_latest', $videos);
    }


    public function render()
    {
        // Get the widget settings.
        $settings = $this->get_settings();

        // Get the number of videos.
        $number_of_videos = $settings['number_of_videos'];

        // Get the channel ID.
        $channel_id = $settings['channel_id'];

        // Get the API key.
        $key = $settings['api_key'];

        // Get the latest YouTube videos.
        $feeds = $this->neza_latest_youtube_videos(
            [
                'transient_key' => 'neza_youtube_latest',
                'api_key' => $key,
                'channel_id' => $channel_id,
            ]
        );

?>

        <div class="you-channel-grid">
            <?php foreach ($feeds as $video) { ?>
                <div class="you-feed">
                    <div class="you-feed-img">
                        <a href="https://www.youtube.com/watch?v=<?= esc_attr($video['video_id']) ?>">
                            <img src="https://i.ytimg.com/vi/<?= esc_attr($video['video_id']) ?>/maxresdefault.jpg" alt="<?= esc_attr($video['title']) ?>">
                        </a>
                        <a class="play-icon" href="<?= esc_attr($video['video_link']) ?>" class="you-video-link"><i class="fas fa-play"></i></a>
                    </div>
                    <div class="you-feed-content">
                        <h3 class="title"><?= esc_html($video['title']) ?></h3>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php
    }
}
