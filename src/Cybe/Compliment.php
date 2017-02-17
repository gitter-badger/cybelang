<?php

namespace MemMemov\Cybe;

class Compliment
{
    private $id;
    private $phrases;

    public function __construct(
        int $id,
        Phrases $phrases
    ) {
        $this->id = $id;
        $this->phrases = $phrases;
    }

    public function phrase(): Phrase
    {
        return $this->phrases->ofCompliment($this);
    }
}