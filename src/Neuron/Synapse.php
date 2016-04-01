<?php

namespace Neural\Neuron;

use Neural\Network\AbstractNetwork;
/**
 * Class Synapse
 * @package Neural\Neuron
 * @property AbstractNetwork $network
 */
class Synapse {
    private $in;
    private $out;
    private $weight;
    private $signal;
    private $network;

    public function __construct(Neuron $in, Neuron $out, $weight = 0, AbstractNetwork $network)
    {
        $this->in = $in;
        $this->out = $out;
        $this->weight = $weight;
        $this->network = $network;
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
        $this->network->log('Change weight on ' . $delta);
        $this->weight += $delta;
        $this->network->log('Weight: ' . $this->weight);
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