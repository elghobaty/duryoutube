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
            return view('details', compact('playlistId'));
        }

        if ($playlistId = request('url', null)) {
            $playlistId = is_url($playlistId) ? $this->service->parseIdFromUrl($playlistId) : $playlistId;
            if (is_null($playlistId)) {
                return view('home', ['error' => "Invalid Playlist URL."]);
            }
            return view('details', compact('playlistId'));
        }
        return view('home');
    }

    public function process($playlistId)
    {
        try {

            $data = $this->service->analyze($playlistId);

        } catch (YoutubeRequestException $e) {

            if ($e->isBecause("playlistItemsNotAccessible", "playlistForbidden")) {
                return [
                    'error' => [
                        'title' => 'Unauthorized Access',
                        'body' => 'We cannot access this playlist because of unauthorized access.<br /><br />Is it private?'
                    ]
                ];
            }

            if ($e->isBecause("playlistNotFound")) {
                return [
                    'error' => [
                        'title' => 'Invalid Playlist ID.',
                        'body' => 'Invalid Playlist URL / ID.'
                    ]
                ];
            }

            // @todo notify admin
            if ($e->getCode() === 403) {
                return [
                    'error' => [
                        'title' => 'Temporarily Unavailable.',
                        'body' => 'Something went wrong, we are looking into it.<br />Please try again later.'
                    ]
                ];
            }

            return [
                'error' => [
                    'title' => 'Unexpected Error.',
                    'body' => 'An unexpected error was encountered.'
                ]
            ];
        }

        $count = $data['totalCount'];
        $total = $data['totalDuration'];
        $average = $count ? $total / $count : null;

        return [
            'count' => number_format($count),
            'total' => $this->formatDuration($total),
            'average' => $this->formatDuration($average),
            'title' => $data['title'],
            'image' => $data['image']
        ];
    }

    /**
     * @param int $seconds
     * @return string
     */
    protected function formatDuration($seconds)
    {
        if (is_null($seconds)) {
            return '<em>N/A</em>';
        }

        $ret = seconds_to_time($seconds);

        $string = "<span style='color: #bb0000; font-weight: bold;'>%d</span> days, "
            . "<span style='color: #bb0000; font-weight: bold;'>%d</span> hours, "
            . "<span style='color: #bb0000; font-weight: bold;'>%02d</span> minutes, "
            . "and <span style='color: #bb0000; font-weight: bold;'>%02d</span> seconds.";

        return sprintf($string, $ret['d'], $ret['H'], $ret['i'], $ret['s']);
    }
}
