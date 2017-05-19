<?php namespace App\Youtube\Playlist;

use DateInterval;
use App\Youtube\YoutubeRequestException;
use App\Youtube\YouTubeAPIServiceProviderInterface;

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
        try {
            return $this->getPlayListDurationSummary($playlistId);
        } catch (YoutubeRequestException $e) {
            $this->handlePlaylistException($e);
        }
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

            $videoIds = $this->extractVideoIdsFromPlaylist($playlistItems['results']);

            $videoDurations = $this->getVideoDurationsInSeconds($videoIds);

            $totalCount += count($videoDurations);
            $totalDuration += array_sum($videoDurations);

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
        $minutes = 60 * intval((new DateInterval($duration))->format('%i'));
        $seconds = intval((new DateInterval($duration))->format('%s'));

        return $seconds + 60 * $minutes + 3600 * $hours;
    }

    /**
     * @param YoutubeRequestException $e
     */
    protected function handlePlaylistException(YoutubeRequestException $e)
    {
        if ($e->isBecause("playlistNotFound")) {
            // Show playlist not found exception
        }

        // Test with private playlist?
        // Test with deleted playlist?


        if ($e->getCode() === 403) {
            // forbidden or quota exceeded.
            // display a try again later message to the user?
            // Swap apps?
            // Show captcha to users after x attempts in last 1 minute.
        }


        // Unhandled error. Notify Admin?
    }


}
