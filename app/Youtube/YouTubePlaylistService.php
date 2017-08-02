<?php namespace App\Youtube;

use DateInterval;

class YouTubePlaylistService
{
    /**
     * @var YouTubeAPIServiceProviderInterface
     */
    private $provider;

    /**
     * PlaylistService constructor.
     * @param YouTubeAPIServiceProviderInterface $provider
     */
    public function __construct(YouTubeAPIServiceProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param $playlistId
     * @return array
     */
    public function analyze($playlistId)
    {
        /**
         * Fetch the playlist items first to handle exceptions.
         */
        $items = $this->getPlaylistDurationSummary($playlistId);

        return array_merge($this->getPlaylist($playlistId), $items);
    }

    /**
     * @param $playlistId
     * @return array
     */
    public function getPlaylist($playlistId)
    {
        $playlist = $this->provider->findPlaylist($playlistId, $part = ['snippet']);

        return [
            'title' => $playlist->snippet->title,
            'image' => $playlist->snippet->thumbnails->medium
        ];
    }

    /**
     * @param $playListId
     * @return array
     */
    public function getPlaylistDurationSummary($playListId)
    {
        $nextPageToken = '';
        $totalCount = 0;
        $totalDuration = 0;

        do {
            $playlistItems = $this->provider->getPlaylistItems($playListId, $nextPageToken, $maxResults = 50,
                $part = ['snippet']);

            if ($playlistItems['results']) {
                $videoIds = $this->extractVideoIdsFromPlaylist($playlistItems['results']);
                $videoDurations = $this->getVideoDurationsInSeconds($videoIds);
                $totalCount += count($videoIds);
                $totalDuration += array_sum($videoDurations);
            }

        } while ($nextPageToken = $playlistItems['info']['nextPageToken']);

        return compact('totalCount', 'totalDuration');
    }

    /**
     * @param $playListId
     * @return array
     */
    public function getPlaylistDurationDetails($playListId)
    {
        $ret = [];
        $nextPageToken = '';
        do {
            $playlistItems = $this->provider->getPlaylistItems($playListId, $nextPageToken, $maxResults = 50, $part = ['snippet']);

            if ($playlistItems['results']) {
                $videoIds = $this->extractVideoIdsFromPlaylist($playlistItems['results']);
                $videosInfo = array_values($this->provider->getVideos($videoIds, ['contentDetails']));
                for ($i = 0; $i < count($videosInfo); $i++) {
                    $ret[$videosInfo[$i]->id] = [
                        'name' => $playlistItems['results'][$i]->snippet->title,
                        'duration' => $this->parseDuration($videosInfo[$i]->contentDetails->duration)
                    ];
                }
            }

        } while ($nextPageToken = $playlistItems['info']['nextPageToken']);

        return $ret;
    }

    /**
     * @param array $playlistItems
     * @return array
     */
    protected function extractVideoIdsFromPlaylist(array $playlistItems)
    {
        return array_map(function ($result) {
            return $result->snippet->resourceId->videoId;
        }, $playlistItems);
    }

    /**
     * @param $videoIds
     * @return array
     */
    protected function getVideoDurationsInSeconds($videoIds)
    {
        $videosInfo = array_values($this->provider->getVideos($videoIds, ['contentDetails']));

        return array_map(function ($video) {
            return $this->parseDuration($video->contentDetails->duration);
        }, $videosInfo);
    }

    /**
     * @param $duration
     * @return int
     */
    protected function parseDuration($duration)
    {
        $days = intval((new DateInterval($duration))->format('%d'));
        $hours = intval((new DateInterval($duration))->format('%H'));
        $minutes = intval((new DateInterval($duration))->format('%i'));
        $seconds = intval((new DateInterval($duration))->format('%s'));

        return $seconds + 60 * $minutes + 3600 * $hours + 86400 * $days;
    }

    /**
     * @param $url
     * @return string|null
     */
    public function parseIdFromUrl($url)
    {
        if (!$query = parse_url($url, PHP_URL_QUERY)) {
            return null;
        }

        parse_str($query, $params);
        return $params['list'] ?? null;
    }
}
