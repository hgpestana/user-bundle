<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'nelmio_alice.fixture_builder.expression_language.parser.token_parser.chainable.tolerant_function_token_parser' shared service.

return $this->services['nelmio_alice.fixture_builder.expression_language.parser.token_parser.chainable.tolerant_function_token_parser'] = new \Nelmio\Alice\FixtureBuilder\ExpressionLanguage\Parser\TokenParser\Chainable\TolerantFunctionTokenParser(${($_ = isset($this->services['nelmio_alice.fixture_builder.expression_language.parser.token_parser.chainable.identity_token_parser']) ? $this->services['nelmio_alice.fixture_builder.expression_language.parser.token_parser.chainable.identity_token_parser'] : $this->load('getNelmioAlice_FixtureBuilder_ExpressionLanguage_Parser_TokenParser_Chainable_IdentityTokenParserService.php')) && false ?: '_'});
