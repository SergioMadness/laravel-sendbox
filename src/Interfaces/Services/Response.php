<?php namespace professionalweb\sendbox\interfaces\Services;

/**
 * Interface for Sendsay API response
 * @package professionalweb\sendbox\interfaces\Services
 */
interface Response
{
    /**
     * Check request failed
     *
     * @return bool
     */
    public function isError(): bool;

    /**
     * Check redirect needed
     *
     * @return bool
     */
    public function needRedirect(): bool;

    /**
     * Get URL for redirect
     *
     * @return string
     */
    public function getRedirectUrl(): string;

    /**
     * Get response
     *
     * @return mixed
     */
    public function getData();

    /**
     * Get errors
     *
     * @return array
     */
    public function getError(): array;
}