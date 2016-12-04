<?php

return <<<'VALUE'
"namespace IPS\\Theme;\nclass class_cms_front_records extends \\IPS\\Theme\\Template\n{\n\t\t\tfunction categorySelector( $form ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\n<div class='ipsPad'>\n\t{$form}\n<\/div>\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction commentTemplate( $id, $action, $elements, $hiddenValues, $actionButtons, $uploadField, $class='' ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\n$minimized = false;\n$return .= <<<CONTENT\n\n<form accept-charset='utf-8' class=\"ipsForm \nCONTENT;\n$return .= htmlspecialchars( $class, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\" action=\"\nCONTENT;\n$return .= htmlspecialchars( $action, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\" method=\"post\" \nCONTENT;\n\nif ( $uploadField ):\n$return .= <<<CONTENT\nenctype=\"multipart\/form-data\"\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n>\n\t<input type=\"hidden\" name=\"\nCONTENT;\n$return .= htmlspecialchars( $id, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n_submitted\" value=\"1\">\n\t\nCONTENT;\n\nforeach ( $hiddenValues as $k => $v ):\n$return .= <<<CONTENT\n\n\t\t<input type=\"hidden\" name=\"\nCONTENT;\n$return .= htmlspecialchars( $k, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\" value=\"\nCONTENT;\n$return .= htmlspecialchars( $v, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\">\n\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\nCONTENT;\n\nif ( $uploadField ):\n$return .= <<<CONTENT\n\n\t\t<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"\nCONTENT;\n$return .= htmlspecialchars( $uploadField, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\">\n\t\t<input type=\"hidden\" name=\"plupload\" value=\"\nCONTENT;\n\n$return .= htmlspecialchars( md5( uniqid() ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\">\n\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t<div class='ipsComposeArea ipsComposeArea_withPhoto ipsClearfix ipsContained'>\n\t\t<div class='ipsPos_left ipsResponsive_hidePhone ipsResponsive_block'>\nCONTENT;\n\n$return .= \\IPS\\Theme::i()->getTemplate( \"global\", \"core\" )->userPhoto( \\IPS\\Member::loggedIn(), 'small' );\n$return .= <<<CONTENT\n<\/div>\n\t\t<div class='ipsComposeArea_editor'>\n\t\t\t\nCONTENT;\n\nif ( !\\IPS\\Member::loggedIn()->member_id ):\n$return .= <<<CONTENT\n\n\t\t\t\t<div data-ipsEditor-toolList class='ipsMessage ipsMessage_info'>\n\t\t\t\t\t\nCONTENT;\n\n$return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'commenting_as_guest', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n\n\t\t\t\t<\/div>\n\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\nCONTENT;\n\nforeach ( $elements as $collection ):\n$return .= <<<CONTENT\n\n\t\t\t\t\nCONTENT;\n\nforeach ( $collection as $input ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\nCONTENT;\n\nif ( $input->name == 'guest_name' ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t<ul class='ipsForm ipsForm_horizontal'>\n\t\t\t\t\t\t\t<li class='ipsFieldRow ipsFieldRow_fullWidth'>{$input->html()}<\/li>\n\t\t\t\t\t\t<\/ul>\n\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t\nCONTENT;\n\nforeach ( $elements as $collection ):\n$return .= <<<CONTENT\n\n\t\t\t\t\nCONTENT;\n\nforeach ( $collection as $input ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\nCONTENT;\n\nif ( $input instanceof \\IPS\\Helpers\\Form\\Editor ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nif ( $input->options['minimize'] !== NULL ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t\nCONTENT;\n\n$minimized = true;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t{$input->html( TRUE )}\n\t\t\t\t\t\t\t\nCONTENT;\n\nif ( $input->error ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t<br>\n\t\t\t\t\t\t\t<span class=\"ipsType_warning\">\nCONTENT;\n\n$val = \"{$input->error}\"; $return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( $val, \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n<\/span>\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t<ul class='ipsToolList ipsToolList_horizontal ipsClear ipsClearfix \nCONTENT;\n\nif ( $minimized ):\n$return .= <<<CONTENT\nipsJS_hide\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n' data-ipsEditor-toolList>\n\t\t\t\t\nCONTENT;\n\nforeach ( $elements as $collection ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\nCONTENT;\n\nforeach ( $collection as $input ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nif ( !($input instanceof \\IPS\\Helpers\\Form\\Editor) && $input->name != 'guest_name' and ! mb_stristr( $input->name, 'content_field_' ) ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t<li class='ipsPos_left ipsResponsive_noFloat \nCONTENT;\n\nif ( !($input instanceof \\IPS\\Helpers\\Form\\Captcha) ):\n$return .= <<<CONTENT\nipsComposeArea_formControl\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n ipsType_small'>{$input->html()}<\/li>\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nif ( mb_stristr( $input->name, 'content_field_' ) ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t{$input->rowHtml()}\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t\t\nCONTENT;\n\nforeach ( $actionButtons as $button ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t<li>{$button}<\/li>\n\t\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t<\/ul>\n\t\t<\/div>\n\t<\/div>\n<\/form>\nCONTENT;\n\n\t\treturn $return;\n}}"
VALUE;