<?php namespace App\Youtube;

use Alaouy\Youtube\Youtube as AlaouyYoutube;

class Youtube extends AlaouyYoutube implements YouTubeAPIServiceProviderInterface
{
    /**
     * @param string $playListId
     * @param string $pageToken
     * @param int $maxResults
     * @param array $part
     * @return array
     * @throws YoutubeRequestException
     */
    public function getPlaylistItems($playListId, $pageToken, $maxResults = 25, array $part = [])
    {
        return $this->getPlaylistItemsByPlaylistId($playListId, $pageToken, $maxResults, $part);
    }

    /**
     * @param array $videoIds
     * @param array $part
     * @return array
     * @throws YoutubeRequestException
     */
    public function getVideos(array $videoIds = [], array $part = [])
    {
        /**
         * @var array $ret
         */
        $ret = $this->getVideoInfo($videoIds, $part);

        return $ret;
    }

    /**
     * @param string $apiData
     * @return array
     * @throws YoutubeRequestException
     */
    public function decodeList(&$apiData)
    {
        $resObj = json_decode($apiData);
        if (isset($resObj->error)) {
            throw YoutubeRequestException::FromResponse($resObj);
        }

        return parent::decodeList($apiData);
    }
}
