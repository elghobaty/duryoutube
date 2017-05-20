<?php namespace App\Http\Controllers;

use App\Youtube\YouTubePlaylistService;
use App\Youtube\YoutubeRequestException;

class HomeController extends Controller
{
    /**
     * @var YouTubePlaylistService
     */
    private $service;

    /**
     * HomeController constructor.
     * @param YouTubePlaylistService $service
     */
    public function __construct(YouTubePlaylistService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        if ($playlistId = request('list', null)) {
            return $this->process($playlistId);
        }

        if ($playlistId = request('url', null)) {
            if (is_url($playlistId)) {
                if (is_null($playlistId = $this->service->parseIdFromUrl($playlistId))) {
                    return view('invalid-url');
                }
            }
            return $this->process($playlistId);
        }

        return view('home');
    }

    public function process($playlistId)
    {

        try {

            $data = $this->service->analyze($playlistId);

        } catch (YoutubeRequestException $e) {

            if ($e->getCode() === 403) {
                // @todo notify admin
                return view('try-again-later');
            }

            if ($e->isBecause("playlistNotFound")) {
                return view('playlist-not-found');
            }
            // @todo Test private & deleted playlists.

            // @todo notify admin
            return view('unknown-error');
        }

        $count = $data['totalCount'];
        $total = $data['totalDuration'];
        $average = $total / $count;
        $formattedTotal = $this->formatDuration($total);
        $formattedAverage = $this->formatDuration($average);

        return view('details', compact('formattedTotal', 'formattedAverage', 'count'));
    }

    /**
     * @param $seconds
     * @return string
     */
    protected function formatDuration($seconds)
    {
        $ret = "";

        if ($hours = floor($seconds / 3600)) {
            $ret .= '<span style="color: #1a732e;">' . number_format($hours) . '</span> H, ';
        }

        if ($minutes = floor(($seconds / 60) % 60)) {
            $ret .= '<span style="color: #ff3333;">' . sprintf("%02d", $minutes) . '</span> M, ';
        }

        if ($seconds = $seconds % 60) {
            $ret .= '<span style="color: #334dff;">' . sprintf("%02d", $seconds) . '</span> S, ';
        }

        return rtrim($ret, ' ,');
    }

}
