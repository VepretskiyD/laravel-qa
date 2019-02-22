<?php

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2'                                 => true,
        '@PHP70Migration'                       => true,
        '@DoctrineAnnotation'                   => true,
        'single_import_per_statement'           => false,
        'align_multiline_comment'               => true,
        'blank_line_after_opening_tag'          => true,
        'cast_spaces'                           => true,
        'lowercase_cast'                        => true,
        'combine_consecutive_issets'            => true,
        'combine_consecutive_unsets'            => true,
        'function_typehint_space'               => true,
        'magic_constant_casing'                 => true,
        'method_separation'                     => true,
        'native_function_casing'                => true,
        'no_blank_lines_after_class_opening'    => true,
        'no_empty_comment'                      => true,
        'no_empty_phpdoc'                       => true,
        'no_empty_statement'                    => true,
        'no_extra_consecutive_blank_lines'      => true,
        'no_leading_namespace_whitespace'       => true,
        'no_spaces_around_offset'               => true,
        'no_trailing_comma_in_list_call'        => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports'                     => true,
        'no_useless_else'                       => true,
        'no_useless_return'                     => true,
        'no_whitespace_before_comma_in_array'   => true,
        'no_whitespace_in_blank_line'           => true,
        'object_operator_without_whitespace'    => true,
        'phpdoc_indent'                         => true,
        'phpdoc_order'                          => true,
        'phpdoc_single_line_var_spacing'        => true,
        'phpdoc_to_comment'                     => true,
        'phpdoc_trim'                           => true,
        'phpdoc_types'                          => true,
        'return_type_declaration'               => true,
        'self_accessor'                         => true,
        'single_quote'                          => true,
        'ternary_operator_spaces'               => true,
        'trim_array_spaces'                     => true,
        'unary_operator_spaces'                 => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->in(__DIR__)
            ->exclude([
                'bootstrap/cache',
                'public',
                'resources',
                'storage',
                'vendor',
            ])
            ->notName('_ide_helper.php')
    )
;

try {
    PhpCsFixer\FixerFactory::create()
        ->registerBuiltInFixers()
        ->registerCustomFixers($config->getCustomFixers())
        ->useRuleSet(new PhpCsFixer\RuleSet($config->getRules()));
} catch (PhpCsFixer\ConfigurationException\InvalidConfigurationException $e) {
    $config->setRules([]);
} catch (UnexpectedValueException $e) {
    $config->setRules([]);
} catch (InvalidArgumentException $e) {
    $config->setRules([]);
}

return $config;
