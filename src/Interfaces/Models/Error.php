<?php namespace professionalweb\sendbox\Interfaces\Models;

/**
 * Interface for error response
 * @package professionalweb\sendbox\Interfaces\Models
 */
interface Error
{
    /**
     * Get error code
     *
     * @return string
     */
    public function getCode(): string;

    /**
     * Get error message
     *
     * @return string
     */
    public function getMessage(): string;
}