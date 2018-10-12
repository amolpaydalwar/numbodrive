<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/04/2017
 * Time: 11:08
 */
if(!function_exists('s7upf_vc_text_header'))
{
    function s7upf_vc_text_header($attr,$content = false)
    {
        $html = $font_family = $button_line=$top_line=$class_rect_line=$class_margin = $class_style1 = $margin_top = $sub_text_color = $class_heading = $text_transform = $animation_css = $font_family = $sub_text = $bottom_line = $letter_spacing = $style = $margin_top = $extra_class  = $text = $margin_bottom = $text_align = $element_tag = $font_size = $font_weight = $font_style = $line_height = $font_color = $divider_align = '' ;
        extract(shortcode_atts(array(
            'text' => '',
            'element_tag' => 'h2',
            'font_size' => '',
            'font_weight' => '',
            'font_style' => '',
            'font_color' => '',
            'line_height' => '',
            'text_align' => 'text-center',
            'margin_bottom' => '',
            'extra_class' => '',
            'margin_top' => '',
            'style' => 'style1',
            'letter_spacing' => '',
            'font_family' => '',
            'sub_text' => '',
            'text_transform' => 'none',
            'sub_text_color' => '',
            'animation_css' => '',
            'margin_top' => '',
            'button_line' => 'off',
            'top_line' => 'off',
        ),$attr));

        if(!empty($font_size)){
            $class_heading .= S7upf_Assets::build_css('font-size:'.$font_size.'px!important;');
        }
        if(!empty($font_weight)){
            $class_heading .= ' '.S7upf_Assets::build_css('font-weight:'.$font_weight.'!important;');
        }
        if(!empty($font_style)){
            $class_heading .= ' '.S7upf_Assets::build_css('font-style:'.$font_style.'!important;');
        }
        if(!empty($line_height)){
            $class_heading .= ' '.S7upf_Assets::build_css('line-height:'.$line_height.'px!important;');
        }
        if(!empty($font_color)){
            $class_heading .= ' '.S7upf_Assets::build_css('color:'.$font_color.'!important;');
            $class_style1 .= ' '.S7upf_Assets::build_css('color:'.$font_color.'!important;',' .color');
        }
        if(!empty($sub_text_color)){
            $class_style1 .= ' '.S7upf_Assets::build_css('color:'.$sub_text_color.'!important;',' .sub_title');
        }
        if($margin_bottom !== ''){
            $class_margin .= ' '.S7upf_Assets::build_css('margin-bottom:'.$margin_bottom.'px!important;');
        }
        if($margin_top !== ''){
            $class_margin .= ' '.S7upf_Assets::build_css('margin-top:'.$margin_top.'px!important;');
        }
        if(!empty($letter_spacing)){
            $class_heading .= ' '.S7upf_Assets::build_css('letter-spacing:'.$letter_spacing.'px!important;');
        }
        if(!empty($text_transform)){
            $class_heading .= ' '.S7upf_Assets::build_css('text-transform:'.$text_transform.'!important;');
        }


        if('style1' === $style){
            $html .= '<div class="choise-title wow '.$extra_class.'  '.$text_align.' '.$animation_css.' '.$class_style1.'">
                        <h2 class="title30 paci-font color">'.$text.'</h2>
                        <h2 class="title30 font-bold text-uppercase sub_title">'.$sub_text.'</h2>
                    </div>';
        }else{

            $html .= '<div class="'.$class_margin.'">';
            if('rect_line'===$top_line) $html .= '<div class="dot-rect-line">';
            if('on' === $top_line || 'rect_line' === $top_line) $html .='<div class="dot-rect float-'.$text_align.'"><span></span></div>';
            if('rect_line'===$top_line) $html .= '</div>';
            $html .= '<'.$element_tag.' class="mb-text-header wow '.$animation_css.' '.$font_family.' '.$text_align.' '.$extra_class.' '.$class_heading.'">'.$text.'</'.$element_tag.'>';
            if('on' === $button_line) $html .= '<div class="dot-line float-'.$text_align.'"><span class="bg-color"></span></div>';
            $html .='</div>';
        }
        return $html;
    }
}
stp_reg_shortcode('s7upf_text_header','s7upf_vc_text_header');

vc_map(
    array(
        "name"      => esc_html__("SV Text Header", 'micar'),
        "base"      => "s7upf_text_header",
        "icon"      => "icon-st",
        "category"  => '7Up-theme',
        "params"    => array(
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Style Heading','micar'),
                'param_name' => 'style',
                'description' => esc_html__('Select style','micar'),
                'value' => array(
                    esc_html__('style 1 (default)','micar') => 'style1',
                    esc_html__('Custom','micar') => 'custom',
                ),
            ),
            array(
                'type' => 'textarea',
                'admin_label' => true,
                'heading' => esc_html__('Text','micar'),
                'param_name' => 'text',
                'description' => esc_html__('Enter a text','micar'),
            ),
            array(
                'type' => 'textarea',
                'admin_label' => true,
                'heading' => esc_html__('Sub Text','micar'),
                'param_name' => 'sub_text',
                'description' => esc_html__('Enter a text','micar'),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style1')
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Element Tag','micar'),
                'param_name' => 'element_tag',
                'description' => esc_html__('Select a element tag','micar'),
                'value' => array(
                    esc_html__('H1','micar') => 'h1',
                    esc_html__('H2','micar') => 'h2',
                    esc_html__('H3','micar') => 'h3',
                    esc_html__('H4','micar') => 'h4',
                    esc_html__('H5','micar') => 'h5',
                    esc_html__('H6','micar') => 'h6',
                    esc_html__('P','micar') => 'p',
                    esc_html__('div','micar') => 'div',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
                'std' => 'h2'
            ),
            array(
                'type' => 's7up_number',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Font size','micar'),
                'param_name' => 'font_size',
                'description' => esc_html__('Enter font size','micar'),
                'min' => 1,
                'suffix' => 'px',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Font color text','micar'),
                'param_name' => 'font_color',
                'description' => esc_html__('Select a color for heading','micar'),
                'edit_field_class' => 'vc_column vc_col-sm-6',
            ),
            array(
                'type' => 'colorpicker',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Font color sub text','micar'),
                'param_name' => 'sub_text_color',
                'description' => esc_html__('Select a color for heading','micar'),
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('style1')
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Font Weight','micar'),
                'param_name' => 'font_weight',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'description' => esc_html__('Select a font weight','micar'),
                'value' => array(
                    esc_html__('Default','micar') => '',
                    esc_html__('Normal','micar') => 'normal',
                    esc_html__('Bold','micar') => 'bold',
                    esc_html__('100','micar') => 100,
                    esc_html__('200','micar') => 200,
                    esc_html__('300','micar') => 300,
                    esc_html__('400','micar') => 400,
                    esc_html__('500','micar') => 500,
                    esc_html__('600','micar') => 600,
                    esc_html__('700','micar') => 700,
                    esc_html__('800','micar') => 800,
                    esc_html__('900','micar') => 900,
                ),
                'std' => '',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),

            ),
            array(
                'type' => 'dropdown',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Font style','micar'),
                'param_name' => 'font_style',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'description' => esc_html__('Select a font style','micar'),
                'value' => array(
                    esc_html__('Normal','micar') => '',
                    esc_html__('Italic','micar') => 'italic',
                    esc_html__('Oblique','micar') => 'oblique'
                ),
                'std' => '',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Font family','micar'),
                'param_name' => 'font_family',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'description' => esc_html__('Select a font family','micar'),
                'value' => array(
                    esc_html__('Inherit','micar') => '',
                    esc_html__('Raleway','micar') => 'rale-font',
                ),
                'std' => '',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Text Align','micar'),
                'param_name' => 'text_align',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'description' => esc_html__('Select a align for heading','micar'),
                'value' => array(
                    esc_html__('Center','micar') => 'text-center',
                    esc_html__('Left','micar') => 'text-left',
                    esc_html__('Right','micar') => 'text-right'
                ),
            ),
            array(
                'type' => 's7up_number',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Line Height','micar'),
                'param_name' => 'line_height',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'description' => esc_html__('Enter line height','micar'),
                'min' => 1,
                'suffix' => 'px',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),

            ),
            array(
                'type' => 's7up_number',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Letter Spacing','micar'),
                'param_name' => 'letter_spacing',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'description' => esc_html__('Enter letter spcing','micar'),
                'min' => 0,
                'suffix' => 'px',
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
            ),

            array(
                'type' => 'dropdown',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Text transform','micar'),
                'param_name' => 'text_transform',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'description' => esc_html__('Select text transform','micar'),
                'value' => array(
                    esc_html__('None','micar') => 'none',
                    esc_html__('Capitalize','micar') => 'capitalize',
                    esc_html__('Lowercase','micar') => 'lowercase',
                    esc_html__('Uppercase','micar') => 'uppercase'
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
            ),

            array(
                'type' => 's7up_number',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Margin Top','micar'),
                'param_name' => 'margin_top',
                'description' => esc_html__('Enter margin top','micar'),
                'min' => 1,
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'suffix' => 'px',
            ),
            array(
                'type' => 's7up_number',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Margin Bottom','micar'),
                'param_name' => 'margin_bottom',
                'description' => esc_html__('Enter margin bottom','micar'),
                'min' => 1,
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'suffix' => 'px'
            ),
            array(
                'type' => 'animation_style',
                'heading' => esc_html__( 'CSS animation', 'micar' ),
                'param_name' => 'animation_css',
                'group' => esc_html__('Design Option','micar'),
                'value' => '',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'settings' => array(
                    'type' => 'in',
                    'custom' => array(
                        array(
                            'label' => esc_html__( 'Default', 'micar' ),
                            'values' => array(
                                esc_html__( 'Top to bottom', 'micar' ) => 'top-to-bottom',
                                esc_html__( 'Bottom to top', 'micar' ) => 'bottom-to-top',
                                esc_html__( 'Left to right', 'micar' ) => 'left-to-right',
                                esc_html__( 'Right to left', 'micar' ) => 'right-to-left',
                                esc_html__( 'Appear from center', 'micar' ) => 'appear',
                            ),
                        ),
                    ),
                ),
                'description' => esc_html__( 'Select type of animation for element to be animated when it (enters) the browsers viewport (Note: works only in modern browsers).', 'micar' ),
            ),
            array(
                'type' => 'dropdown',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Show button line','micar'),
                'param_name' => 'button_line',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'value' => array(
                    esc_html__('Off','micar') => 'off',
                    esc_html__('On','micar') => 'on',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => esc_html__('Design Option','micar'),
                'heading' => esc_html__('Show top line','micar'),
                'param_name' => 'top_line',
                'edit_field_class' => 'vc_column vc_col-sm-6',
                'value' => array(
                    esc_html__('Off','micar') => 'off',
                    esc_html__('On (Dot rect)','micar') => 'on',
                    esc_html__('On (Dot rect line)','micar') => 'rect_line',
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value' => array('custom')
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Extra Class Name','micar'),
                'param_name' => 'extra_class',
                'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.','micar'),
            ),

        )
    )
);