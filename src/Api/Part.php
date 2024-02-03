<?php
/*
 * Part.php
 * @author Martin Appelmann <hello@martin-appelmann.de>
 * @copyright 2024 Martin Appelmann
 */

namespace Exlo89\LaravelSevdeskApi\Api;

use Exlo89\LaravelSevdeskApi\Api\Utils\ApiClient;
use Exlo89\LaravelSevdeskApi\Api\Utils\Routes;
use Illuminate\Support\Collection;

/**
 * Sevdesk Part Api
 *
 * @see https://api.sevdesk.de/#tag/Part
 */
class Part extends ApiClient
{
    // =========================== all ====================================

    /**
     * Return all credit notes.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Collection::make($this->_get(Routes::PART));
    }
}
