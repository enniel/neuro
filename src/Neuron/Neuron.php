<?php

namespace Neural\Neuron;

use Neural\Network\AbstractNetwork;
/**
 * Class Neuron
 * @package Neural\Neuron
 * @property AbstractNetwork $network
 */
class Neuron
{
    protected $input = [];
    protected $output = [];
    private $network;

    public function __configure(AbstractNetwork $network)
    {
        $this->network = $network;
    }

    public function addOutputSynapse(Synapse $synapse)
    {
        $this->output[] = $synapse;
    }

    public function addInputSynapse(Synapse $synapse)
    {
        $this->input[] = $synapse;
    }

    public function getSummarySignal()
    {
        /**
         * @var Synapse $synapse
         */
        $signal = 0;
        foreach ($this->input as $synapse) {
            $signal += $synapse->getSignal();
        }

        return $signal;
    }

    public function correctInputSynapses($delta)
    {
        /**
         * @var Synapse $synapse
         */
        foreach ($this->input as $synapse) {
            $synapse->increaseWeight($synapse->getRawSignal() * $delta);
        }
    }

    public function putSignal($signal)
    {
        /**
         * @var Synapse $synapse
         */
        foreach ($this->output as $synapse) {
            $synapse->putSignal($signal);
        }
    }

    public function getOutputSynapses()
    {
        return $this->output;
    }
} 