<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'nelmio_alice.property_accessor.std' shared service.

return $this->services['nelmio_alice.property_accessor.std'] = new \Nelmio\Alice\PropertyAccess\StdPropertyAccessor(${($_ = isset($this->services['property_accessor']) ? $this->services['property_accessor'] : $this->load('getPropertyAccessorService.php')) && false ?: '_'});
