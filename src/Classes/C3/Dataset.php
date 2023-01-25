<?php

namespace Nabcellent\Chartisan\Classes\C3;

use Nabcellent\Chartisan\Classes\DatasetClass;
use Nabcellent\Chartisan\Features\C3\Dataset as DatasetFeatures;

class Dataset extends DatasetClass
{
    use DatasetFeatures;

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
    public function format()
    {
        return array_merge([$this->name], $this->values);
    }
}
