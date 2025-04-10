<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DOMPDF Options
    |--------------------------------------------------------------------------
    |
    | Configuration options for PDF generation using DOMPDF
    |
    */

    'show_warnings' => env('DOMPDF_SHOW_WARNINGS', false),
    'default_paper_size' => 'a4',
    'default_font' => 'amiri',
    
    // Font configuration
    'font_dir' => storage_path('fonts'),  // Don't use public_path() here
    'font_cache' => storage_path('fonts'),
    'font_height_ratio' => 0.9,  // Better Arabic line spacing
    
    // Security
    'chroot' => realpath(base_path()),
    'log_output_file' => storage_path('logs/dompdf.html'),
    
    // RTL/LTR configuration
    'enable_rtl' => true,
    'enable_css_float' => true,
    
    // Image handling
    'enable_remote' => true,
    'dpi' => 300,
    
    // Debugging
    'debug_png' => env('DOMPDF_DEBUG_PNG', false),
    'debug_keep_temp' => env('DOMPDF_DEBUG_KEEP_TEMP', false),
    'debug_css' => env('DOMPDF_DEBUG_CSS', false),
    
    // Advanced configuration
    'temp_dir' => sys_get_temp_dir(),
    'admin_username' => '',
    'admin_password' => '',
    
    // PDF rendering options
    'isPhpEnabled' => true,
    'isHtml5ParserEnabled' => true,
    'isJavascriptEnabled' => false,
    
    // Arabic-specific tweaks
    'enable_unicode' => true,
    'unicode_special' => true,
    'unix_style' => true,
    
    // Margin configuration
    'margin_header' => 5,
    'margin_footer' => 5,
    'margin_top' => 15,
    'margin_bottom' => 15,
    'margin_left' => 15,
    'margin_right' => 15,
];