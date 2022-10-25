<?php namespace professionalweb\sendbox\Interfaces\Models;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Variable info
 */
interface Variable
{
    /**
     * Get variable name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get variable type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get variable value
     *
     * @return mixed
     */
    public function getValue();
}