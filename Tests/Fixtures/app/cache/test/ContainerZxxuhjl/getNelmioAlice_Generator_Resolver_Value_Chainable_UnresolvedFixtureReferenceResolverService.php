<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'nelmio_alice.generator.resolver.value.chainable.unresolved_fixture_reference_resolver' shared service.

return $this->services['nelmio_alice.generator.resolver.value.chainable.unresolved_fixture_reference_resolver'] = new \Nelmio\Alice\Generator\Resolver\Value\Chainable\UnresolvedFixtureReferenceIdResolver(${($_ = isset($this->services['nelmio_alice.generator.resolver.value.chainable.self_fixture_reference_resolver']) ? $this->services['nelmio_alice.generator.resolver.value.chainable.self_fixture_reference_resolver'] : $this->load('getNelmioAlice_Generator_Resolver_Value_Chainable_SelfFixtureReferenceResolverService.php')) && false ?: '_'});
