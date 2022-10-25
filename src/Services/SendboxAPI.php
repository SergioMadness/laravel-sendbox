<?php namespace professionalweb\sendbox\Services;

use professionalweb\sendbox\Interfaces\Services\AddressBook;
use professionalweb\sendbox\Interfaces\SendboxAPI as ISendboxAPI;

/**
 * Main service to work with Sendbox API
 */
class SendboxAPI implements ISendboxAPI
{

    /**
     * Work with address books
     *
     * @return AddressBook
     */
    public function addressBooks(): AddressBook
    {
        return app(AddressBook::class);
    }
}