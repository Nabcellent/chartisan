<?php

namespace Nabcellent\Charts\Classes\C3;

use Illuminate\Support\Collection;
use Nabcellent\Charts\Classes\BaseChart;
use Nabcellent\Charts\Features\C3\Chart as ChartFeatures;

class Chart extends BaseChart
{
    use ChartFeatures;

    /**
     * C3 dataset class.
     *
     * @var object
     */
    public $dataset = Dataset::class;

    /**
     * Initiates the C3 Line Chart.
     *
     * @return self
     */
    public function __construct()
    {
        parent::__construct();

        $this->container = 'charts::c3.container';
        $this->script = 'charts::c3.script';

        return $this;
    }

    /**
     * Formats the datasets.
     *
     * @return void
     */
    public function formatDatasets()
    {
        $datasets = Collection::make($this->datasets);

        return json_encode([
            'columns' => Collection::make($this->datasets)
                ->each(function ($dataset) {
                    $dataset->matchValues(count($this->labels));
                })
                ->map(function ($dataset) {
                    return $dataset->format($this->labels);
                })
                ->toArray(),
            'type' => $datasets->first()->type,
            'types' => $datasets->mapWithKeys(function ($d) {
                return [$d->name => $d->type];
            })->toArray(),
        ]);
    }
}
