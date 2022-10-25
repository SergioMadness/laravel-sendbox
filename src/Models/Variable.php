<?php namespace professionalweb\sendbox\Models;

use professionalweb\sendbox\Interfaces\Models\Variable as IVariable;

/**
 * Variable model
 */
class Variable implements IVariable
{
    private string $name;

    private string $type;

    private $value;

    /**
     * @param string $name
     *
     * @return Variable
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return Variable
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return Variable
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get variable name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get variable type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get variable value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}