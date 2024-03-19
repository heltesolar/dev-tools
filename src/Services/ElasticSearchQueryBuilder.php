<?php

namespace Helte\DevTools\Services;

class ElasticSearchQueryBuilder
{
    protected array $query = [];
    protected array $aggregations = [];
    protected $from;
    protected $size;
    protected $track_total_hits;

    public function match(string $field, $value, string $operator = 'must'): self
    {
        $this->query['bool'][$operator][] = ['match' => [$field => $value]];
        return $this;
    }

    public function term(string $field, $value, string $operator = 'must'): self
    {
        $this->query['bool'][$operator][] = ['term' => [$field => $value]];
        return $this;
    }

    public function bool(): self
    {
        $this->query['bool'] = [];
        return $this;
    }

    public function addAggregation(string $name, string $type, string $field, array $aggregation = []): self
    {
        if(! empty($aggregation)){
            $this->aggregations[$name]['aggs'] = $aggregation;
            return $this;
        }
        $this->aggregations[$name]['aggs'] = [$type => ['field' => $field]];
        return $this;
    }

    public function sumAggregation(string $name, string $field): self
    {
        $this->aggregations[$name] = ['sum' => ['field' => $field]];
        return $this;
    }

    public function minAggregation(string $name, string $field): self
    {
        $this->aggregations[$name] = ['min' => ['field' => $field]];
        return $this;
    }

    public function maxAggregation(string $name, string $field): self
    {
        $this->aggregations[$name] = ['max' => ['field' => $field]];
        return $this;
    }

    public function from(int $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function size(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function trackTotalHits(bool $track_total_hits): self
    {
        $this->track_total_hits = $track_total_hits;
        return $this;
    }

    public function build(): array
    {
        $query = [];
        if (!empty($this->query)) {
            $query['query'] = $this->query;
        }

        $aggs = [];
        if (!empty($this->aggregations)) {
            $aggs['aggs'] = $this->aggregations;
        }

        $params = [];
        if ($this->from !== null) {
            $params['from'] = $this->from;
        }
        if ($this->size !== null) {
            $params['size'] = $this->size;
        }
        if ($this->track_total_hits !== null) {
            $params['track_total_hits'] = $this->track_total_hits;
        }

        $finalQuery = array_merge($query, $aggs);

        if (!empty($params)) {
            $finalQuery['params'] = $params;
        }

        return $finalQuery;
    }
}