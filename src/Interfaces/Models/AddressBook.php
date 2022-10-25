<?php namespace professionalweb\sendbox\Interfaces\Models;

/**
 * Address book model
 */
interface AddressBook
{
    public const STATUS_ACTIVE = 0;

    public const STATUS_INACTIVE = 1;

    /**
     * Get book id
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Get book name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get email quantity
     *
     * @return int
     */
    public function getEmailQty(): int;

    /**
     * Get active emails quantity
     *
     * @return int
     */
    public function getActiveEmailQty(): int;

    /**
     * Get inactive emails quantity
     *
     * @return int
     */
    public function getInactiveEmailQty(): int;

    /**
     * Get creation date
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;
}