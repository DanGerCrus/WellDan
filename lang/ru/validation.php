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
    'accepted' => 'Поле  :attribute должно быть принято.',
    'accepted_if' => 'Поле :attribute должно быть принято, если :other равно :value.',
    'active_url' => 'Поле :attribute должно быть допустимым URL-адресом.',
    'after' => 'Поле :attribute должно содержать дату после :date.',
    'after_or_equal' => 'Поле :attribute должно содержать дату, следующую за :date или равную ей.',
    'alpha' => 'Поле :attribute должно содержать только буквы.',
    'alpha_dash' => 'Поле :attribute должно содержать только буквы, цифры, тире и символы подчеркивания.',
    'alpha_num' => 'Поле :attribute должно содержать только буквы и цифры.',
    'array' => 'Поле :attribute должно быть массивом.',
    'ascii' => 'Поле :attribute должно содержать только однобайтовые буквенно-цифровые символы.',
    'before' => 'В поле :attribute должна быть указана дата до :date.',
    'before_or_equal' => 'Поле :attribute должно содержать дату, предшествующую :date или равную ей.',
    'between' => [
        'array' => 'Поле :attribute должно содержать от :min до :max элементов.',
        'file' => 'Поле :attribute должно быть в диапазоне от :min до :max килобайт.',
        'numeric' => 'Поле :attribute должно находиться в диапазоне от :min до :max.',
        'string' => 'Поле :attribute должно содержать от :min до :max символов.',
    ],
    'boolean' => 'Поле :attribute должно быть true или false.',
    'can' => 'Поле :attribute содержит несанкционированное значение.',
    'confirmed' => 'Поле :attribute подтверждения не совпадает.',
    'current_password' => 'Пароль введен неверно.',
    'date' => 'В поле :attribute должна быть указана действительная дата.',
    'date_equals' => 'Поле :attribute должно содержать дату, равную :date.',
    'date_format' => 'Поле :attribute должно соответствовать формату :format.',
    'decimal' => 'Поле :attribute должо содержать :decimal разряды после запятой.',
    'declined' => 'Поле :attribute должно быть отклонено.',
    'declined_if' => 'Поле :attribute должно быть отклонено когда :other равно :value.',
    'different' => 'Поле :attribute и :other должны быть различны.',
    'digits' => 'Поле :attribute должно содержать :digits цифры.',
    'digits_between' => 'Поле :attribute должно быть между :min и :max цифр.',
    'dimensions' => 'Поле :attribute содержит недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute имеет повторяющееся значение.',
    'doesnt_end_with' => 'Поле :attribute не должно заканчиваться одним из следующих значений: :values.',
    'doesnt_start_with' => 'Поле :attribute не должно начинаться на одно из следующих значений: :values.',
    'email' => 'Поле :attribute должно быть валидным почтовым адресом.',
    'ends_with' => 'Поле :attribute поле должно заканчиваться одним из следующих символов: :values.',
    'enum' => 'Выбранное поле :attribute не действительно.',
    'exists' => 'Выбранное поле :attribute недопустимо.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => 'Поле :attribute должно содержать больше чем :value элементов.',
        'file' => 'Поле :attribute должно быть больше, чем :value килобайт.',
        'numeric' => 'Поле :attribute должно быть больше, чем :value.',
        'string' => 'Поле :attribute должно содержать больше чем :value символов.',
    ],
    'gte' => [
        'array' => 'Поле :attribute должно содержать :value элементов или больше.',
        'file' => 'Поле :attribute должно быть больше или равно :value килобайт.',
        'numeric' => 'Поле :attribute должно быть больше или равно :value.',
        'string' => 'Поле :attribute должно содержать больше :value символов или быть равным им.',
    ],
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранное поле :attribute не действительно.',
    'in_array' => 'Поле :attribute должно существовать в :other.',
    'integer' => 'Поле :attribute должно быть числом.',
    'ip' => 'Поле :attribute должно быть действительным IP-адрес.',
    'ipv4' => 'Поле :attribute должно быть действительным IPv4-адрес.',
    'ipv6' => 'Поле :attribute должно быть действительным IPv6-адрес.',
    'json' => 'Поле :attribute field должно быть допустимой JSON-строкой.',
    'lowercase' => 'Поле :attribute должно быть в нижнем регистре.',
    'lt' => [
        'array' => 'Поле :attribute должно содержать меньше чем :value элементов.',
        'file' => 'Поле :attribute должно быть меньше чем :value килобайт.',
        'numeric' => 'Поле :attribute должно быть меньше :value.',
        'string' => 'Поле :attribute должно содержать меньше чем :value символов.',
    ],
    'lte' => [
        'array' => 'Поле :attribute не должно содержать больше чем :value элементов.',
        'file' => 'Поле :attribute должно быть меньше или равно :value килобайт.',
        'numeric' => 'Поле :attribute должно быть меньше или равно :value.',
        'string' => 'Поле :attribute должно быть меньше или равно :value символов.',
    ],
    'mac_address' => 'Поле :attribute должно быть действительным MAC-адресом.',
    'max' => [
        'array' => 'Поле :attribute должно содержать не более :max элементов.',
        'file' => 'Поле :attribute не должно превышать :max килобайт.',
        'numeric' => 'Поле :attribute не должно превышать :max.',
        'string' => 'Количество символов поля :attribute не должно превышать :max символов.',
    ],
    'max_digits' => 'В поле :attribute должно быть не более :max символов.',
    'mimes' => 'Поле :attribute должно быть файлом типа: :values.',
    'mimetypes' => 'Поле :attribute должно быть файлом типа: :values.',
    'min' => [
        'array' => 'Поле :attribute должно содержать по крайней мере :min элементов.',
        'file' => 'Поле :attribute должно быть не менее :min килобайт.',
        'numeric' => 'Поле :attribute должно быть не менее :min.',
        'string' => 'Поле :attribute должно быть не менее :min символов.',
    ],
    'min_digits' => 'Поле :attribute должно содержать не менее :min цифр.',
    'missing' => 'Поле :attribute должно отсутствовать.',
    'missing_if' => 'Поле :attribute должно отсутствовать, если :other равно :value.',
    'missing_unless' => 'Поле :attribute должно отсутствовать, если только :other равно :value.',
    'missing_with' => 'Поле :attribute должно отсутствовать, когда :values присутствует.',
    'missing_with_all' => 'Поле :attribute должно отсутствовать, когда :values присутствуют.',
    'multiple_of' => 'Поле :attribute должно быть кратно :value.',
    'not_in' => 'Выбранное поле :attribute не действительно.',
    'not_regex' => 'Поле :attribute имеет не верный формат.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'password' => [
        'letters' => 'Поле :attribute должно содержать хотя бы одну букву.',
        'mixed' => 'Поле :attribute поле должно содержать как минимум одну заглавную и одну строчную букву.',
        'numbers' => 'Поле :attribute поле должно содержать хотя бы одно число.',
        'symbols' => 'Поле :attribute поле должно содержать хотя бы один символ.',
        'uncompromised' => 'Указанное поле :attribute появилось в результате утечки данных. Пожалуйста, выберите другое :attribute.',
    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если :other не равно :values.',
    'prohibits' => 'Поле :attribute запрещает :other присутствовать.',
    'regex' => 'Поле :attribute имеет неверный формат.',
    'required' => 'Поле :attribute является обязательным для заполнения.',
    'required_array_keys' => 'Поле :attribute должно содержать записи о :values.',
    'required_if' => 'Поле :attribute обязательно, когда :other равно :value.',
    'required_if_accepted' => 'Поле :attribute обязательно, когда :other принимается.',
    'required_unless' => 'Поле :attribute обязательно, если только :other не равно :values.',
    'required_with' => 'Поле :attribute обязательно, когда :values присутствует.',
    'required_with_all' => 'Поле :attribute обязательно, когда :values присутствуют.',
    'required_without' => 'Поле :attribute обязательно, когда :values отсутствует.',
    'required_without_all' => 'Поле :attribute обязательно, когда :values отсутствют.',
    'same' => 'Поле :attribute должно соответствовать :other.',
    'size' => [
        'array' => 'Поле :attribute должно содержать :size элементов.',
        'file' => 'Поле :attribute должно быть :size килобайт.',
        'numeric' => 'Поле :attribute должно быть :size.',
        'string' => 'Поле :attribute должно содерджать :size символов.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться с одного из следующих символов: :values.',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть допустимым часовым поясом.',
    'unique' => 'Поле :attribute уже используется.',
    'uploaded' => 'Поле :attribute не удалось загрузить.',
    'uppercase' => 'Поле :attribute должно быть написано в верхнем регистре.',
    'url' => 'Поле :attribute должно содержать действительный URL-адрес.',
    'ulid' => 'Поле :attribute должно содержать действительный идентификатор ULID.',
    'uuid' => 'Поле :attribute должно содержать действительный идентификатор UUID.',

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
