<?php

namespace App\Radan\Config\Storage;

/**
 * Storage Interface
 *
 */
interface StorageInterface
{
    /**
     * Save the specific key & value
     *
     * @param string $key
     * @param string|array $value
     * @return void
     */
    public function save($key, $value);

    /**
     * Load all of the values from storage
     *
     * @return array
     */
    public function load();

    /**
     * Clear all of the collected config
     *
     * @return void
     */
    public function clear();
}
