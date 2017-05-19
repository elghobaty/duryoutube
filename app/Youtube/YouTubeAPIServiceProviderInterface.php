<?php namespace App\Youtube;

interface YouTubeAPIServiceProviderInterface
{
    /**
     * @param string $playListId
     * @param string $pageToken
     * @param int $maxResults
     * @param array $part
     * @return array
     * @throws YoutubeRequestException
     */
    public function getPlaylistItems($playListId, $pageToken, $maxResults = 25, array $part = []);

    /**
     * @param array $videoIds
     * @param array $part
     * @return array
     * @throws YoutubeRequestException
     */
    public function getVideos(array $videoIds = [], array $part = []);
}
