<?php

/*
 * This file is part of YaEtl.
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/YaEtl
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\YaEtl\Transformers\Arrays;

use fab2s\NodalFlow\YaEtlException;
use fab2s\YaEtl\Transformers\TransformerAbstract;

/**
 * Class ArrayWalkTransformer
 */
class ArrayWalkTransformer extends TransformerAbstract
{
    /**
     * Any callable with two argument which returns something
     *
     * @var callable
     */
    protected $callable;

    /**
     * @var mixed
     */
    protected $userdata;

    /**
     * @param callable   $callable Worth nothing to say that the first callback argument should
     *                             be a reference if you want anything to append to the record
     * @param null|mixed $userdata
     */
    public function __construct(callable $callable, $userdata = null)
    {
        $this->callable = $callable;
        $this->userdata = $userdata;
    }

    /**
     * Execute the array_map call
     *
     * @param mixed $record
     *
     * @return mixed
     */
    public function exec($record)
    {
        if (!\array_walk($this->callable, $record, $this->userdata)) {
            throw new YaEtlException('array_walk call failed', 1, null, [
                'record' => $record,
            ]);
        }

        return $record;
    }
}