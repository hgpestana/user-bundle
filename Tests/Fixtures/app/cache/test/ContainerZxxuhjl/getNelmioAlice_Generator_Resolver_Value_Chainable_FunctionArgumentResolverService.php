<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'nelmio_alice.generator.resolver.value.chainable.function_argument_resolver' shared service.

return $this->services['nelmio_alice.generator.resolver.value.chainable.function_argument_resolver'] = new \Nelmio\Alice\Generator\Resolver\Value\Chainable\FunctionCallArgumentResolver(${($_ = isset($this->services['nelmio_alice.generator.resolver.value.chainable.php_value_resolver']) ? $this->services['nelmio_alice.generator.resolver.value.chainable.php_value_resolver'] : $this->load('getNelmioAlice_Generator_Resolver_Value_Chainable_PhpValueResolverService.php')) && false ?: '_'});
