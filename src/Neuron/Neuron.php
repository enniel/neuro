<?php

namespace Neural\Neuron;

class Neuron
{
    protected $input = [];
    protected $output = [];

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
        echo "+----\n";
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