<?php

namespace App\Radan\Config\Modifiers;

use App\Radan\Config\Modifiers\Modifier;
use Illuminate\Support\Collection as BaseCollection;

/**
 * Modifier collection
 *
 */
class Collection extends BaseCollection
{
    /**
     * @var array list of keys that have been modified
     */
    private $keys = [];
    
    /**
     * Convert the value based on the supplied modifiers
     *
     * @param  string $key       [description]
     * @param  mixed $value     [description]
     * @param  string $direction [description]
     * @return mixed            [description]
     */
    public function convert($key, $value, $direction = Modifier::DIRECTION_TO)
    {
        $convertMethod = 'convert'.ucfirst($direction);
        $canMethod = 'canHandle'.ucfirst($direction);
        foreach ($this->items as $modifier) {
            if ($modifier->$canMethod($value)) {
                $this->keys[] = $key;
                return $modifier->$convertMethod($value);
            }
        }
        return $value;
    }
}
