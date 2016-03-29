<?php
/**
 * Created by PhpStorm.
 * User: y0rsh
 * Date: 18.03.16
 * Time: 19:44
 */

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