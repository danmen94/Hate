<?php

return <<<'VALUE'
"namespace IPS\\Theme;\nclass class_core_front_online extends \\IPS\\Theme\\Template\n{\n\t\t\tfunction onlineUsersList( $table, $totalCount ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\n$return .= \\IPS\\Theme::i()->getTemplate( \"global\", \\IPS\\Request::i()->app )->pageHeader( \\IPS\\Member::loggedIn()->language()->addToStack('online_users') );\n$return .= <<<CONTENT\n\n<br>\n\nCONTENT;\n\n$return .= \\IPS\\Theme::i()->settings['ipsfocus_b1'];\n$return .= <<<CONTENT\n<h2 class='ipsType_sectionTitle ipsType_reset ipsType_medium'>\nCONTENT;\n\n$pluralize = array( $totalCount ); $return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'online_user_count', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), FALSE, array( 'pluralize' => $pluralize ) );\n$return .= <<<CONTENT\n<\/h2>\nCONTENT;\n\n$return .= \\IPS\\Theme::i()->settings['ipsfocus_b2'];\n$return .= <<<CONTENT\n\n\t{$table}\n\nCONTENT;\n\n$return .= \\IPS\\Theme::i()->settings['ipsfocus_b3'];\n$return .= <<<CONTENT\n\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction onlineUsersRow( $table, $headers, $rows ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\nCONTENT;\n\nif ( !empty($rows)  ):\n$return .= <<<CONTENT\n\n\t\nCONTENT;\n\nforeach ( $rows as $row ):\n$return .= <<<CONTENT\n\n\t\t<li class='ipsGrid_span4 ipsPhotoPanel ipsPhotoPanel_small ipsClearfix cOnlineUser \nCONTENT;\n\nif ( $row['login_type'] == \\IPS\\Session\\Front::LOGIN_TYPE_ANONYMOUS ):\n$return .= <<<CONTENT\nipsFaded\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n'>\n\t\t\t{$row['photo']}\n\t\t\t<div>\n\t\t\t\t<div class='ipsContained'>\n\t\t\t\t\t<h3 class='ipsType_reset ipsType_normal'>\n\t\t\t\t\t\t\nCONTENT;\n\nif ( $row['login_type'] == \\IPS\\Session\\Front::LOGIN_TYPE_ANONYMOUS ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t<span class=\"ipsBadge ipsBadge_icon ipsBadge_small ipsBadge_style6\" title='\nCONTENT;\n\n$return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'signed_in_anoymously', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n' data-ipsTooltip><i class='fa fa-eye'><\/i><\/span>\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t{$row['member_name']}\n\t\t\t\t\t<\/h3>\n\t\t\t\t\t<p class='ipsType_reset ipsTruncate ipsTruncate_line ipsType_break'>{$row['location_lang']}<\/p>\n\t\t\t\t\t<p class='ipsType_reset ipsTruncate ipsTruncate_line ipsType_light'>\n\t\t\t\t\t\t\nCONTENT;\n$return .= htmlspecialchars( $row['running_time'], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nif ( \\IPS\\Member::loggedIn()->modPermission( 'can_use_ip_tools' ) ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t&nbsp;&middot;&nbsp;\nCONTENT;\n$return .= htmlspecialchars( $row['ip_address'], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t<\/p>\n\t\t\t\t<\/div>\n\t\t\t<\/div>\n\t\t<\/li>\n\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\n\n\t<li>\nCONTENT;\n\n$return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'online_users_no_results', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n<\/li>\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction onlineUsersTable( $table, $headers, $rows, $quickSearch ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n<div data-baseurl='\nCONTENT;\n$return .= htmlspecialchars( $table->baseUrl, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' data-resort='\nCONTENT;\n$return .= htmlspecialchars( $table->resortKey, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' data-controller='core.global.core.table\nCONTENT;\n\nif ( $table->canModerate() ):\n$return .= <<<CONTENT\n,core.front.core.moderation\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n'>\n\t<div class=\"ipsButtonBar ipsPad_half ipsClearfix ipsClear\">\n\t\t<ul class=\"ipsButtonRow ipsPos_right ipsClearfix\">\n\t\t\t<li>\n\t\t\t\t<a href=\"#elSortByMenu_menu\" id=\"elSortByMenu\" data-role=\"sortButton\" data-ipsMenu data-ipsMenu-activeClass=\"ipsButtonRow_active\" data-ipsMenu-selectable=\"radio\">\nCONTENT;\n\n$return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'sort_by', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n <i class=\"fa fa-caret-down\"><\/i><\/a>\n\t\t\t\t<ul class=\"ipsMenu ipsMenu_auto ipsMenu_withStem ipsMenu_selectable ipsHide\" id=\"elSortByMenu_menu\">\n\t\t\t\t\t<li class=\"ipsMenu_item \nCONTENT;\n\nif ( $table->sortBy == 'running_time' ):\n$return .= <<<CONTENT\nipsMenu_itemChecked\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\" data-ipsMenuValue=\"running_time\"><a href=\"\nCONTENT;\n$return .= htmlspecialchars( $table->baseUrl->setQueryString( array( 'filter' => $table->filter, 'sortby' => 'running_time', 'sortdirection' => 'desc', 'page' => '1', 'group' => \\IPS\\Request::i()->group ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\">\nCONTENT;\n\n$val = \"{$table->langPrefix}running_time\"; $return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( $val, \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n<\/a><\/li>\n\t\t\t\t\t<li class=\"ipsMenu_item \nCONTENT;\n\nif ( $table->sortBy == 'member_name' ):\n$return .= <<<CONTENT\nipsMenu_itemChecked\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\" data-ipsMenuValue=\"member_name\"><a href=\"\nCONTENT;\n$return .= htmlspecialchars( $table->baseUrl->setQueryString( array( 'filter' => $table->filter, 'sortby' => 'member_name', 'sortdirection' => 'asc', 'page' => '1', 'group' => \\IPS\\Request::i()->group ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\">\nCONTENT;\n\n$val = \"{$table->langPrefix}member_name\"; $return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( $val, \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n<\/a><\/li>\n\t\t\t\t<\/ul>\n\t\t\t<\/li>\n\n\t\t\t\nCONTENT;\n\nif ( !empty( $table->filters ) ):\n$return .= <<<CONTENT\n\n\t\t\t\t<li>\n\t\t\t\t\t<a href=\"#elFilterByMenu_\nCONTENT;\n$return .= htmlspecialchars( $table->uniqueId, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n_menu\" data-role=\"tableFilterMenu\" id=\"elFilterByMenu_\nCONTENT;\n$return .= htmlspecialchars( $table->uniqueId, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\" data-ipsMenu data-ipsMenu-activeClass=\"ipsButtonRow_active\" data-ipsMenu-selectable=\"radio\">\nCONTENT;\n\n$return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'filter_by', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n <i class=\"fa fa-caret-down\"><\/i><\/a>\n\t\t\t\t\t<ul class='ipsMenu ipsMenu_auto ipsMenu_withStem ipsMenu_selectable ipsHide' id='elFilterByMenu_\nCONTENT;\n$return .= htmlspecialchars( $table->uniqueId, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n_menu'>\n\t\t\t\t\t\t<li data-action=\"tableFilter\" data-ipsMenuValue='' class='ipsMenu_item \nCONTENT;\n\nif ( !$table->filter ):\n$return .= <<<CONTENT\nipsMenu_itemChecked\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n'>\n\t\t\t\t\t\t\t<a href='\nCONTENT;\n$return .= htmlspecialchars( $table->baseUrl->setQueryString( array( 'sortby' => $table->sortBy, 'sortdirection' => $table->sortDirection, 'page' => '1', 'filter' => '', 'group' => \\IPS\\Request::i()->group ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' class='\nCONTENT;\n\nif ( !array_key_exists( $table->filter, $table->filters ) ):\n$return .= <<<CONTENT\nipsButtonRow_active\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n'>\nCONTENT;\n\n$return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'all', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n<\/a>\n\t\t\t\t\t\t<\/li>\n\t\t\t\t\t\t\nCONTENT;\n\nforeach ( $table->filters as $k => $q ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t<li data-action=\"tableFilter\" data-ipsMenuValue='\nCONTENT;\n$return .= htmlspecialchars( $k, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' class='ipsMenu_item \nCONTENT;\n\nif ( $k === $table->filter ):\n$return .= <<<CONTENT\nipsMenu_itemChecked\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n'>\n\t\t\t\t\t\t\t\t<a href='\nCONTENT;\n$return .= htmlspecialchars( $table->baseUrl->setQueryString( array( 'filter' => $k, 'sortby' => $table->sortBy, 'sortdirection' => $table->sortDirection, 'page' => '1', 'group' => \\IPS\\Request::i()->group ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n'>\nCONTENT;\n\n$val = \"{$table->langPrefix}{$k}\"; $return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( $val, \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n<\/a>\n\t\t\t\t\t\t\t<\/li>\n\t\t\t\t\t\t\nCONTENT;\n\nendforeach;\n$return .= <<<CONTENT\n\n\t\t\t\t\t<\/ul>\n\t\t\t\t<\/li>\n\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t<\/ul>\n\t\t\nCONTENT;\n\nif ( $table->pages > 1 ):\n$return .= <<<CONTENT\n\n\t\t\t<div data-role=\"tablePagination\">\n\t\t\t\t\nCONTENT;\n\n$return .= \\IPS\\Theme::i()->getTemplate( \"global\", \"core\", 'global' )->pagination( $table->baseUrl, $table->pages, $table->page, $table->limit );\n$return .= <<<CONTENT\n\n\t\t\t<\/div>\n\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t<\/div>\n\n\t<ol class='ipsList_reset ipsPad ipsGrid ipsGrid_collapsePhone ipsClear' data-ipsGrid data-role='tableRows'>\n\t\t\nCONTENT;\n\n$return .= $table->rowsTemplate[0]->{$table->rowsTemplate[1]}( $table, $headers, $rows );\n$return .= <<<CONTENT\n\n\t<\/ol>\n\n\t\nCONTENT;\n\nif ( $table->pages > 1 ):\n$return .= <<<CONTENT\n\n\t\t<div class=\"ipsButtonBar ipsPad_half ipsClearfix ipsClear\" data-role=\"tablePagination\">\n\t\t\t\nCONTENT;\n\n$return .= \\IPS\\Theme::i()->getTemplate( \"global\", \"core\", 'global' )->pagination( $table->baseUrl, $table->pages, $table->page, $table->limit );\n$return .= <<<CONTENT\n\n\t\t<\/div>\n\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n<\/div>\nCONTENT;\n\n\t\treturn $return;\n}}"
VALUE;