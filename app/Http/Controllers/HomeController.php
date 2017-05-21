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
                    return $this->displayHomepage('Playlist Not Found', 'Invalid Playlist ID');
                }
            }
            return $this->process($playlistId);
        }

        return $this->displayHomepage();
    }

    public function process($playlistId)
    {

        try {

            $data = $this->service->analyze($playlistId);

        } catch (YoutubeRequestException $e) {

            if ($e->isBecause("playlistItemsNotAccessible")) {
                return $this->displayHomepage('Unauthorized Access.', 'We cannot access this playlist because of unauthorized access.<br /><br />Is it private?');
            }

            if ($e->isBecause("playlistNotFound")) {
                return $this->displayHomepage('Playlist Not Found', 'Invalid Playlist URL / ID.');
            }

            // @todo notify admin
            if ($e->getCode() === 403) {
                return $this->displayHomepage('Temporarily Unavailable', 'Something went wrong, we are looking into it.<br />Please try again later');
            }

            // @todo notify admin
            return $this->displayHomepage('Unexpected Error', 'An unexpected error was encountered.');
        }

        $count = $data['totalCount'];
        $total = $data['totalDuration'];
        $average = $count ? $total / $count : null;
        $formattedTotal = $this->formatDuration($total);
        $formattedAverage = $this->formatDuration($average);

        $title = 'Playlist Duration';
        return view('details', compact('formattedTotal', 'formattedAverage', 'count', 'title'));
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

    /**
     * @param string $title
     * @param string $error
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function displayHomepage($title = '', $error = '')
    {
        return view('home', compact('title', 'error'));
    }

}
