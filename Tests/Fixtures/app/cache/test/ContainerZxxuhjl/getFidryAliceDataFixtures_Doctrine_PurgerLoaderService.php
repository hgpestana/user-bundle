<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'fidry_alice_data_fixtures.doctrine.purger_loader' shared service.

return $this->services['fidry_alice_data_fixtures.doctrine.purger_loader'] = new \Fidry\AliceDataFixtures\Loader\PurgerLoader(${($_ = isset($this->services['fidry_alice_data_fixtures.doctrine.persister_loader']) ? $this->services['fidry_alice_data_fixtures.doctrine.persister_loader'] : $this->load('getFidryAliceDataFixtures_Doctrine_PersisterLoaderService.php')) && false ?: '_'}, ${($_ = isset($this->services['fidry_alice_data_fixtures.persistence.doctrine.purger.purger_factory']) ? $this->services['fidry_alice_data_fixtures.persistence.doctrine.purger.purger_factory'] : $this->load('getFidryAliceDataFixtures_Persistence_Doctrine_Purger_PurgerFactoryService.php')) && false ?: '_'}, 'delete', ${($_ = isset($this->services['logger']) ? $this->services['logger'] : ($this->services['logger'] = new \Symfony\Component\HttpKernel\Log\Logger())) && false ?: '_'});
