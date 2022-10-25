<?php namespace professionalweb\sendbox\Interfaces\Services;

use professionalweb\sendbox\Interfaces\Models\Email;
use professionalweb\sendbox\Interfaces\Models\AddressBook as IAddressBookModel;

/**
 * Service to work with address books
 */
interface AddressBook
{
    public const METHOD_CREATE_ADDRESS_BOOK = '/addressbooks';

    public const METHOD_UPDATE_ADDRESS_BOOK = '/addressbooks/{id}';

    public const METHOD_GET_ADDRESS_BOOKS = '/addressbooks';

    public const METHOD_GET_ADDRESS_BOOK_BY_ID = '/addressbooks/{id}';

    public const METHOD_DELETE_ADDRESS_BOOK_BY_ID = '/addressbooks/{id}';

    public const METHOD_GET_ADDRESS_BOOK_VARIABLES = '/addressbooks/{id}/variables';

    public const METHOD_ADD_EMAIL_TO_ADDRESS_BOOK = '/addressbooks/{id}/emails';

    public const METHOD_REMOVE_EMAILS = '/addressbooks/{id}/emails';

    public const METHOD_GET_EMAIL = '/addressbooks/{id}/emails/{email}';

    /**
     * Create address book
     *
     * @param string $name
     *
     * @return int
     */
    public function createAddressBook(string $name): int;

    /**
     * Set address book name
     *
     * @param int    $id
     * @param string $name
     *
     * @return bool
     */
    public function updateAddressBook(int $id, string $name): bool;

    /**
     * Get address books
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function get(int $limit = 100, int $offset = 0): array;

    /**
     * Get address book by id
     *
     * @param int $id
     *
     * @return IAddressBookModel
     */
    public function getById(int $id): IAddressBookModel;

    /**
     * Delete address book by id
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get address book variables
     *
     * @param int $id
     *
     * @return array
     */
    public function getVariables(int $id): array;

    /**
     * Add emails to address book
     *
     * @param int   $id
     * @param array $emails
     *
     * @return bool
     */
    public function addEmails(int $id, array $emails): bool;

    /**
     * Add events to address book with confirmation
     *
     * @param int    $id
     * @param array  $emails
     * @param string $senderEmail
     *
     * @return bool
     */
    public function addEmailsWithConfirmation(int $id, array $emails, string $senderEmail): bool;

    /**
     * Delete emails from address book
     *
     * @param int   $id
     * @param array $emails
     *
     * @return bool
     */
    public function deleteEmails(int $id, array $emails): bool;

    /**
     * Get email info
     *
     * @param int    $id
     * @param string $email
     *
     * @return Email
     */
    public function getEmail(int $id, string $email): Email;
}