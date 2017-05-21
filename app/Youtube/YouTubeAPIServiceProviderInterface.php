<?php namespace App\Youtube;

use stdClass;

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
    public function getPlaylistItems($playListId, $pageToken, $maxResults = 25, array $part = ['id']);

    /**
     * @param array $videoIds
     * @param array $part
     * @return array
     * @throws YoutubeRequestException
     */
    public function getVideos(array $videoIds = [], array $part = ['id']);

    /**
     * @param string $id
     * @param array $part
     * @return StdClass
     * @throws YoutubeRequestException
     */
    public function findPlaylist($id, array $part = ['id']);
}
