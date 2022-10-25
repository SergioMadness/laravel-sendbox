<?php namespace professionalweb\sendbox\Traits;

use professionalweb\sendbox\Interfaces\Services\Protocol;

/**
 * For classes need protocol
 */
trait UseProtocol
{
    private Protocol $protocol;

    /**
     * @return Protocol
     */
    public function getProtocol(): Protocol
    {
        return $this->protocol;
    }

    /**
     * @param Protocol $protocol
     *
     * @return static
     */
    public function setProtocol(Protocol $protocol): self
    {
        $this->protocol = $protocol;

        return $this;
    }
}