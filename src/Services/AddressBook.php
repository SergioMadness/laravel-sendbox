<?php namespace professionalweb\sendbox\Services;

use professionalweb\sendbox\Traits\UseProtocol;
use professionalweb\sendbox\Interfaces\Models\Email;
use professionalweb\sendbox\Models\Email as EmailModel;
use professionalweb\sendbox\Interfaces\Models\Variable;
use professionalweb\sendbox\Interfaces\Services\Protocol;
use professionalweb\sendbox\Models\Variable as VariableModel;
use professionalweb\sendbox\Models\AddressBook as AddressBookModel;
use professionalweb\sendbox\Interfaces\Services\AddressBook as IAddressBook;
use professionalweb\sendbox\Interfaces\Models\AddressBook as IAddressBookModel;

/**
 * Service to work with address books
 */
class AddressBook implements IAddressBook
{
    use UseProtocol;

    public function __construct(Protocol $protocol)
    {
        $this->setProtocol($protocol);
    }

    /**
     * Create address book
     *
     * @param string $name
     *
     * @return int
     * @throws \Exception
     */
    public function createAddressBook(string $name): int
    {
        $response = $this->getProtocol()->call(self::METHOD_CREATE_ADDRESS_BOOK, [
            'bookName' => $name,
        ]);

        if ($response->isError()) {
            throw new \Exception();
        }

        return (int)$response->getData();
    }

    /**
     * Set address book name
     *
     * @param int    $id
     * @param string $name
     *
     * @return bool
     * @throws \Exception
     */
    public function updateAddressBook(int $id, string $name): bool
    {
        $response = $this->getProtocol()->call(self::METHOD_UPDATE_ADDRESS_BOOK, [
            'id'   => $id,
            'name' => $name,
        ], 'put');

        if ($response->isError()) {
            throw new \Exception();
        }

        return $response->getData()['result'];
    }

    /**
     * Get address books
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     * @throws \Exception
     */
    public function get(int $limit = 100, int $offset = 0): array
    {
        $response = $this->getProtocol()->call(self::METHOD_GET_ADDRESS_BOOKS, [
            'limit'  => $limit,
            'offset' => $offset,
        ], 'get');

        if ($response->isError()) {
            throw new \Exception();
        }

        return array_map(function (array $bookData) {
            return $this->createAddressBookModel($bookData);
        }, $response->getData());
    }

    /**
     * Create model
     *
     * @param array $data
     *
     * @return IAddressBookModel
     * @throws \Exception
     */
    protected function createAddressBookModel(array $bookData): IAddressBookModel
    {
        return (new AddressBookModel())
            ->setName($bookData['name'])
            ->setEmailQty($bookData['all_email_qty'])
            ->setActiveEmailQty($bookData['active_email_qty'])
            ->setInactiveEmailQty($bookData['inactive_email_qty'])
            ->setCreatedAt($bookData['creationdate'])
            ->setStatus($bookData['status']);
    }

    /**
     * Get address book by id
     *
     * @param int $id
     *
     * @return IAddressBookModel
     * @throws \Exception
     */
    public function getById(int $id): IAddressBookModel
    {
        $response = $this->getProtocol()->call(self::METHOD_GET_ADDRESS_BOOK_BY_ID, [
            'id' => $id,
        ], 'get');

        $models = $response->getData();

        if (empty($models) || $response->isError()) {
            throw new \Exception();
        }

        return $this->createAddressBookModel($models[0]);
    }

    /**
     * Delete address book by id
     *
     * @param int $id
     *
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $response = $this->getProtocol()->call(self::METHOD_DELETE_ADDRESS_BOOK_BY_ID, [
            'id' => $id,
        ], 'delete');

        if ($response->isError()) {
            throw new \Exception();
        }

        return $response->getData()['result'];
    }

    /**
     * Get address book variables
     *
     * @param int $id
     *
     * @return array
     * @throws \Exception
     */
    public function getVariables(int $id): array
    {
        $response = $this->getProtocol()->call(self::METHOD_GET_ADDRESS_BOOK_VARIABLES, [
            'id' => $id,
        ], 'get');

        if ($response->isError()) {
            throw new \Exception();
        }

        return array_map(function (array $varData) {
            return $this->createVariableModel($varData);
        }, $response->getData());
    }

    /**
     * Create variable model
     *
     * @param array $data
     *
     * @return Variable
     */
    protected function createVariableModel(array $data): Variable
    {
        return (new VariableModel())
            ->setName($data['name'])
            ->setType($data['type'])
            ->setValue($data['value'] ?? null);
    }

    /**
     * Add emails to address book
     *
     * @param int   $id
     * @param array $emails
     *
     * @return bool
     * @throws \Exception
     */
    public function addEmails(int $id, array $emails): bool
    {
        $response = $this->getProtocol()->call(self::METHOD_ADD_EMAIL_TO_ADDRESS_BOOK, [
            'id'     => $id,
            'emails' => array_map(static function (Email $email) {
                $vars = $email->getVariables();
                $variables = [];
                foreach ($vars as $var) {
                    $variables[$var->getName()] = $var->getValue();
                }

                return [
                    'email'     => $email->getEmail(),
                    'variables' => $variables,
                ];
            }, $emails),
        ], 'post');

        if ($response->isError()) {
            throw new \Exception();
        }

        return $response->getData()['result'];
    }

    /**
     * Add events to address book with confirmation
     *
     * @param int    $id
     * @param array  $emails
     * @param string $senderEmail
     *
     * @return bool
     * @throws \Exception
     */
    public function addEmailsWithConfirmation(int $id, array $emails, string $senderEmail): bool
    {
        $response = $this->getProtocol()->call(self::METHOD_ADD_EMAIL_TO_ADDRESS_BOOK, [
            'id'           => $id,
            'confirmation' => 'force',
            'sender_email' => $senderEmail,
            'emails'       => array_map(static function (Email $email) {
                $vars = $email->getVariables();
                $variables = [];
                foreach ($vars as $var) {
                    $variables[$var->getName()] = $var->getValue();
                }

                return [
                    'email'     => $email->getEmail(),
                    'variables' => $variables,
                ];
            }, $emails),
        ], 'post');

        if ($response->isError()) {
            throw new \Exception();
        }

        return $response->getData()['result'];
    }

    /**
     * Delete emails from address book
     *
     * @param int   $id
     * @param array $emails
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteEmails(int $id, array $emails): bool
    {
        $response = $this->getProtocol()->call(self::METHOD_REMOVE_EMAILS, [
            'id'     => $id,
            'emails' => $emails,
        ], 'post');

        if ($response->isError()) {
            throw new \Exception();
        }

        return $response->getData()['result'];
    }

    /**
     * Get email info
     *
     * @param int    $id
     * @param string $email
     *
     * @return Email
     * @throws \Exception
     */
    public function getEmail(int $id, string $email): Email
    {
        $response = $this->getProtocol()->call(self::METHOD_REMOVE_EMAILS, [
            'id'    => $id,
            'email' => $email,
        ], 'get');

        if ($response->isError()) {
            throw new \Exception();
        }

        return $this->createEmailModel($response->getData());
    }

    /**
     * Create email model
     *
     * @param array $data
     *
     * @return Email
     */
    protected function createEmailModel(array $data): Email
    {
        return (new EmailModel())
            ->setEmail($data['email'])
            ->setBookId($data['abook_id'])
            ->setStatus($data['status'])
            ->setVariables(array_map(function (array $varData) {
                return $this->createVariableModel($varData);
            }, $data['variables']));
    }
}