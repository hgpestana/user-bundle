<?php
declare(strict_types = 1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Helper\Setter;

/**
 * Defines specific update methods.
 *
 * @author Hélder Pestana <hgpestana@gmail.com>
 */
interface SetterInterface
{
    /**
     * Updates the object with the data in the array and returns it.
     *
     * @param mixed $object
     * @param array $data
     *
     * @return object
     */
    public function set($object, array $data);
}
