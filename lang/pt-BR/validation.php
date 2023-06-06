<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'O :attribute deve ser aceito',
    'active_url' => ':attribute não é um URL válido.',
    'after' => ':attribute deve ser uma data posterior :date.',
    'after_or_equal' => ':attribute deve ser uma data posterior ou igual a :date.',
    'alpha' => ':attribute só pode conter letras.',
    'alpha_dash' => ':attribute só pode conter letras, números, traços e sublinhados.',
    'alpha_num' => ':attribute só pode conter letras e números.',
    'array' => ':attribute deve ser um array.',
    'before' => ':attribute deve ser uma data anterior a :date.',
    'before_or_equal' => ':attribute deve ser uma data anterior ou igual a :date.',
    'between' => [
        'numeric' => ':attribute deve estar entre :min e :max.',
        'file' => ':attribute deve estar entre :min e :max Kb.',
        'string' => ':attribute deve estar entre :min e :max caracteres.',
        'array' => ':attribute deve estar entre :min e :max itens.',
    ],
    'boolean' => ':attribute deve ser verdadeiro ou falso.',
    'confirmed' => ':attribute confirmação não corresponde.',
    'date' => ':attribute não é uma data válida.',
    'date_equals' => ':attribute deve ser uma data igual a :date.',
    'date_format' => ':attribute não corresponde ao formato :format.',
    'different' => ':attribute e :other deve ser diferente.',
    'digits' => ':attribute deve conter :digits digitos.',
    'digits_between' => ':attribute deve estar entre :min d :max digitos.',
    'dimensions' => ':attribute tem dimensões de imagem inválidas.',
    'distinct' => ':attribute tem valores duplicados.',
    'email' => ':attribute deve ser um endereço de email válido.',
    'ends_with' => ':attribute deve terminar com um dosfollowing: :values',
    'exists' => 'A opção :attribute selecionada é inválida.',
    'file' => ':attribute deve ser um arquivo.',
    'filled' => ':attribute deve ter um valor.',
    'gt' => [
        'numeric' => ':attribute deve ser maior que :value.',
        'file' => ':attribute deve ser maior que :value Kb.',
        'string' => ':attribute deve ser maior que :value caracteres.',
        'array' => ':attribute deve ter mais que :value itens.',
    ],
    'gte' => [
        'numeric' => ':attribute deve ser maior ou igual a  :value.',
        'file' => ':attribute deve ser maior ou igual a  :value Kb.',
        'string' => ':attribute deve ser maior ou igual a  :value caracteres.',
        'array' => ':attribute deve ter :value itens ou mais.',
    ],
    'image' => ':attribute deve ser uma imagem.',
    'in' => 'A opção :attribute selecionada é inválida.',
    'in_array' => ':attribute não existe em :other.',
    'integer' => ':attribute deve ser um número inteiro.',
    'ip' => ':attribute deve ser um endereço de IP válido.',
    'ipv4' => ':attribute deve ser um endereço de IPv4 válido.',
    'ipv6' => ':attribute deve ser um endereço de IPv6 válido.',
    'json' => ':attribute deve ser uma string JSON válida.',
    'lt' => [
        'numeric' => ':attribute deve ser maior que :value.',
        'file' => ':attribute deve ser maior que :value Kb.',
        'string' => ':attribute deve ser maior que :value caracteres.',
        'array' => ':attribute deve ter mais que :value itens.',
    ],
    'lte' => [
        'numeric' => ':attribute deve ser maior ou igual a :value.',
        'file' => ':attribute deve ser maior ou igual a :value Kb.',
        'string' => ':attribute deve ser maior ou igual a :value caracteres.',
        'array' => ':attribute não deve ter mais que :value itens.',
    ],
    'max' => [
        'numeric' => ':attribute não pode ser maior que :max.',
        'file' => ':attribute não pode ser maior que :max Kb.',
        'string' => ':attribute não pode ser maior que :max caracteres.',
        'array' => ':attribute não deve ter mais que :max itens.',
    ],
    'mimes' => ':attribute deve ser um arquivo de type: :values.',
    'mimetypes' => ':attribute deve ser um arquivo de type: :values.',
    'min' => [
        'numeric' => ':attribute deve ser pelo menos :min.',
        'file' => ':attribute deve ser pelo menos :min Kb.',
        'string' => ':attribute deve ser pelo menos :min caracteres.',
        'array' => ':attribute deve ter pelo menos :min itens.',
    ],
    'not_in' => 'A opção :attribute selecionada é inválida.',
    'not_regex' => ':attribute formato inválido.',
    'numeric' => ':attribute deve ser um número.',
    'present' => ':attribute deve estar presente.',
    'regex' => ':attribute formato inválido.',
    'required' => ':attribute campo obrigatório.',
    'required_if' => ':attribute campo é obrigatório quando :other é :value.',
    'required_unless' => ':attribute campo é obrigatório, a menos que :other esteja em :values.',
    'required_with' => ':attribute campo é obrigatório quando :values está presente.',
    'required_with_all' => ':attribute campo é obrigatório quando :values estão presentes.',
    'required_without' => ':attribute campo é obrigatório quando :values não estão presentes.',
    'required_without_all' => ':attribute campo é obrigatório quando nenhum :values estão presentes.',
    'same' => ':attribute e :other devem combinar.',
    'size' => [
        'numeric' => ':attribute deve ter :size.',
        'file' => ':attribute deve ter :size Kb.',
        'string' => ':attribute deve ter :size caracteres.',
        'array' => ':attribute deve conter :size itens.',
    ],
    'starts_with' => ':attribute deve começar com um dos following: :values',
    'string' => ':attribute deve ser um texto.',
    'timezone' => ':attribute deve ser uma zona válida.',
    'unique' => ':attribute já existe.',
    'uploaded' => ':attribute falhou ao carregar.',
    'url' => ':attribute formato inválido.',
    'uuid' => ':attribute deve ser uma UUID válida.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
