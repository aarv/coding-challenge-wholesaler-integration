<?php

return PhpCsFixer\Config::create()
  ->setRules([
      '@Symfony' => true,
      'concat_space' => ['spacing' => 'one'],
      'trailing_comma_in_multiline_array' => false,
      'array_syntax' => ['syntax' => 'short'],
      'logical_operators' => true,
      'yoda_style' => null,
      'increment_style' => ['style' => 'post'],
      'array_indentation' => true,
      'blank_line_before_statement' => [
          'statements' => [
              'break',
              'continue',
              'declare',
              'return',
              'throw',
              'try',
              'if',
              'for',
              'foreach',
              'switch',
              'while'
          ]
      ],
      'class_attributes_separation' => [
        'elements' => ['method', 'property']
      ],
      'method_argument_space' => [
        'on_multiline' => 'ensure_fully_multiline',
      ],
      'no_unneeded_final_method' => true
  ]);