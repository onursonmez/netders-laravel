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

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'Tekrar, :attribute alanı ile uyuşmuyor.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attribute alanı hatalı bir e-posta adresidir.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => ':attribute alanı hatalıdır.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => ':attribute alanı hatalıdır.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute alanı sayı olmalıdır.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute en fazla :max karakter olmalıdır.',
        'file' => 'Yüklediğin (:attribute) :max KB boyutunu geçmemelidir.',
        'string' => ':attribute maksimum :max karakter olabilir.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'Yüklediğin (:attribute) yalnızca (:values) uzantısı ile kabul edilir.',
    'mimetypes' => 'Yüklediğin (:attribute) yalnızca (:values) uzantısı ile kabul edilir.',
    'min' => [
        'numeric' => ':attribute en az :min karakter olmalıdır.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attribute en az :min karakter olmalıdır.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute alanının doldurulması zorunludur.',
    'required_if' => ':attribute veya :other alanlarından biri zorunludur :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => ':attribute adresi kullanılmaktadır.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',
    'captcha' => 'Güvenlik kodu hatalıdır.', 
    'mx' => ':attribute geçersizdir.',

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

    'attributes' => [
        'email' => 'E-posta',
        'first_name' => 'Ad',
        'last_name' => 'Soyad',
        'full_name' => 'Ad soyad',
        'password' => 'Şifre',
        'member_type' => 'Üyelik seçimi',
        'captcha' => 'Matematik işlemi sonucu',
        'levels' => 'Dersler',
        'price_private' => 'Birebir ders ücreti',
        'price_live' => 'Canlı ders ücreti',
        'title' => 'Başlık',
        'description' => 'Açıklama',
        'username' => 'Kullanıcı adı',
        'old_password' => 'Mevcut şifre',
        'new_password' => 'Yeni şifre',
        'new_password_confirmation' => 'Yeni şifre (tekrar)',
        'intl-mobile' => 'Cep telefonu',
        'phone_mobile' => 'Cep telefonu',
        'message' => 'Mesaj',
        'user_id' => 'Kullanıcı bilgisi',
        'rating' => 'Puan',
        'comment' => 'Yorum',
        'cancel_reason' => 'İptal nedeni',
        'lesson_min_minute' => 'Minumum tek ders',
        'lesson_max_minute' => 'Maksimum tek ders',
        'lesson_minute' => 'Ders süresi',
        'aggrement' => 'Şartlar ve hükümler',
        'document' => 'Belge',
    ],

];
