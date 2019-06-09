<?php
declare(strict_types = 1);

/*
 * This file is part of hgpestana's user bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGPestana\UserBundle\Helper\Setter;


use HGPestana\UserBundle\Helper\Mapper\MapperInterface;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Serializer;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Used to update an object according to a specific parameter mapping.
 *
 * @modified Hélder Pestana <hgpestana@gmail.com>
 */
class BasicMappedSetter implements SetterInterface
{

    /** @var Serializer $serializer */
    private $serializer;

    /** @var MapperInterface $mapper */
    private $mapper;

    /**
     * MappedUpdater constructor.
     *
     * @param Serializer      $serializer
     * @param MapperInterface $mapper
     */
    public function __construct(Serializer $serializer, MapperInterface $mapper)
    {
        $this->serializer = $serializer;
        $this->mapper = $mapper;
    }

    /**
     * Updates the information of a specific object using a map function.
     *
     * @param mixed $object
     * @param array $data
     *
     * @return object
     */
    public function set($object, array $data)
    {
        /** @var array $propertyMetadata */
        $propertyMetadata = $this->serializer
            ->getMetadataFactory()
            ->getMetadataForClass(get_class($object))
            ->propertyMetadata;

        /** @var PropertyAccessor $accessor */
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ( $propertyMetadata as $key => $metaName ) {
            /**
             * @var string           $mappedName
             * @var PropertyMetadata $metaName ;
             */
            $mappedName = $this->mapper->map($metaName->name);

            if ( array_key_exists($mappedName, $data) ) {
                $accessor->setValue($object, $key, $data[ $mappedName ]);
            }
        }

        return $object;
    }
}