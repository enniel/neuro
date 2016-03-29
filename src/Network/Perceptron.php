<?php

namespace Neural\Network;

use Neural\Factory;
use Neural\Neuron\Neuron;
use Neural\Neuron\ResultNeuron;
use Neural\Neuron\Sensor;
use Neural\Neuron\Synapse;

class Perceptron extends AbstractNetwork {
    private $defaultOptions = [
        'threshold' => 0.5,
        'sensor.count' => 3,
        'neuron.count' => 3,
        'learning.rate' => 0.1
    ];
    private $options = [];
    private $hasCorrections = false;
    private $sensors = [];
    private $neurons = [];
    public function __construct($options) {
        $options = array_merge($this->defaultOptions, $options);
        $this->threshold = $options['threshold'];
        $this->learningRate = $options['learning.rate'];
        $this->sensors = Factory::createSensors($options['sensor.count']);
        $this->neurons = Factory::createNeurons($options['neuron.count']);;
        $this->result = new ResultNeuron();
        $this->options = $options;
        Factory::createSynapses($this->sensors, $this->neurons);
        Factory::createSynapses($this->neurons, [$this->result], 1);
    }

    public function putData(array $data)
    {
        /**
         * @var Sensor $sensor
         */
        foreach($data as $key => $signal) {
            $sensor = $this->sensors[$key];
            $sensor->putSignal($signal);
        }

        return $this->getResult();
    }

    public function getResult()
    {
        /**
         * @var Neuron $neuron
         */
        foreach ($this->neurons as $neuron) {
            $neuron->putSignal((($neuron->getSummarySignal() - $this->threshold) > 0)  ? 1 : 0);
        }
        return $this->result->getResult();
    }

    public function train($data, $expectedValue) {
        $result = $this->putData($data);

        if ($result !== $expectedValue) {
            $this->neurons[$expectedValue]->correctInputSynapses($this->learningRate);
            $this->hasCorrections = true;
            if (isset($this->neurons[$result])) {
                $this->neurons[$result]->correctInputSynapses(-1 * $this->learningRate);
            }
        }
    }

    public function learn(array $rows)
    {
        $this->hasCorrections = true;
        while ($this->hasCorrections) {
            $this->hasCorrections = false;

            foreach ($rows as $row) {
                list($data, $expectedValue) = $row;
                $this->train($data, $expectedValue);
            }
        }
    }

    public function toJson()
    {
        $data = [];
        $weights = [];
        /**
         * @var Sensor $sensor
         * @var Synapse $synapse
         */
        foreach ($this->sensors as $sensor) {
            $weightsRow = [];
            foreach($sensor->getOutputSynapses() as $synapse) {
                $weightsRow[] = $synapse->getWeight();
            }
            $weights[] = $weightsRow;
        }

        $data['weights'] = $weights;
        $data['options'] = $this->options;
        return json_encode($data);
    }

    public function setupWeights($weights)
    {
        /**
         * @var Sensor $sensor
         * @var Synapse $synapse
         */
        foreach ($this->sensors as $key => $sensor) {
            $weightsRow = $weights[$key];
            foreach($sensor->getOutputSynapses() as $i => $synapse) {
                $synapse->setWeight($weightsRow[$i]);
            }
        }
    }
} 