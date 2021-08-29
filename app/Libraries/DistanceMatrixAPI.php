<?php

namespace App\Libraries;

use App\Models\Facility;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

/**
 * Find distances between facilities
 * https://developers.google.com/maps/documentation/distance-matrix/start#maps_http_distancematrix_start-txt
 *
 * Class DistanceMatrixAPI
 */
class DistanceMatrixAPI
{
    private $origins;
    private $destinations;

    /**
     * DistanceMatrixAPI constructor.
     */
    public function __construct()
    {
        // GET API Key
        $this->api_key = env('GOOGLE_API_KEY');
    }

    private $uri = 'https://maps.googleapis.com/maps/api/distancematrix/json';
    private $api_key;
    public $result;

    /**
     * Fetch the distance between origin and destination
     *
     * @param $origins
     * @param $destinations
     * @return bool|$this
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetch($origins, $destinations)
    {
        // Set the details
        $this->origins = collect($origins);
        $this->destinations = collect($destinations);

        // Format origins and destinations
        $origins = $this->origins
            ->map(function ($a) {
                return urlencode($a);
            })
            ->join('|');
        $destinations = $this->destinations
            ->map(function ($a) {
                return urlencode($a);
            })
            ->join('|');

        // Fetch the distance matrix
        $c = new Client(['base_uri' => "{$this->uri}"]);
        $r = $c->request('GET', '', [
            'query' => [
                'origins' => $origins,
                'destinations' => $destinations,
                'units' => 'imperial',
                'key' => $this->api_key,
            ]
        ]);
        $this->result = json_decode($r->getBody());

        // Make sure request is valid
        if (!isset($this->result->rows[0])) {
            Log::info('Unable to get distance between: ' . $this->origins . ' ' . $this->destinations);
            return FALSE;
        }

        return $this;
    }

    /**
     * Returns the array of distances
     *
     * @return \Illuminate\Support\Collection
     */
    public function distances()
    {
        return collect($this->result->rows[0]->elements);
    }
}
