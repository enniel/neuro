<?php

namespace Neural\Neuron;


class ResultNeuron extends Neuron
{
    public function getResult()
    {
        /**
         * @var Synapse $synapse
         */
        foreach ($this->input as $key => $synapse) {
            if ($synapse->getSignal()) return $key;
        }

        return -1;
    }
} 