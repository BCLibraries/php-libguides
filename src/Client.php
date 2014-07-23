<?php

namespace BCLib\LibGuides;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Client
 *
 * A LibGuides v2 client
 */
class Client
{
    /**
     * @var HttpClient
     */
    private $http;

    private $site_id;
    private $base_url = 'http://lgapi.libapps.com';
    private $site_url;

    /**
     * @param            $site_id
     * @param string     $site_url
     * @param string     $version
     * @param HttpClient $http custom Guzzle client (for testing)
     *
     * @throws \Exception
     */
    public function __construct($site_id, $site_url, $version = '1.0', HttpClient $http = null)
    {
        if (is_null($http)) {
            $http = new HttpClient();
        };

        $this->http = $http;
        $this->site_id = $site_id;
        $this->site_url = $site_url;

        $valid_versions = ['1.0'];
        if (!in_array($version, $valid_versions)) {
            throw new \Exception("$version is not a valid API version");
        }

        $this->base_url = $this->base_url . "/$version";
    }

    /**
     * Get a info for guides
     *
     * @param array     $guide_ids      guide IDs to fetch; an empty list returns all guides
     * @param bool      $only_published only get published guides?
     * @param \DateTime $updated_since  if set, only return guides updated after this DateTime
     *
     * @return Guide[] an array of guides
     */
    public function getGuides(array $guide_ids = [], $only_published = false, \DateTime $updated_since = null)
    {
        $url = $this->base_url . "/guides";
        $url .= sizeof($guide_ids) ? '/' . join(',', $guide_ids) : '';
        $guides = $this->get('BCLib\LibGuides\Guide', [$this->site_url], $url);

        if ($only_published) {
            $guides = array_filter($guides, [$this, 'guideIsPublished']);
        }

        if (!is_null($updated_since)) {
            $guides = $this->filterGuidesOlderThan($guides, $updated_since);
        }

        return $guides;
    }

    private function get($extract_to, array $object_params = [], $url)
    {
        $url .= "?site_id=" . $this->site_id;
        $response = $this->http->get($url)->json();

        $extraction_mapper = function ($json_array) use ($extract_to, $object_params) {

            $reflect = new \ReflectionClass($extract_to);

            if (sizeof($object_params) > 0) {
                $object = $reflect->newInstanceArgs($object_params);
            } else {
                $object = $reflect->newInstance();
            }

            foreach ($json_array as $key => $val) {
                $object->{$key} = $val;
            }
            return $object;
        };

        return array_map($extraction_mapper, $response);
    }

    private function guideIsPublished(Guide $guide)
    {
        return $guide->status === '1';
    }

    private function filterGuidesOlderThan(array $guides, \DateTime $date)
    {
        return array_filter(
            $guides,
            function (Guide $guide) use ($date) {
                return ($date < new \DateTime($guide->updated));
            }
        );
    }
}