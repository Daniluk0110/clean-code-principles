<?php

namespace CodeSmells\Examples;

class InappropriateIntimacy
{
    /**
     * Motorist and Engine are "too intimate". 
     * Motorist accesses private or internal state of Engine directly.
     */
}

class Motorist
{
    public function startEngine(Engine $engine): void
    {
        // Direct access to engine state and internal mechanisms
        $engine->fuelLevel -= 10;
        $engine->isStarted = true;
        $engine->sparkPlugs->fire();
    }
}

class Engine
{
    public int $fuelLevel = 100; // Should be private
    public bool $isStarted = false; // Should be private
    public $sparkPlugs; // Should be internal

    public function __construct()
    {
        $this->sparkPlugs = new class {
            public function fire() { echo "Sparking!"; }
        };
    }
}
