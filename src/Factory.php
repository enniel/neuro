<?php

namespace Neural;

use Neural\Network\AbstractNetwork;
use Neural\Network\Perceptron;
use Neural\Neuron\Sensor;
use Neural\Neuron\Neuron;
use Neural\Neuron\Synapse;

class Factory {
    static public function createPerceptron($params = array())
    {
        return new Perceptron($params);
    }

    static public function createPerceptronFromJson($json)
    {
        $data = json_decode($json, JSON_OBJECT_AS_ARRAY);
        $perceptron = new Perceptron($data['options']);
        $perceptron->setupWeights($data['weights']);

        return $perceptron;
    }

    static public function createSensors($count, AbstractNetwork $network)
    {
        $sensors = [];

        for ($i = 0; $i < $count; $i++) {
            $sensors[] = new Sensor($network);
        }

        return $sensors;
    }

    static public function createNeurons($count, AbstractNetwork $network)
    {
        $neurons = [];

        for ($i = 0; $i < $count; $i++) {
            $neurons[] = new Neuron($network);
        }

        return $neurons;
    }

    static public function createSynapses(array $layer1, array $layer2, $weight = 0, AbstractNetwork $network)
    {
        foreach ($layer1 as $neuron1) {
            foreach ($layer2 as $neuron2) {
                new Synapse($neuron1, $neuron2, $weight, $network);
            }
        }
    }
} 