<?php namespace professionalweb\sendbox\Models;

use professionalweb\sendbox\interfaces\Models\Error as IError;

/**
 * Class-wrapper for error
 * @package professionalweb\sendbox\Models
 */
class Error implements IError
{
    private int $code = 0;

    private string $message = '';

    public function __construct($code = 0, $message = '')
    {
        $this->setMessage($message)->setCode($code);
    }

    /**
     * Get error code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Get error message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return !empty($this->message) ? $this->message : $this->getCode();
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}