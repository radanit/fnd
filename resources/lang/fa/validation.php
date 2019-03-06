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

    'accepted'             => 'فیلد :attribute باید از نوع تایید باشد', 
    'active_url'           => 'فیلد :attribute یک آدرس URL معتبر نیست',
    'after'                => 'فیلد :attribute باید تاریخی بعد از تاریخ :date باشد',
    'after_or_equal'       => 'فیلد :attribute باید تاریخی برابر یا بزرگتر از تاریخ :date باشد',
    'alpha'                => 'فیلد :attribute باید فقط شامل حروف باشد',
    'alpha_dash'           => 'فیلد :attribute باید شامل حروف، اعداد،- و _ باشد',
    'alpha_num'            => 'فیلد :attribute باید فقط شامل حروف و اعداد باشد',
    'array'                => 'فیلد :attribute باید یک مقدار آرایه ای باشد',
    'before'               => 'فیلد :attribute باید تاریخی قبل از تاریخ :date باشد',
    'before_or_equal'      => 'فیلد :attribute باید تاریخی برابر یا قبل از تاریخ :date باشد',
    'between'              => [
        'numeric' => 'فیلد :attribute باید بین :min و :max باشد',
        'file'    => 'فیلد :attribute باید بین :min و :max کیلوبایت باشد',
        'string'  => 'فیلد :attribute باید بین :min و :max کارکتر باشد',
        'array'   => 'فیلد :attribute باید بین :min و :max آیتم داشته باشد',
    ],
    'boolean'              => 'فیلد :attribute باید آری/خیر باشد',
    'confirmed'            => 'فیلد :attribute با تکرار آن برابر نیست',
    'date'                 => 'مقدار فیلد :attribute تاریخ معتبری نیست',
    'date_format'          => 'فیلد :attribute با فرمت :format منطبق نیست',
    'different'            => 'مقدار فیلد :attribute و :other باید باهم متفاوت باشند',
    'different'            => 'فیلد :attribute و :other باید متفاوت باشند',
    'digits'               => 'فیلد :attribute باید :digits رقم باشد',
    'digits_between'       => 'فیلد :attribute باید بین :min و :max رقم باشد',
    'dimensions'           => 'فیلد :attribute شامل مقادیر نامعتبر برای سایز تصویر است',
    'distinct'             => 'فیلد :attribute شامل مقادیر تکراری است',
    'email'                => 'فرمت :attribute وارد شده معتبر نمی باشد.',
    'exists'               => 'مقدار :attribute نامعتیر است.',
    'file'                 => 'مقدار :attribute باید یک فایل باشد',
    'filled'               => 'فیلد :attribute باید دارای مقدار باشد',
    'gt'                   => [
        'numeric' => 'فیلد :attribute باید بزرگتر از :value باشد',
        'file'    => 'فیلد :attribute باید بزرگتر از :value کیلوبایت باشد',
        'string'  => 'فیلد :attribute باید بزرگتر از :value کارکتر باشد',
        'array'   => 'فیلد :attribute باید بیشتر از :value آیتم داشته باشد',
    ],
    'gte'                  => [
        'numeric' => 'فیلد :attribute باید بزرگتر یا مساوی :value باشد',
        'file'    => 'فیلد :attribute باید بزرگتر یا مساوی :value کیلوبایت باشد',
        'string'  => 'فیلد :attribute باید بزرگتر یا مساوی :value کارکتر باشد',
        'array'   => 'فیلد :attribute باید :value مورد یا بیشتر داشته باشد',
    ],
    'image'                => 'مقدار :attribute باید یک تصویر باشد',
    'in'                   => 'مقدار انتخاب شده :attribute نامعتبر است',
    'in_array'             => 'مقدار :attribute در :other وجود ندارد',
    'integer'              => 'فیلد :attribute باید از نوع عددی باشد', 
    'ip'                   => 'مقدار فیلد :attribute باید شامل یک آدرس IP معتبر باشد',
    'ipv4'                 => 'مقدار فیلد :attribute باید شامل یک آدرس IPV4 معتبر باشد',
    'ipv6'                 => 'مقدار فیلد :attribute باید شامل یک آدرس IPV6 معتبر باشد',
    'json'                 => 'فیلد :attribute باید یک رشته با فرمت json باشد',
    'lt'                   => [
        'numeric' => 'فیلد :attribute باید کوچکتر از :value باشد',
        'file'    => 'فیلد :attribute باید کوجکتر از :value کیلوبایت باشد',
        'string'  => 'فیلد :attribute باید کوجکتر از :value کارکتر باشد',
        'array'   => 'فیلد :attribute باید کوچکتراز :value آیتم داشته باشد',
    ],
    'lte'                  => [
        'numeric' => 'فیلد :attribute باید کوچکتر یا مساوی :value باشد',
        'file'    => 'فیلد :attribute باید کوچکتر یا مساوی :value کیلوبایت باشد',
        'string'  => 'فیلد :attribute باید کوچکتر یا مساوی :value کارکتر باشد',
        'array'   => 'فیلد :attribute باید :value مورد یا کمتر داشته باشد',
    ],
    'max'                  => [
        'numeric' => 'مقدار فیلد :attribute می تواند حداکثر :min رقم باشد',
        'file'    => 'مقدار فیلد :attribute می تواند حداکثر :min کیلوبایت باشد',
        'string'  => 'مقدار فیلد :attribute می تواند حداکثر :min کارکتر باشد',
        'array'   => 'فیلد :attribute می تواند حداکثر شامل :min آیتم باشد',
    ],
    'mimes'                => ':attribute باید یک فایل از نوع :type باشد',
    'mimetypes'            => ':attribute باید یک فایل از نوع :type باشد',
    'min'                  => [
        'numeric' => 'مقدار فیلد :attribute باید حداقل :min رقم باشد',
        'file'    => 'مقدار فیلد :attribute باید حداقل :min کیلوبایت باشد',
        'string'  => 'مقدار فیلد :attribute باید حداقل :min کارکتر باشد',
        'array'   => 'فیلد :attribute باید حداقل شامل :min آیتم باشد',
    ],
    'not_in'               => 'مقدار انتخاب شده :attribute نامعتبر است',
    'not_regex'            => 'فرمت :attribute نامعتبر است',
    'numeric'              => 'فیلد :attribute باید عدد باشد',
    'present'              => 'فیلد :attribute باید ارسال شود',
    'regex'                => 'فرمت :attribute نامعتبر است',
    'required'             => 'فیلد :attribute اجباری است',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'فیلد :attribute و :other باید برابر باشند',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'فیلد :attribute باید یک مقدار رشته ای باشد',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'این :attribute قبلا ثبت شده است.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

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
		'profile_name' => [
			'unique' =>'نام پروفایل'
		],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' =>'نام',
        'email' => 'آدرس پست الکترونیک',
        'bio' => 'بیوگرافی',
        'password' => 'کلمه عبور',
        'code' => 'کد',
        'description' => 'شرح',
        'pmType_id' => 'نوع سرویس پیشگیرانه',
        'stopCode_id' => 'کد توقف',
        'programType_id' => 'نوع برنامه',
        'mai_executive_department_id' => 'واحد اجراکننده',
        'latin_name' => 'عنوان لاتین',
        'persian_name' => 'عنوان فارسی',
        'periodType_id' => 'دوره تناوب',
        'safty_description' => 'دستور العمل ایمنی',
        'profile_id' => 'عنوان پروفایل',
		'roles' => 'نقش کاربری',
        'roles.*' => 'این نقش کاربری',
        'permissions' => 'سطح دسترسی',
        'permissions.*' => 'این سطح دسترسی',
        'structure' => 'ساختار',
        'password_policy_id' => 'محدودیت رمز عبور',
        'new_password' => 'پسورد جدید',
        'min_length' => 'حداقل طول',
        'max_length' => 'حداکثر طول',
        'upper_case' => 'تعداد حروف بزرگ',
        'lower_case' => 'تعداد حروف کوچک',
        'digits' => 'تعداد عدد',
        'special_chars' =>  'تعداد کارکترهای خاص',
        'does_not_contain' => 'رشته غیر مجاز'
    ],

];
