<?php

namespace Spatie\Analytics;

use Google_Service_Analytics;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class Analytics
{
    use Macroable;

    /** @var \Spatie\Analytics\AnalyticsClient */
    protected $client;

    /** @var string */
    protected $viewId;

    /**
     * @param \Spatie\Analytics\AnalyticsClient $client
     * @param string                            $viewId
     */
    public function __construct(AnalyticsClient $client, string $viewId)
    {
        $this->client = $client;

        $this->viewId = $viewId;
    }

    /**
     * @param string $viewId
     *
     * @return $this
     */
    public function setViewId(string $viewId)
    {
        $this->viewId = $viewId;

        return $this;
    }

    public function getViewId()
    {
        return $this->viewId;
    }

    public function fetchTotalVisitorsFromURL(Period $period,$startdate,$enddate,$slug): Collection
    {
        $response = $this->performQuery(
            $period,
            'ga:sessions',
            [
                'metrics' => 'ga:pageviews, ga:uniquePageviews',
                'dimensions' => 'ga:date',
                'filters' => 'ga:pagePath==/'.$slug,
                'start-date' => $startdate,
                'end-date' => $enddate,
            ]
        );
        return collect($response['rows'] ?? [])->map(fn (array $dateRow) => [
            'date' => date("d-m-Y", strtotime($dateRow[0])),
            'visitors' => (int) $dateRow[1],
            'uniquevisitors' => (int) $dateRow[2],
        ]);
    }

    public function fetchtopCountries(Period $period,$startdate,$enddate,$slug, int $maxResults = 5000): Collection
    {
        $response = $this->performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:country',
                'sort' => '-ga:sessions',
                'filters' => 'ga:pagePath==/'.$slug,
                'start-date' => $startdate,
                'end-date' => $enddate,
            ],
        );
        
        $topCountries = collect($response['rows'] ?? [])->map(fn (array $countryRow) => [
            'country' => $countryRow[0],
            'sessions' => (int) $countryRow[1],
        ]);

        if ($topCountries->count() <= $maxResults) {
            return $topCountries;
        }

        return $this->summarizetopCountries($topCountries, $maxResults);
    }

    protected function summarizetopCountries(Collection $topCountries, int $maxResults): Collection
    {
        return $topCountries
            ->take($maxResults - 1)
            ->push([
                'country' => 'Others',
                'sessions' => $topCountries->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    public function fetchtopDevices(Period $period,$startdate,$enddate,$slug, int $maxResults = 5000): Collection
    {
        $response = $this->performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:deviceCategory',
                'sort' => '-ga:sessions',
                'filters' => 'ga:pagePath==/'.$slug,
                'start-date' => $startdate,
                'end-date' => $enddate,
            ],
        );

        $topDevices = collect($response['rows'] ?? [])->map(fn (array $devicesRow) => [
            'devices' => $devicesRow[0],
            'sessions' => (int) $devicesRow[1],
        ]);

        if ($topDevices->count() <= $maxResults) {
            return $topDevices;
        }

        return $this->summarizetopDevices($topDevices, $maxResults);
    }

    protected function summarizetopDevices(Collection $topDevices, int $maxResults): Collection
    {
        return $topDevices
            ->take($maxResults - 1)
            ->push([
                'devices' => 'Others',
                'sessions' => $topDevices->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    public function fetchtopOS(Period $period,$startdate,$enddate,$slug, int $maxResults = 5000): Collection
    {
        $response = $this->performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:operatingSystem',
                'sort' => '-ga:sessions',
                'filters' => 'ga:pagePath==/'.$slug,
                'start-date' => $startdate,
                'end-date' => $enddate,
            ],
        );

        $topOS = collect($response['rows'] ?? [])->map(fn (array $osRow) => [
            'os' => $osRow[0],
            'sessions' => (int) $osRow[1],
        ]);

        if ($topOS->count() <= $maxResults) {
            return $topOS;
        }

        return $this->summarizetopOS($topOS, $maxResults);
    }

    protected function summarizetopOS(Collection $topOS, int $maxResults): Collection
    {
        return $topOS
            ->take($maxResults - 1)
            ->push([
                'os' => 'Others',
                'sessions' => $topOS->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    public function fetchTopBrowsers(Period $period,$startdate,$enddate,$slug, int $maxResults = 5000): Collection
    {
        $response = $this->performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:browser',
                'sort' => '-ga:sessions',
                'filters' => 'ga:pagePath==/'.$slug,
                'start-date' => $startdate,
                'end-date' => $enddate,
            ],
        );

        $topBrowsers = collect($response['rows'] ?? [])->map(fn (array $browserRow) => [
            'browser' => $browserRow[0],
            'sessions' => (int) $browserRow[1],
        ]);

        if ($topBrowsers->count() <= $maxResults) {
            return $topBrowsers;
        }

        return $this->summarizeTopBrowsers($topBrowsers, $maxResults);
    }

    protected function summarizeTopBrowsers(Collection $topBrowsers, int $maxResults): Collection
    {
        return $topBrowsers
            ->take($maxResults - 1)
            ->push([
                'browser' => 'Others',
                'sessions' => $topBrowsers->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    public function fetchtopLanguages(Period $period,$startdate,$enddate,$slug, int $maxResults = 5000): Collection
    {
        $response = $this->performQuery(
            $period,
            'ga:sessions',
            [
                'dimensions' => 'ga:Language',
                'sort' => '-ga:sessions',
                'filters' => 'ga:pagePath==/'.$slug,
                'start-date' => $startdate,
                'end-date' => $enddate,
            ],
        );

        $topLanguages = collect($response['rows'] ?? [])->map(fn (array $languagesRow) => [
            'languages' => $languagesRow[0],
            'sessions' => (int) $languagesRow[1],
        ]);

        if ($topLanguages->count() <= $maxResults) {
            return $topLanguages;
        }

        return $this->summarizetopLanguages($topLanguages, $maxResults);
    }

    protected function summarizetopLanguages(Collection $topLanguages, int $maxResults): Collection
    {
        return $topLanguages
            ->take($maxResults - 1)
            ->push([
                'languages' => 'Others',
                'sessions' => $topLanguages->splice($maxResults - 1)->sum('sessions'),
            ]);
    }

    /**
     * Call the query method on the authenticated client.
     *
     * @param Period $period
     * @param string $metrics
     * @param array  $others
     *
     * @return array|null
     */
    public function performQuery(Period $period, string $metrics, array $others = [])
    {
        return $this->client->performQuery(
            $this->viewId,
            $period->startDate,
            $period->endDate,
            $metrics,
            $others
        );
    }

    /*
     * Get the underlying Google_Service_Analytics object. You can use this
     * to basically call anything on the Google Analytics API.
     */
    public function getAnalyticsService(): Google_Service_Analytics
    {
        return $this->client->getAnalyticsService();
    }
}
