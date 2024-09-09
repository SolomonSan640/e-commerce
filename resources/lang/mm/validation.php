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

    'accepted' => ':attribute ကိုလက်ခံရပါမည်။',
    'accepted_if' => ':attribute ကို :other :value ဖြစ်သောအခါ လက်ခံရပါမည်။',
    'active_url' => ':attribute သည် တရားဝင် URL မဟုတ်ပါ။',
    'after' => ':attribute သည် :date နောက်ပိုင်းဖြစ်ရမည်။',
    'after_or_equal' => ':attribute သည် :date နောက်ပိုင်း သို့မဟုတ် တူညီရမည်။',
    'alpha' => ':attribute တွင် အက္ခရာများသာပါရမည်။',
    'alpha_dash' => ':attribute တွင် အက္ခရာများ၊ အရေအတွက်များ၊ dash နှင့် underscore များသာ ပါရမည်။',
    'alpha_num' => ':attribute တွင် အက္ခရာများနှင့် အရေအတွက်များသာပါရမည်။',
    'array' => ':attribute သည် array ဖြစ်ရမည်။',
    'ascii' => ':attribute တွင် single-byte alphanumeric characters နှင့် symbols များသာပါရမည်။',
    'before' => ':attribute သည် :date မတိုင်မီရက်စွဲဖြစ်ရမည်။',
    'before_or_equal' => ':attribute သည် :date မတိုင်မီ သို့မဟုတ် တူညီရမည်။',
    'between' => [
        'array' => ':attribute တွင် :min နှင့် :max အကြား items များ ပါရမည်။',
        'file' => ':attribute သည် :min နှင့် :max kilobytes အကြားဖြစ်ရမည်။',
        'numeric' => ':attribute သည် :min နှင့် :max အကြားဖြစ်ရမည်။',
        'string' => ':attribute သည် :min နှင့် :max characters အကြားဖြစ်ရမည်။',
    ],
    'boolean' => ':attribute ကြောင့် true သို့မဟုတ် false ဖြစ်ရမည်။',
    'confirmed' => ':attribute အတည်ပြုချက်မကိုက်ညီပါ။',
    'current_password' => 'စကားဝှက် မမှန်ပါ။',
    'date' => ':attribute သည် တရားဝင်ရက်စွဲမဟုတ်ပါ။',
    'date_equals' => ':attribute သည် :date နေ့ရက်နှင့် တူညီရမည်။',
    'date_format' => ':attribute သည် :format ပုံစံနှင့် မကိုက်ညီပါ။',
    'decimal' => ':attribute တွင် :decimal ဒဿမရှိရမည်။',
    'declined' => ':attribute ကို ငြင်းဆန်ရမည်။',
    'declined_if' => ':attribute ကို :other သည် :value ဖြစ်သောအခါ ငြင်းဆန်ရမည်။',
    'different' => ':attribute နှင့် :other တူရမည်မဟုတ်ပါ။',
    'digits' => ':attribute သည် :digits ဂဏန်းဖြစ်ရမည်။',
    'digits_between' => ':attribute သည် :min နှင့် :max ဂဏန်းအကြားဖြစ်ရမည်။',
    'dimensions' => ':attribute သည် မမှန်ကန်သော ပုံအရွယ်အစားရှိသည်။',
    'distinct' => ':attribute တွင် ထပ်နေသောတန်ဖိုးရှိသည်။',
    'doesnt_end_with' => ':attribute သည် :values တစ်ခုခုနှင့် အဆုံးသတ်၍ မရပါ။',
    'doesnt_start_with' => ':attribute သည် :values တစ်ခုခုဖြင့် စ၍ မရပါ။',
    'email' => ':attribute သည် တရားဝင် အီးမေးလိပ်စာ ဖြစ်ရမည်။',
    'ends_with' => ':attribute သည် :values တစ်ခုခုဖြင့် အဆုံးသတ်ရမည်။',
    'enum' => 'ရွေးချယ်ထားသော :attribute မမှန်ကန်ပါ။',
    'exists' => 'ရွေးချယ်ထားသော :attribute မမှန်ကန်ပါ။',
    'file' => ':attribute သည် ဖိုင် ဖြစ်ရမည်။',
    'filled' => ':attribute တွင် တန်ဖိုးပါရမည်။',
    'gt' => [
        'array' => ':attribute တွင် :value items ထက် ပိုများရမည်။',
        'file' => ':attribute သည် :value kilobytes ထက် ပိုကြီးရမည်။',
        'numeric' => ':attribute သည် :value ထက် ပိုကြီးရမည်။',
        'string' => ':attribute သည် :value characters ထက် ပိုကြီးရမည်။',
    ],
    'gte' => [
        'array' => ':attribute တွင် အနည်းဆုံး :value items ပါရမည်။',
        'file' => ':attribute သည် :value kilobytes သို့မဟုတ် ပိုကြီးရမည်။',
        'numeric' => ':attribute သည် :value သို့မဟုတ် ပိုကြီးရမည်။',
        'string' => ':attribute သည် :value characters သို့မဟုတ် ပိုကြီးရမည်။',
    ],
    'image' => ':attribute သည် ပုံဖြစ်ရမည်။',
    'in' => 'ရွေးချယ်ထားသော :attribute မမှန်ကန်ပါ။',
    'in_array' => ':attribute သည် :other တွင် မရှိပါ။',
    'integer' => ':attribute သည် ကိန်းဂဏန်းဖြစ်ရမည်။',
    'ip' => ':attribute သည် တရားဝင် IP လိပ်စာဖြစ်ရမည်။',
    'ipv4' => ':attribute သည် တရားဝင် IPv4 လိပ်စာဖြစ်ရမည်။',
    'ipv6' => ':attribute သည် တရားဝင် IPv6 လိပ်စာဖြစ်ရမည်။',
    'json' => ':attribute သည် တရားဝင် JSON စာကြောင်းဖြစ်ရမည်။',
    'lowercase' => ':attribute သည် စာလုံးသေးဖြစ်ရမည်။',
    'lt' => [
        'array' => ':attribute တွင် :value items ထက် နည်းရမည်။',
        'file' => ':attribute သည် :value kilobytes ထက် နည်းရမည်။',
        'numeric' => ':attribute သည် :value ထက် နည်းရမည်။',
        'string' => ':attribute သည် :value characters ထက် နည်းရမည်။',
    ],
    'lte' => [
        'array' => ':attribute တွင် :value items ထက် မပိုရပါ။',
        'file' => ':attribute သည် :value kilobytes ထက် မကြီးရပါ။',
        'numeric' => ':attribute သည် :value ထက် မကြီးရပါ။',
        'string' => ':attribute သည် :value characters ထက် မကြီးရပါ။',
    ],
    'mac_address' => ':attribute သည် တရားဝင် MAC လိပ်စာဖြစ်ရမည်။',
    'max' => [
        'array' => ':attribute သည် :max items ထက် မပိုရပါ။',
        'file' => ':attribute သည် :max kilobytes ထက် မကြီးရပါ။',
        'numeric' => ':attribute သည် :max ထက် မကြီးရပါ။',
        'string' => ':attribute သည် :max characters ထက် မကြီးရပါ။',
    ],
    'max_digits' => ':attribute တွင် :max ဂဏန်းထက် မပိုရပါ။',
    'mimes' => ':attribute သည် ဖိုင်အမျိုးအစား :values ဖြစ်ရမည်။',
    'mimetypes' => ':attribute သည် ဖိုင်အမျိုးအစား :values ဖြစ်ရမည်။',
    'min' => [
        'array' => ':attribute တွင် အနည်းဆုံး :min items ပါရမည်။',
        'file' => ':attribute သည် အနည်းဆုံး :min kilobytes ဖြစ်ရမည်။',
        'numeric' => ':attribute သည် အနည်းဆုံး :min ဖြစ်ရမည်။',
        'string' => ':attribute သည် အနည်းဆုံး :min characters ဖြစ်ရမည်။',
    ],
    'min_digits' => ':attribute တွင် အနည်းဆုံး :min ဂဏန်း ပါရမည်။',
    'missing' => ':attribute ရှာမတွေ့ပါ။',
    'missing_if' => ':other သည် :value ဖြစ်သောအခါ :attribute ရှာမတွေ့ပါ။',
    'missing_unless' => ':other သည် :value မဟုတ်မချင်း :attribute ရှာမတွေ့ပါ။',
    'missing_with' => ':values တွင် တစ်ခုခု ရှိပါက :attribute ရှာမတွေ့ပါ။',
    'missing_with_all' => ':values အားလုံး ရှိပါက :attribute ရှာမတွေ့ပါ။',
    'multiple_of' => ':attribute သည် :value ၏ တစ်ကြိမ်ဖြစ်ရမည်။',
    'not_in' => 'ရွေးချယ်ထားသော :attribute မမှန်ကန်ပါ။',
    'not_regex' => ':attribute ပုံစံ မမှန်ပါ။',
    'numeric' => ':attribute သည် ကိန်းဂဏန်းဖြစ်ရမည်။',
    'password' => [
        'letters' => ':attribute တွင် အက္ခရာတစ်ခုခု ပါရမည်။',
        'mixed' => ':attribute တွင် အက္ခရာ အကြီးတစ်ခုနှင့် အက္ခရာ အသေးတစ်ခု ရှိရမည်။',
        'numbers' => ':attribute တွင် ဂဏန်းတစ်ခုခု ရှိရမည်။',
        'symbols' => ':attribute တွင် သင်္ကေတတစ်ခုခု ရှိရမည်။',
        'uncompromised' => 'ပေးသော :attribute သည် ဒေတာပေါက်ကြားမှုတွင်တွေ့ရှိထားသည်။ တခြား :attribute ကို ရွေးချယ်ပါ။',
    ],
    'present' => ':attribute ရှိရမည်။',
    'prohibited' => ':attribute ကို တားမြစ်ထားသည်။',
    'prohibited_if' => ':other သည် :value ဖြစ်သောအခါ :attribute ကို တားမြစ်ထားသည်။',
    'prohibited_unless' => ':other သည် :values မဟုတ်မချင်း :attribute ကို တားမြစ်ထားသည်။',
    'prohibits' => ':attribute သည် :other ရှိခြင်းကို တားမြစ်ထားသည်။',
    'regex' => ':attribute ပုံစံ မမှန်ပါ။',
    'required' => ':attribute လိုအပ်ပါသည်။',
    'required_array_keys' => ':attribute တွင် :values အတွက် အရေးပါသော entries ရှိရမည်။',
    'required_if' => ':other သည် :value ဖြစ်သောအခါ :attribute လိုအပ်ပါသည်။',
    'required_if_accepted' => ':other ကို လက်ခံသောအခါ :attribute လိုအပ်ပါသည်။',
    'required_unless' => ':other သည် :values မဟုတ်မချင်း :attribute လိုအပ်ပါသည်။',
    'required_with' => ':values ရှိပါက :attribute လိုအပ်ပါသည်။',
    'required_with_all' => ':values အားလုံး ရှိပါက :attribute လိုအပ်ပါသည်။',
    'required_without' => ':values မရှိပါက :attribute လိုအပ်ပါသည်။',
    'required_without_all' => ':values တစ်ခုခုမရှိပါက :attribute လိုအပ်ပါသည်။',
    'same' => ':attribute နှင့် :other ကိုက်ညီရမည်။',
    'size' => [
        'array' => ':attribute တွင် :size items ပါရမည်။',
        'file' => ':attribute သည် :size kilobytes ဖြစ်ရမည်။',
        'numeric' => ':attribute သည် :size ဖြစ်ရမည်။',
        'string' => ':attribute သည် :size characters ဖြစ်ရမည်။',
    ],
    'starts_with' => ':attribute သည် :values တစ်ခုခုဖြင့် စရမည်။',
    'string' => ':attribute သည် စာကြောင်းဖြစ်ရမည်။',
    'timezone' => ':attribute သည် တရားဝင် တိကျသော ဒေသအချိန်ဖြစ်ရမည်။',
    'unique' => ':attribute ကို ရှိပြီးသားဖြစ်သည်။',
    'uploaded' => ':attribute အပ်လုဒ် မအောင်မြင်ပါ။',
    'uppercase' => ':attribute သည် အက္ခရာအကြီးဖြစ်ရမည်။',
    'url' => ':attribute သည် တရားဝင် URL ဖြစ်ရမည်။',
    'ulid' => ':attribute သည် တရားဝင် ULID ဖြစ်ရမည်။',
    'uuid' => ':attribute သည် တရားဝင် UUID ဖြစ်ရမည်။',


    // custom
    'dataNameUnique' => ':attribute နာမည် (အင်္ဂလိပ်) သည် ထည့်သွင်းပြီးဖြစ်ပါသည်။',
    'dataNameUniqueEnglish' => ':attribute နာမည် (အင်္ဂလိပ်) သည် ထည့်သွင်းပြီးဖြစ်ပါသည်။',
    'dataNameUniqueMyanmar' => ':attribute နာမည် (မြန်မာ) သည် ထည့်သွင်းပြီးဖြစ်ပါသည်။',
    'dataNameUniqueThai' => ':attribute နာမည် (ထိုင်း) သည် ထည့်သွင်းပြီးဖြစ်ပါသည်။',
    'dataNameUniqueKorea' => ':attribute နာမည် (ကိုရီးယား) သည် ထည့်သွင်းပြီးဖြစ်ပါသည်။',

    'dataNameRequire' => ':attribute လိုအပ်ပါသည်။',
    'dataNameRequireEnglish' => ':attribute လိုအပ်ပါသည်။',
    'dataNameRequireMyanmar' => ':values မရှိပါက :attribute (မြန်မာ) လိုအပ်ပါသည်။',
    'dataNameRequireThai' => ':values မရှိပါက :attribute (ထိုင်း) လိုအပ်ပါသည်။',
    'dataNameRequireKorea' => ':values မရှိပါက :attribute (ကိုရီးယား) လိုအပ်ပါသည်။',

    'dataSelect' => ':attribute ကိုကျေးဇူးပြု၍ ရွေးချယ်ပါ။',

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