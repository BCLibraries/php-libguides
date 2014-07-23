<?php

namespace BCLib\LibGuides;

/**
 * Class Guide
 *
 * A container for guide info.
 */
class Guide
{
    public $id;
    public $type_id;
    public $site_id;
    public $owner_id;
    public $name;
    public $description;
    public $status;
    public $time_published;
    public $created;
    public $updated;
    public $redirect_url;
    public $count_hit;
    private $base_url;

    public function __construct($base_url)
    {
        $this->base_url = $base_url;
    }

    /**
     * Get a link to a guide
     *
     * @return string the full URL to a guide
     */
    public function link()
    {
        return $this->base_url . '/c.php?g=' . $this->id;
    }
}