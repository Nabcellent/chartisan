<?php

namespace Nabcellent\Chartisan\Classes\Echarts;

use Illuminate\Support\Collection;
use Nabcellent\Chartisan\Classes\DatasetClass;
use Nabcellent\Chartisan\Features\Echarts\Dataset as DatasetFeatures;

class Dataset extends DatasetClass
{
    use DatasetFeatures;

    /**
     * Store the private datasets that contains a special formating.
     *
     * @var array
     */
    public $specialDatasets = ['pie'];

    /**
     * Creates a new dataset with the given values.
     *
     * @param  string  $name
     * @param  string  $type
     * @param  array  $values
     */
    public function __construct(string $name, string $type, array $values)
    {
        parent::__construct($name, $type, $values);
    }

    /**
     * Formats the dataset for chartjs.
     *
     * @return array
     */
    public function format(array $labels = [])
    {
        return array_merge($this->options, [
            'data' => $this->getValues($labels),
            'name' => $this->name,
            'type' => strtolower($this->type),
        ]);
    }

    /**
     * Get the formated values.
     *
     * @param  array  $labels
     * @return array
     */
    protected function getValues(array $labels)
    {
        if (in_array(strtolower($this->type), $this->specialDatasets)) {
            return Collection::make($this->values)
                ->map(function ($value, $key) use ($labels) {
                    return [
                        'name' => $labels[$key],
                        'value' => $value,
                    ];
                })->toArray();
        }

        return $this->values;
    }
}
