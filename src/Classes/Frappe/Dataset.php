<?php

namespace Nabcellent\Chartisan\Classes\Frappe;

use Nabcellent\Chartisan\Classes\DatasetClass;
use Nabcellent\Chartisan\Features\Frappe\Dataset as DatasetFeatures;

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

        $this->options([]);
    }

    /**
     * Formats the dataset for chartjs.
     *
     * @return array
     */
    public function format()
    {
        return array_merge($this->options, [
            'values' => $this->values,
            'name' => $this->name,
            'chartType' => $this->type,
        ]);
    }
}
