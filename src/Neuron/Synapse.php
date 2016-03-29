<?php

namespace Neural\Neuron;


class Synapse {
    private $in;
    private $out;
    private $weight;
    private $signal;

    public function __construct(Neuron $in, Neuron $out, $weight = 0)
    {
        $this->in = $in;
        $this->out = $out;
        $this->weight = $weight;
        $in->addOutputSynapse($this);
        $out->addInputSynapse($this);
    }

    public function putSignal($signal)
    {
        $this->signal = $signal;
    }

    public function getSignal()
    {
        return $this->signal * $this->weight;
    }

    public function getRawSignal()
    {
        return $this->signal;
    }

    public function increaseWeight($delta)
    {
        echo "Correcting weight on {$delta}; ";

        $this->weight += $delta;
        echo "Weight: {$this->weight}\n";
    }

    public function decreaseWeight($delta)
    {
        $this->weight -= $delta;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
} 