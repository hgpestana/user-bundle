<?php
declare(strict_types = 1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Helper\Mapper;

/**
 * Defines specific mapping methods.
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 */
class BasicKeyMapper implements MapperInterface
{
    /**
     * Basic key mapper
     *
     * @param string $data
     *
     * @return string
     *
     */
    public function map(string $data)
    {
        $name = preg_replace('/[A-Z]/', "_" . '\\0', $data);
        return strtolower($name);
    }

}