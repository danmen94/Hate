<?php

return <<<'VALUE'
"namespace IPS\\Theme;\nclass class_awards_front_global extends \\IPS\\Theme\\Template\n{\n\t\t\tfunction hover( $author ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_hover_enable ):\n$return .= <<<CONTENT\n\n\nCONTENT;\n\n$data = $author->awardsHover();\n$return .= <<<CONTENT\n\n{$data}\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction hover_rows( $rows ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\n$size = explode( 'x', \\IPS\\Settings::i()->award_settings_hover_size );\n$return .= <<<CONTENT\n\n\nCONTENT;\n\nif ( count( $rows ) ):\n$return .= <<<CONTENT\n\n<li class=\"ipsDataItem\">\n    <span class=\"ipsDataItem_generic ipsDataItem_size3\"><strong> \nCONTENT;\n\n$return .= \\IPS\\Settings::i()->award_settings_hover_title;\n$return .= <<<CONTENT\n <\/strong><\/span>\n        <span class=\"ipsDataItem_main\">\n            <div class=\"\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_hover_alignment == 0 ):\n$return .= <<<CONTENT\nipsType_center\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_hover_alignment == 1 ):\n$return .= <<<CONTENT\nipsType_left\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_hover_alignment == 2 ):\n$return .= <<<CONTENT\nipsType_right\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\">\n            \nCONTENT;\n\nforeach ( $rows as $awarded ):\n$return .= <<<CONTENT\n\n                \nCONTENT;\n\n$member = \\IPS\\Member::load( $awarded->member );\n$return .= <<<CONTENT\n\n                <div class=\"awards_dataHover\">\n                    <a href='\nCONTENT;\n$return .= htmlspecialchars( $member->url()->setQueryString( ' tab', 'node_awards_Awards' ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_hover_style == 1 ):\n$return .= <<<CONTENT\ntitle='{$awarded->title}' data-ipsTooltip\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\ndata-ipsHover data-ipsHover-target='\nCONTENT;\n\n$return .= str_replace( '&', '&amp;', \\IPS\\Http\\Url::internal( \"app=awards&module=awards&controller=awards&do=award&id={$awarded->id}\", null, \"\", array(), 0 ) );\n$return .= <<<CONTENT\n' data-ipsHover-onClick=\"false\"\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n><img src=\"\nCONTENT;\n\n$return .= \\IPS\\File::get( \"awards_Awards\",  $awarded->container()->icon )->url;\n$return .= <<<CONTENT\n\" class=\"awards_award_img\" style=\"width: \nCONTENT;\n$return .= htmlspecialchars( $size[0], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx; height: \nCONTENT;\n$return .= htmlspecialchars( $size[1], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx;\"><\/a>\n                <\/div>\n\n            \nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n                <\/div>\n        <\/span>\n<\/li>\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction pane( $author ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_enable ):\n$return .= <<<CONTENT\n\n\nCONTENT;\n\n$data = $author->awardsPane();\n$return .= <<<CONTENT\n\n{$data}\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction pane_rows( $rows ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\n$size = explode( 'x', \\IPS\\Settings::i()->award_settings_pane_size );\n$return .= <<<CONTENT\n\n\nCONTENT;\n\nif ( count( $rows ) ):\n$return .= <<<CONTENT\n\n<li class='ipsType_break'>\n    <div class=\"ipsResponsive_showPhone ipsResponsive_block\">\n        <fieldset class=\"awards_fieldset\">\n            <legend class=\"awards_legend\"> \nCONTENT;\n\n$return .= \\IPS\\Settings::i()->award_settings_pane_title;\n$return .= <<<CONTENT\n<\/legend>\n            <ul class=\"ipsList_inline ipsList_csv ipsList_noSpacing\">\n\n            \nCONTENT;\n\nforeach ( $rows as $awarded ):\n$return .= <<<CONTENT\n\n            \nCONTENT;\n\n$member = \\IPS\\Member::load( $awarded->member );\n$return .= <<<CONTENT\n\n            <div class=\"awards_data\">\n                <a href='\nCONTENT;\n$return .= htmlspecialchars( $member->url()->setQueryString( ' tab', 'node_awards_Awards' ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_style == 1 ):\n$return .= <<<CONTENT\ntitle='{$awarded->title}' data-ipsTooltip\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\ndata-ipsHover data-ipsHover-target='\nCONTENT;\n\n$return .= str_replace( '&', '&amp;', \\IPS\\Http\\Url::internal( \"app=awards&module=awards&controller=awards&do=award&id={$awarded->id}\", null, \"\", array(), 0 ) );\n$return .= <<<CONTENT\n' data-ipsHover-onClick=\"false\"\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n><img src=\"\nCONTENT;\n\n$return .= \\IPS\\File::get( \"awards_Awards\",  $awarded->container()->icon )->url;\n$return .= <<<CONTENT\n\" class=\"awards_award_img\" style=\"width: \nCONTENT;\n$return .= htmlspecialchars( $size[0], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx; height: \nCONTENT;\n$return .= htmlspecialchars( $size[1], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx;\"><\/a>\n            <\/div>\n\n            \nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n                <\/ul>\n        <\/fieldset>\n    <\/div>\n    <div class=\"ipsResponsive_showTablet ipsResponsive_block\">\n        <fieldset class=\"awards_fieldset\">\n            <legend class=\"awards_legend \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 0 ):\n$return .= <<<CONTENT\nipsType_center\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 1 ):\n$return .= <<<CONTENT\nipsType_left\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 2 ):\n$return .= <<<CONTENT\nipsType_right\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\"> \nCONTENT;\n\n$return .= \\IPS\\Settings::i()->award_settings_pane_title;\n$return .= <<<CONTENT\n<\/legend>\n            <div class=\"\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 0 ):\n$return .= <<<CONTENT\nipsType_center\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 1 ):\n$return .= <<<CONTENT\nipsType_left\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 2 ):\n$return .= <<<CONTENT\nipsType_right\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\">\n                <ul class=\"ipsList_inline ipsList_csv ipsList_noSpacing\">\n\n                \nCONTENT;\n\nforeach ( $rows as $awarded ):\n$return .= <<<CONTENT\n\n                \nCONTENT;\n\n$member = \\IPS\\Member::load( $awarded->member );\n$return .= <<<CONTENT\n\n\n            <div class=\"awards_data\">\n                <a href='\nCONTENT;\n$return .= htmlspecialchars( $member->url()->setQueryString( ' tab', 'node_awards_Awards' ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_style == 1 ):\n$return .= <<<CONTENT\ntitle='{$awarded->title}' data-ipsTooltip\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\ndata-ipsHover data-ipsHover-target='\nCONTENT;\n\n$return .= str_replace( '&', '&amp;', \\IPS\\Http\\Url::internal( \"app=awards&module=awards&controller=awards&do=award&id={$awarded->id}\", null, \"\", array(), 0 ) );\n$return .= <<<CONTENT\n' data-ipsHover-onClick=\"false\"\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n><img src=\"\nCONTENT;\n\n$return .= \\IPS\\File::get( \"awards_Awards\",  $awarded->container()->icon )->url;\n$return .= <<<CONTENT\n\" class=\"awards_award_img\" style=\"width: \nCONTENT;\n$return .= htmlspecialchars( $size[0], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx; height: \nCONTENT;\n$return .= htmlspecialchars( $size[1], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx;\"><\/a>\n            <\/div>\n\n            \nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n                    <\/ul>\n                <\/div>\n        <\/fieldset>\n    <\/div>\n\n    <div class=\"ipsResponsive_showDesktop ipsResponsive_block\">\n        <fieldset class=\"awards_fieldset\">\n            <legend class=\"awards_legend \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 0 ):\n$return .= <<<CONTENT\nipsType_center\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 1 ):\n$return .= <<<CONTENT\nipsType_left\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 2 ):\n$return .= <<<CONTENT\nipsType_right\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\"> \nCONTENT;\n\n$return .= \\IPS\\Settings::i()->award_settings_pane_title;\n$return .= <<<CONTENT\n<\/legend>\n            <div class=\"\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 0 ):\n$return .= <<<CONTENT\nipsType_center\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 1 ):\n$return .= <<<CONTENT\nipsType_left\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_alignment == 2 ):\n$return .= <<<CONTENT\nipsType_right\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\">\n                <ul class=\"ipsList_inline ipsList_csv ipsList_noSpacing\">\n\n                \nCONTENT;\n\nforeach ( $rows as $awarded ):\n$return .= <<<CONTENT\n\n                \nCONTENT;\n\n$member = \\IPS\\Member::load( $awarded->member );\n$return .= <<<CONTENT\n\n\n        <div class=\"awards_data\">\n            <a href='\nCONTENT;\n$return .= htmlspecialchars( $member->url()->setQueryString( ' tab', 'node_awards_Awards' ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_pane_style == 1 ):\n$return .= <<<CONTENT\ntitle='{$awarded->title}' data-ipsTooltip\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\ndata-ipsHover data-ipsHover-target='\nCONTENT;\n\n$return .= str_replace( '&', '&amp;', \\IPS\\Http\\Url::internal( \"app=awards&module=awards&controller=awards&do=award&id={$awarded->id}\", null, \"\", array(), 0 ) );\n$return .= <<<CONTENT\n' data-ipsHover-onClick=\"false\"\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n><img src=\"\nCONTENT;\n\n$return .= \\IPS\\File::get( \"awards_Awards\",  $awarded->container()->icon )->url;\n$return .= <<<CONTENT\n\" class=\"awards_award_img\" style=\"width: \nCONTENT;\n$return .= htmlspecialchars( $size[0], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx; height: \nCONTENT;\n$return .= htmlspecialchars( $size[1], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx;\"><\/a>\n        <\/div>\n\n            \nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n                    <\/ul>\n                <\/div>\n        <\/fieldset>\n    <\/div>\n\n<\/li>\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction posts( $author ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_enable ):\n$return .= <<<CONTENT\n\n\nCONTENT;\n\n$data = $author->awardsPosts();\n$return .= <<<CONTENT\n\n{$data}\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction posts_rows( $rows ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\n$size = explode( 'x', \\IPS\\Settings::i()->award_settings_posts_size );\n$return .= <<<CONTENT\n\n\nCONTENT;\n\nif ( count( $rows ) ):\n$return .= <<<CONTENT\n\n<div class=\"cPost_contentWrap ipsPad\">\n<fieldset class=\"awards_fieldset\">\n    <legend class=\"awards_legend \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_alignment == 0 ):\n$return .= <<<CONTENT\nipsType_center\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_alignment == 1 ):\n$return .= <<<CONTENT\nipsType_left\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_alignment == 2 ):\n$return .= <<<CONTENT\nipsType_right\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\"> \nCONTENT;\n\n$return .= \\IPS\\Settings::i()->award_settings_posts_title;\n$return .= <<<CONTENT\n <\/legend>\n    <div class=\"\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_alignment == 0 ):\n$return .= <<<CONTENT\nipsType_center\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_alignment == 1 ):\n$return .= <<<CONTENT\nipsType_left\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_alignment == 2 ):\n$return .= <<<CONTENT\nipsType_right\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\">\n    \nCONTENT;\n\nforeach ( $rows as $awarded ):\n$return .= <<<CONTENT\n\n        \nCONTENT;\n\n$member = \\IPS\\Member::load( $awarded->member );\n$return .= <<<CONTENT\n\n\n    <div class=\"awards_data\">\n        <a href='\nCONTENT;\n$return .= htmlspecialchars( $member->url()->setQueryString( ' tab', 'node_awards_Awards' ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' \nCONTENT;\n\nif ( \\IPS\\Settings::i()->award_settings_posts_style == 1 ):\n$return .= <<<CONTENT\ntitle='{$awarded->title}' data-ipsTooltip\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\ndata-ipsHover data-ipsHover-target='\nCONTENT;\n\n$return .= str_replace( '&', '&amp;', \\IPS\\Http\\Url::internal( \"app=awards&module=awards&controller=awards&do=award&id={$awarded->id}\", null, \"\", array(), 0 ) );\n$return .= <<<CONTENT\n' data-ipsHover-onClick=\"false\"\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n>\n            <img src=\"\nCONTENT;\n\n$return .= \\IPS\\File::get( \"awards_Awards\", $awarded->container()->icon )->url;\n$return .= <<<CONTENT\n\" class=\"awards_award_img\" style=\"width: \nCONTENT;\n$return .= htmlspecialchars( $size[0], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx; height: \nCONTENT;\n$return .= htmlspecialchars( $size[1], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\npx;\">\n        <\/a>\n    <\/div>\n\n    \nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n        <\/div>\n<\/fieldset>\n    <\/div>\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n<br>\nCONTENT;\n\n\t\treturn $return;\n}}"
VALUE;