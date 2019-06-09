<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'nelmio_alice.file_parser.registry' shared service.

return $this->services['nelmio_alice.file_parser.registry'] = new \Nelmio\Alice\Parser\ParserRegistry([0 => ${($_ = isset($this->services['nelmio_alice.file_parser.chainable.yaml']) ? $this->services['nelmio_alice.file_parser.chainable.yaml'] : $this->load('getNelmioAlice_FileParser_Chainable_YamlService.php')) && false ?: '_'}, 1 => ${($_ = isset($this->services['nelmio_alice.file_parser.chainable.php']) ? $this->services['nelmio_alice.file_parser.chainable.php'] : ($this->services['nelmio_alice.file_parser.chainable.php'] = new \Nelmio\Alice\Parser\Chainable\PhpParser())) && false ?: '_'}, 2 => ${($_ = isset($this->services['nelmio_alice.file_parser.chainable.json']) ? $this->services['nelmio_alice.file_parser.chainable.json'] : ($this->services['nelmio_alice.file_parser.chainable.json'] = new \Nelmio\Alice\Parser\Chainable\JsonParser())) && false ?: '_'}]);
