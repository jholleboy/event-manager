<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'password' => [
        'letters' => 'A senha deve conter pelo menos uma letra.',
        'mixed' => 'A senha deve conter pelo menos uma letra maiúscula e uma letra minúscula.',
        'numbers' => 'A senha deve conter pelo menos um número.',
        'symbols' => 'A senha deve conter pelo menos um caractere especial.',
        'min' => 'A senha deve ter pelo menos :min caracteres.',
        'confirmed' => 'A confirmação da senha não confere.',
    ],
    'current_password' => 'A senha atual está incorreta.',
    'min' => [
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'confirmed' => 'Os campos :attribute não coincidem.',
];
