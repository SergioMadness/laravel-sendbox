<?php namespace professionalweb\sendbox\Models;

use professionalweb\sendbox\Interfaces\Models\AddressBook as IAddressBook;

/**
 * Address book model
 */
class AddressBook implements IAddressBook
{
    private int $id;

    private string $name;

    private int $emailQty = 0;

    private int $activeEmailQty = 0;

    private int $inactiveEmailQty = 0;

    private \DateTime $createdAt;

    private int $status;

    public function __construct(string $name = '')
    {
        $this->setName($name);
    }

    /**
     * @param string $name
     *
     * @return AddressBook
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return AddressBook
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param int $emailQty
     *
     * @return AddressBook
     */
    public function setEmailQty(int $emailQty): self
    {
        $this->emailQty = $emailQty;

        return $this;
    }

    /**
     * @param int $activeEmailQty
     *
     * @return AddressBook
     */
    public function setActiveEmailQty(int $activeEmailQty): self
    {
        $this->activeEmailQty = $activeEmailQty;

        return $this;
    }

    /**
     * @param int $inactiveEmailQty
     *
     * @return AddressBook
     */
    public function setInactiveEmailQty(int $inactiveEmailQty): self
    {
        $this->inactiveEmailQty = $inactiveEmailQty;

        return $this;
    }

    /**
     * @param \DateTime|string $createdAt
     *
     * @return AddressBook
     * @throws \Exception
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = is_string($createdAt) ? new \DateTime($createdAt) : $createdAt;

        return $this;
    }

    /**
     * @param int $status
     *
     * @return AddressBook
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get book name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get book id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get email quantity
     *
     * @return int
     */
    public function getEmailQty(): int
    {
        return $this->emailQty;
    }

    /**
     * Get active emails quantity
     *
     * @return int
     */
    public function getActiveEmailQty(): int
    {
        return $this->activeEmailQty;
    }

    /**
     * Get inactive emails quantity
     *
     * @return int
     */
    public function getInactiveEmailQty(): int
    {
        return $this->inactiveEmailQty;
    }

    /**
     * Get creation date
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
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