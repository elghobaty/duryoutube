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
        return $this->getPlayListDurationSummary($playlistId);
    }

    /**
     * @param $playListId
     * @return array
     */
    protected function getPlayListDurationSummary($playListId)
    {
        $nextPageToken = '';
        $totalCount = 0;
        $totalDuration = 0;

        do {
            $playlistItems = $this->provider->getPlaylistItems($playListId, $nextPageToken, $maxResults = 50, $part = ['snippet']);

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
        $hours = intval((new DateInterval($duration))->format('%H'));
        $minutes = intval((new DateInterval($duration))->format('%i'));
        $seconds = intval((new DateInterval($duration))->format('%s'));

        return $seconds + 60 * $minutes + 3600 * $hours;
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
        return $params['list']?? null;
    }
}
