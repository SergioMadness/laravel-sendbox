<?php namespace professionalweb\sendbox\Interfaces\Models;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Email data
 */
interface Email
{
    /**
     * Get address book id
     *
     * @return int
     */
    public function getBookId(): int;

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Get variables
     *
     * @return array|Variable[]
     */
    public function getVariables(): array;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;
}