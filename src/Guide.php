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
}