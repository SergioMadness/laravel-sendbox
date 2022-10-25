<?php namespace professionalweb\sendbox\Models;

use professionalweb\sendbox\Interfaces\Models\Variable;
use professionalweb\sendbox\Interfaces\Models\Email as IEmail;

/**
 * E-mail model
 */
class Email implements IEmail
{
    private int $bookId;

    private string $email;

    private int $status;

    private array $variables;

    /**
     * @param int $bookId
     *
     * @return Email
     */
    public function setBookId(int $bookId): self
    {
        $this->bookId = $bookId;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return Email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param int $status
     *
     * @return Email
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param array $variables
     *
     * @return Email
     */
    public function setVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * Get address book id
     *
     * @return int
     */
    public function getBookId(): int
    {
        return $this->bookId;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get variables
     *
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}