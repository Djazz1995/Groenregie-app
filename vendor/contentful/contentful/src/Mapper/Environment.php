<?php

/**
 * This file is part of the contentful/contentful package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Delivery\Mapper;

use Contentful\Delivery\Resource\Environment as ResourceClass;

/**
 * Environment class.
 *
 * This class is responsible for converting raw API data into a PHP object
 * of class Contentful\Delivery\Resource\Environment.
 */
class Environment extends BaseMapper
{
    /**
     * {@inheritdoc}
     */
    public function map($resource, array $data)
    {
        return $this->hydrate($resource ?: ResourceClass::class, [
            'sys' => $this->buildSystemProperties($data['sys']),
            'locales' => \array_map(function ($locale) {
                return $this->builder->build($locale);
            }, $data['locales']),
        ]);
    }
}
