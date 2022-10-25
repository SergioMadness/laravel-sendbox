<?php namespace professionalweb\sendbox\Interfaces;

use professionalweb\sendbox\Interfaces\Services\AddressBook;

/**
 * Interface for service to work with Sendbox API
 */
interface SendboxAPI
{
    /**
     * Work with address books
     *
     * @return AddressBook
     */
    public function addressBooks(): AddressBook;
}