<?php

return [
     'dashboard' => 'لوحة التحكم',
    'navigation' => 'التنقل',
    
   
    'auth' => [
        'login' => [
            'title' => 'تسجيل الدخول',
            'heading' => 'تسجيل الدخول',
            'fields' => [
                'email' => [
                    'label' => 'البريد الإلكتروني',
                ],
                'password' => [
                    'label' => 'كلمة المرور',
                ],
                'remember' => [
                    'label' => 'تذكرني',
                ],
            ],
            'actions' => [
                'authenticate' => [
                    'label' => 'تسجيل الدخول',
                ],
            ],
        ],
    ],
    
 
    'pages' => [
        'dashboard' => [
            'title' => 'لوحة التحكم',
        ],
    ],
    
     'resources' => [
        'pages' => [
            'index' => [
                'title' => 'السجلات',
                'button' => [
                    'create' => 'جديد',
                ],
            ],
            'create' => [
                'title' => 'إنشاء',
            ],
            'edit' => [
                'title' => 'تعديل',
            ],
            'view' => [
                'title' => 'عرض',
            ],
        ],
        'notifications' => [
            'created' => 'تم الإنشاء بنجاح',
            'updated' => 'تم التحديث بنجاح',
            'deleted' => 'تم الحذف بنجاح',
        ],
    ],
    
     'actions' => [
        'create' => [
            'label' => 'إنشاء',
            'single' => 'إنشاء :label',
            'multiple' => 'إنشاء :count :label',
        ],
        'attach' => [
            'label' => 'إرفاق',
        ],
        'detach' => [
            'label' => 'فصل',
        ],
        'edit' => [
            'label' => 'تعديل',
        ],
        'view' => [
            'label' => 'عرض',
        ],
        'delete' => [
            'label' => 'حذف',
            'single' => 'حذف :label',
        ],
        'save' => [
            'label' => 'حفظ',
        ],
        'cancel' => [
            'label' => 'إلغاء',
        ],
        'close' => [
            'label' => 'إغلاق',
        ],
        'confirm' => [
            'label' => 'تأكيد',
        ],
        'approve' => [
            'label' => 'اعتماد',
        ],
        'reject' => [
            'label' => 'رفض',
        ],
        'export' => [
            'label' => 'تصدير',
        ],
        'import' => [
            'label' => 'استيراد',
        ],
        'restore' => [
            'label' => 'استعادة',
        ],
        'force_delete' => [
            'label' => 'حذف نهائي',
        ],
        'replicate' => [
            'label' => 'نسخ',
        ],
        'submit' => [
            'label' => 'إرسال',
        ],
        'back' => [
            'label' => 'رجوع',
        ],
    ],
    
     'tables' => [
        'empty' => [
            'heading' => 'لا توجد سجلات',
        ],
        'selection' => [
            'actions' => [
                'select_all' => [
                    'label' => 'تحديد الكل',
                ],
                'deselect_all' => [
                    'label' => 'إلغاء تحديد الكل',
                ],
            ],
        ],
        'pagination' => [
            'label' => 'التنقل بين الصفحات',
            'overview' => 'عرض من :first إلى :last من :total سجل',
            'fields' => [
                'records_per_page' => [
                    'label' => 'لكل صفحة',
                ],
            ],
            'buttons' => [
                'previous' => [
                    'label' => 'السابق',
                ],
                'next' => [
                    'label' => 'التالي',
                ],
            ],
        ],
        'search' => [
            'label' => 'بحث',
            'placeholder' => 'بحث...',
        ],
        'filters' => [
            'label' => 'مرشحات',
            'buttons' => [
                'apply' => [
                    'label' => 'تطبيق',
                ],
                'remove' => [
                    'label' => 'إزالة',
                ],
                'remove_all' => [
                    'label' => 'إزالة الكل',
                    'tooltip' => 'إزالة الكل',
                ],
                'toggle' => [
                    'label' => 'مرشحات',
                ],
            ],
            'indicator' => 'مرشح واحد مفعل|مرشحان مفعلان|:count مرشحات مفعلة',
        ],
        'grouping' => [
            'label' => 'تجميع حسب',
            'placeholder' => 'تجميع حسب',
            'grouped' => [
                'label' => 'مجمعة حسب',
            ],
        ],
        'reorder_indicator' => 'اسحب وأفلت السجلات لإعادة الترتيب.',
        'columns' => [
            'text' => [
                'actions' => [
                    'collapse_list' => 'إخفاء :count أكثر',
                    'expand_list' => 'عرض :count أكثر',
                ],
            ],
        ],
    ],
    
     'forms' => [
        'components' => [
            'wizard' => [
                'buttons' => [
                    'previous_step' => [
                        'label' => 'السابق',
                    ],
                    'next_step' => [
                        'label' => 'التالي',
                    ],
                ],
            ],
            'date_time_picker' => [
                'buttons' => [
                    'date' => [
                        'label' => 'التاريخ',
                    ],
                    'time' => [
                        'label' => 'الوقت',
                    ],
                    'set' => [
                        'label' => 'تعيين',
                    ],
                    'clear' => [
                        'label' => 'مسح',
                    ],
                    'today' => [
                        'label' => 'اليوم',
                    ],
                ],
            ],
            'select' => [
                'actions' => [
                    'create_option' => [
                        'modal' => [
                            'heading' => 'إنشاء',
                            'label' => 'التسمية',
                            'placeholder' => 'تسمية جديدة',
                            'actions' => [
                                'create' => [
                                    'label' => 'إنشاء',
                                ],
                            ],
                        ],
                    ],
                ],
                'loading_message' => 'جاري التحميل...',
                'no_search_results_message' => 'لا توجد نتائج للبحث.',
                'placeholder' => 'اختر خياراً',
                'searching_message' => 'جاري البحث...',
                'search_prompt' => 'ابدأ بالكتابة للبحث...',
            ],
            'tags_input' => [
                'placeholder' => 'وسم جديد',
            ],
            'builder' => [
                'collapsed' => 'مطوي',
                'expanded' => 'موسع',
                'buttons' => [
                    'clone' => [
                        'label' => 'نسخ',
                    ],
                    'create' => [
                        'label' => 'إنشاء',
                    ],
                    'create_between' => [
                        'label' => 'إدراج بين',
                    ],
                    'delete' => [
                        'label' => 'حذف',
                    ],
                    'move_down' => [
                        'label' => 'تحريك لأسفل',
                    ],
                    'move_up' => [
                        'label' => 'تحريك لأعلى',
                    ],
                    'reorder' => [
                        'label' => 'إعادة ترتيب',
                    ],
                    'collapse' => [
                        'label' => 'طي',
                    ],
                    'expand' => [
                        'label' => 'توسيع',
                    ],
                    'collapse_all' => [
                        'label' => 'طي الكل',
                    ],
                    'expand_all' => [
                        'label' => 'توسيع الكل',
                    ],
                ],
            ],
            'key_value' => [
                'buttons' => [
                    'add' => [
                        'label' => 'إضافة صف',
                    ],
                    'delete' => [
                        'label' => 'حذف صف',
                    ],
                    'reorder' => [
                        'label' => 'إعادة ترتيب الصف',
                    ],
                ],
                'fields' => [
                    'key' => [
                        'label' => 'المفتاح',
                    ],
                    'value' => [
                        'label' => 'القيمة',
                    ],
                ],
            ],
            'markdown_editor' => [
                'toolbar_buttons' => [
                    'attach_files' => 'إرفاق ملفات',
                    'bold' => 'عريض',
                    'bullet_list' => 'قائمة نقطية',
                    'code_block' => 'كود',
                    'edit' => 'تعديل',
                    'italic' => 'مائل',
                    'link' => 'رابط',
                    'ordered_list' => 'قائمة مرتبة',
                    'preview' => 'معاينة',
                    'strike' => 'يتوسطه خط',
                ],
            ],
            'repeater' => [
                'buttons' => [
                    'create' => [
                        'label' => 'إضافة',
                    ],
                    'delete' => [
                        'label' => 'حذف',
                    ],
                    'clone' => [
                        'label' => 'نسخ',
                    ],
                    'move_down' => [
                        'label' => 'تحريك لأسفل',
                    ],
                    'move_up' => [
                        'label' => 'تحريك لأعلى',
                    ],
                    'collapse' => [
                        'label' => 'طي',
                    ],
                    'expand' => [
                        'label' => 'توسيع',
                    ],
                    'collapse_all' => [
                        'label' => 'طي الكل',
                    ],
                    'expand_all' => [
                        'label' => 'توسيع الكل',
                    ],
                ],
            ],
            'rich_editor' => [
                'toolbar_buttons' => [
                    'attach_files' => 'إرفاق ملفات',
                    'blockquote' => 'اقتباس',
                    'bold' => 'عريض',
                    'bullet_list' => 'قائمة نقطية',
                    'code_block' => 'كود',
                    'h1' => 'عنوان 1',
                    'h2' => 'عنوان 2',
                    'h3' => 'عنوان 3',
                    'italic' => 'مائل',
                    'link' => 'رابط',
                    'ordered_list' => 'قائمة مرتبة',
                    'redo' => 'إعادة',
                    'strike' => 'يتوسطه خط',
                    'undo' => 'تراجع',
                ],
            ],
        ],
        'fields' => [
            'boolean' => [
                'false' => 'لا',
                'true' => 'نعم',
            ],
        ],
    ],
    
     'notifications' => [
        'title' => 'الإشعارات',
        'dismiss' => 'تجاهل',
        'no_notifications' => 'لا توجد إشعارات',
    ],
    
     'badges' => [
        'filters' => [
            'active' => 'نشط',
            'inactive' => 'غير نشط',
        ],
    ],
    
     'common' => [
        'id' => 'المعرف',
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'phone' => 'الهاتف',
        'address' => 'العنوان',
        'description' => 'الوصف',
        'notes' => 'ملاحظات',
        'status' => 'الحالة',
        'type' => 'النوع',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
        'deleted_at' => 'تاريخ الحذف',
        'quantity' => 'الكمية',
        'price' => 'السعر',
        'total' => 'الإجمالي',
        'subtotal' => 'المجموع الفرعي',
        'discount' => 'الخصم',
        'tax' => 'الضريبة',
        'unit' => 'الوحدة',
        'code' => 'الكود',
        'barcode' => 'الباركود',
        'category' => 'الفئة',
        'supplier' => 'المورد',
        'customer' => 'العميل',
        'warehouse' => 'المستودع',
        'item' => 'الصنف',
        'bill' => 'الفاتورة',
        'memo' => 'المذكرة',
    ],
    
     'modals' => [
        'delete' => [
            'heading' => 'حذف :label',
            'subheading' => 'هل أنت متأكد من حذف هذا السجل؟',
            'buttons' => [
                'cancel' => [
                    'label' => 'إلغاء',
                ],
                'delete' => [
                    'label' => 'حذف',
                ],
            ],
        ],
        'force_delete' => [
            'heading' => 'حذف نهائي :label',
            'subheading' => 'هل أنت متأكد من الحذف النهائي لهذا السجل؟',
            'buttons' => [
                'cancel' => [
                    'label' => 'إلغاء',
                ],
                'delete' => [
                    'label' => 'حذف نهائي',
                ],
            ],
        ],
        'restore' => [
            'heading' => 'استعادة :label',
            'subheading' => 'هل أنت متأكد من استعادة هذا السجل؟',
            'buttons' => [
                'cancel' => [
                    'label' => 'إلغاء',
                ],
                'restore' => [
                    'label' => 'استعادة',
                ],
            ],
        ],
        'detach' => [
            'heading' => 'فصل :label',
            'subheading' => 'هل أنت متأكد من فصل هذا السجل؟',
            'buttons' => [
                'cancel' => [
                    'label' => 'إلغاء',
                ],
                'detach' => [
                    'label' => 'فصل',
                ],
            ],
        ],
    ],
];