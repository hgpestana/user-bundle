<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'nelmio_alice.fixture_builder.expression_language.lexer.sub_patterns_lexer' shared service.

return $this->services['nelmio_alice.fixture_builder.expression_language.lexer.sub_patterns_lexer'] = new \Nelmio\Alice\FixtureBuilder\ExpressionLanguage\Lexer\SubPatternsLexer(${($_ = isset($this->services['nelmio_alice.fixture_builder.expression_language.lexer.reference_lexer']) ? $this->services['nelmio_alice.fixture_builder.expression_language.lexer.reference_lexer'] : ($this->services['nelmio_alice.fixture_builder.expression_language.lexer.reference_lexer'] = new \Nelmio\Alice\FixtureBuilder\ExpressionLanguage\Lexer\ReferenceLexer())) && false ?: '_'});
