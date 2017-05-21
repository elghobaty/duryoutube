<?php namespace App\Youtube;

use Alaouy\Youtube\Youtube as AlaouyYoutube;
use StdClass;

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
    public function getPlaylistItems($playListId, $pageToken, $maxResults = 25, array $part = ['id'])
    {
        return $this->getPlaylistItemsByPlaylistId($playListId, $pageToken, $maxResults, $part);
    }

    /**
     * @param array $videoIds
     * @param array $part
     * @return array
     * @throws YoutubeRequestException
     */
    public function getVideos(array $videoIds = [], array $part = ['id'])
    {
        /**
         * @var array $ret
         */
        $ret = $this->getVideoInfo($videoIds, $part);

        return $ret;
    }

    /**
     * @param string $id
     * @param array $part
     * @return StdClass
     */
    public function findPlaylist($id, array $part = ['id'])
    {
        return $this->getPlaylistById($id, $part);
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
