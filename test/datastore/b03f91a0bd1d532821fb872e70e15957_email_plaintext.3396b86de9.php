<?php

return <<<'VALUE'
"namespace IPS\\Theme;\n\tfunction email_html_core_emailWrapper( $subject, $member, $content, $unsubscribe, $placeholderRecipient=FALSE, $introText='', $email ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n<!DOCTYPE html PUBLIC \"-\/\/W3C\/\/DTD XHTML 1.0 Strict\/\/EN\" \"http:\/\/www.w3.org\/TR\/xhtml1\/DTD\/xhtml1-strict.dtd\"> \n<html xmlns=\"http:\/\/www.w3.org\/1999\/xhtml\" dir=\"{dir}\">\n\t<head>\n\t\t<meta http-equiv=\"Content-Type\" content=\"text\/html; charset=utf-8\" \/>\n\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"\/>\n\t\t<title>\nCONTENT;\n$return .= htmlspecialchars( $subject, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n<\/title>\n\t\t<style type=\"text\/css\">\n\t\t\n\t\t\t#outlook a {padding:0;}\n\t\t\tbody{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} \n\t\t\t.ExternalClass {width:100%;}\n\t\t\t.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}\n\t\t\t#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}\n\n\t\t\timg {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} \n\t\t\ta img {border:none;} \n\t\t\t.image_fix {display:block;}\n\n\t\t\tp {margin: 1em 0;}\n\n\t\t\th1 { color: white !important; }\n\t\t\th2, h3, h4, h5, h6 {color: #333333 !important;}\n\n\t\t\th1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {\n\t\t\t\tcolor: red !important;\n\t\t\t}\n\n\t\t\th1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {\n\t\t\t\tcolor: purple !important;\n\t\t\t}\n\n\t\t\ttable td {border-collapse: collapse;}\n\n\t\t\ttable { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }\n\n\t\t\ta {color: #4a8aca;}\n\t\t\t\n\t\t\t\/* Unhides cells that we set to hide in the HTML in case the client doesn't support style properly *\/\n\t\t\t*[class~=hidePhone] {\n\t\t\t    display : block !important;\n\t\t\t    width : auto !important;\n\t\t\t    max-height: inherit !important;\n\t\t\t    overflow : visible !important;\n\t\t\t    float : none !important;\n\t\t\t}\n\n\t\t\t*[class~=hidePhone][width=\"30\"] {\n\t\t\t\twidth: 30px !important;\n\t\t\t}\n\n\t\t\t*[class~=hidePhone][width=\"40\"] {\n\t\t\t\twidth: 40px !important;\n\t\t\t}\n\n\t\t\ttd[class~=hidePhone] {\n\t\t\t\tdisplay: table-cell !important;\n\t\t\t}\n\n\t\t\t@media only screen and (max-device-width: 480px) {\n\t\t\t\ta[href^=\"tel\"], a[href^=\"sms\"] {\n\t\t\t\t\ttext-decoration: none;\n\t\t\t\t\tcolor: blue;\n\t\t\t\t\tpointer-events: none;\n\t\t\t\t\tcursor: default;\n\t\t\t\t}\n\n\t\t\t\t.mobile_link a[href^=\"tel\"], .mobile_link a[href^=\"sms\"] {\n\t\t\t\t\ttext-decoration: default;\n\t\t\t\t\tcolor: orange !important;\n\t\t\t\t\tpointer-events: auto;\n\t\t\t\t\tcursor: default;\n\t\t\t\t}\n\n\t\t\t\t#userPhoto, .hidePhone, *[class~=hidePhone], td[class~=hidePhone] {\n\t\t\t\t\tdisplay: none !important;\n\t\t\t\t}\n\n\t\t\t\t.responsive_table > tr > td, .responsive_table > tbody > tr > td,\n\t\t\t\t.responsive_table > tr, .responsive_table > tbody > tr {\n\t\t\t\t\tdisplay: block;\n\t\t\t\t\ttext-align: left;\n\t\t\t\t}\n\n\t\t\t\thtml[dir=\"rtl\"] .responsive_table > tr > td, html[dir=\"rtl\"] .responsive_table > tbody > tr > td,\n\t\t\t\thtml[dir=\"rtl\"] .responsive_table > tr, html[dir=\"rtl\"] .responsive_table > tbody > tr {\n\t\t\t\t\ttext-align: right;\n\t\t\t\t}\n\n\t\t\t\t.responsive_row {\n\t\t\t\t\tmargin-bottom: 10px;\n\t\t\t\t}\n\n\t\t\t\t.responsive_fullwidth {\n\t\t\t\t\twidth: 100% !important;\n\t\t\t\t}\n\t\t\t}\n\n\t\t\t@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {\n\t\t\t\ta[href^=\"tel\"], a[href^=\"sms\"] {\n\t\t\t\t\ttext-decoration: none;\n\t\t\t\t\tcolor: blue;\n\t\t\t\t\tpointer-events: none;\n\t\t\t\t\tcursor: default;\n\t\t\t\t}\n\n\t\t\t\t.mobile_link a[href^=\"tel\"], .mobile_link a[href^=\"sms\"] {\n\t\t\t\t\ttext-decoration: default;\n\t\t\t\t\tcolor: orange !important;\n\t\t\t\t\tpointer-events: auto;\n\t\t\t\t\tcursor: default;\n\t\t\t\t}\n\t\t\t}\n\t\t<\/style>\n\t<\/head>\n\t<body bgcolor=\"#f1f1f1\" style='direction: {dir}'>\n\t\t<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\" bgcolor=\"#f1f1f1\">\n\t\t\t<tr height='25'>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t<\/tr>\n\t\t\t<tr>\n\t\t\t\t<td dir='{dir}' valign=\"top\"><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}' valign='middle' style=\"font-family: 'Helvetica Neue', helvetica, sans-serif; font-size: 30px; font-weight: 300; color: #262e33; line-height: 48px; padding-left: 10px;\">\n\t\t\t\t\t<a href='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\n' style='text-decoration: none; color: #262e33; border: 0;'>\n\t\t\t\t\t\t\nCONTENT;\n\n$imgDims=NULL;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nif ( \\IPS\\Settings::i()->email_logo ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t\nCONTENT;\n\ntry { $imgDims = \\IPS\\File::get( 'core_Theme', \\IPS\\Settings::i()->email_logo )->getImageDimensions(); } catch( \\Exception $e ) {} \n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nif ( $imgDims ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t<img src='\nCONTENT;\n\n$return .= \\IPS\\File::get( \"core_Theme\", \\IPS\\Settings::i()->email_logo )->url;\n$return .= <<<CONTENT\n' alt=\"\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->board_name;\n$return .= <<<CONTENT\n\" width='\nCONTENT;\n$return .= htmlspecialchars( $imgDims[0], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' height='\nCONTENT;\n$return .= htmlspecialchars( $imgDims[1], ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n' \/>\n\t\t\t\t\t\t\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->board_name;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t<\/a>\n\t\t\t\t<\/td>\n\t\t\t\t<td dir='{dir}' valign=\"top\"><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t<\/tr>\n\t\t\t<tr height='25'>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t<\/tr>\n\t\t\t<tr>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}' width='800' id='main' bgcolor='#ffffff' style='border-top: 10px solid \nCONTENT;\n\n$return .= \\IPS\\Settings::i()->email_color;\n$return .= <<<CONTENT\n; line-height: 1.5;'>\n\t\t\t\t\t<table width='100%' cellpadding='20'>\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td dir='{dir}' style=\"font-family: 'Helvetica Neue', helvetica, sans-serif; font-size: 15px; color: #333333; line-height: 21px\">\n\t\t\t\t\t\t\t\t\nCONTENT;\n\nif ( $introText ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t\t\t<h1 style=\"font-family: 'Helvetica Neue', helvetica, sans-serif; color: \nCONTENT;\n\n$return .= \\IPS\\Settings::i()->email_color;\n$return .= <<<CONTENT\n !important; font-size: 28px; font-weight: 500 !important;\"><center>\nCONTENT;\n$return .= htmlspecialchars( $introText, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n<\/center><\/h1>\n\t\t\t\t\t\t\t\t\t<br>\n\t\t\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t\t\nCONTENT;\n\nif ( $member->member_id  ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t\t\t<strong style='font-size: 17px'>\nCONTENT;\n$return .= htmlspecialchars( $email->language->addToStack(\"email_greeting_member\", FALSE, array( 'sprintf' => array( $member->name ) ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n<\/strong>\n\t\t\t\t\t\t\t\t\t<br \/>\n\t\t\t\t\t\t\t\t\nCONTENT;\n\nelseif ( $placeholderRecipient ):\n$return .= <<<CONTENT\n\n\t\t\t\t\t\t\t\t\t<strong style='font-size: 17px'>\nCONTENT;\n$return .= htmlspecialchars( $email->language->addToStack(\"email_greeting_member\", FALSE, array( 'sprintf' => array( '*|member_name|*' ) ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n<\/strong>\n\t\t\t\t\t\t\t\t\t<br \/>\n\t\t\t\t\t\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\n\t\t\t\t\t\t\t\t{$content}\n\t\t\t\t\t\t\t<\/td>\n\t\t\t\t\t\t<\/tr>\n\t\t\t\t\t<\/table>\n\t\t\t\t<\/td>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t<\/tr>\n\t\t\t<tr height='25'>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<td dir='{dir}'><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t<\/tr>\n\t\t\t\nCONTENT;\n\nif ( $unsubscribe ):\n$return .= <<<CONTENT\n\n\t\t\t\t{$unsubscribe}\n\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\nCONTENT;\n\nif ( \\IPS\\Settings::i()->privacy_type != \"none\" ):\n$return .= <<<CONTENT\n\n\t\t\t\t<tr>\n\t\t\t\t\t<td dir='{dir}' valign=\"top\"><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t\t<td dir='{dir}' valign='middle' align='center' style=\"font-family: 'Helvetica Neue', helvetica, sans-serif; font-size: 12px; line-height: 18px; padding-left: 10px;\">\n\t\t\t\t\t\t<a href='\nCONTENT;\n\nif ( \\IPS\\Settings::i()->privacy_type == \"internal\" ):\n$return .= <<<CONTENT\n\nCONTENT;\n\n$return .= str_replace( '&', '&amp;', \\IPS\\Http\\Url::internal( \"app=core&module=system&controller=privacy\", \"front\", \"privacy\", array(), 0 ) );\n$return .= <<<CONTENT\n\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\n\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->privacy_link;\n$return .= <<<CONTENT\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n' style='color: #4a8aca; text-decoration: none;  display: inline-block'>\nCONTENT;\n$return .= htmlspecialchars( $email->language->addToStack(\"privacy_policy_link\", FALSE), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n<\/a>\n\t\t\t\t\t<\/td>\n\t\t\t\t\t<td dir='{dir}' valign=\"top\"><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<\/tr>\n\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\nCONTENT;\n\nif ( \\IPS\\Settings::i()->board_name ):\n$return .= <<<CONTENT\n\n\t\t\t\t<tr>\n\t\t\t\t\t<td dir='{dir}' valign=\"top\"><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t\t<td dir='{dir}' valign='top' width='800' align='center' style=\"font-family: 'Helvetica Neue', helvetica, sans-serif; font-size: 12px; color: #bdbdbd; line-height: 18px; padding-left: 10px;\">\n\t\t\t\t\t\t\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->board_name;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->site_address and \\IPS\\Settings::i()->site_address != 'null' ):\n$return .= <<<CONTENT\n, \nCONTENT;\n\n$return .= \\IPS\\GeoLocation::parseForOutput( \\IPS\\Settings::i()->site_address );\n$return .= <<<CONTENT\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t\t\t\t<\/td>\n\t\t\t\t\t<td dir='{dir}' valign=\"top\"><img src='\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->base_url;\n$return .= <<<CONTENT\napplications\/core\/interface\/email\/spacer.png' width='1' height='1' alt=''><\/td>\n\t\t\t\t<\/tr>\n\t\t\t\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\t\t<\/table>\n\t<\/body>\n<\/html>\n\nCONTENT;\n\n\t\treturn $return;\n}\n\tfunction email_plaintext_core_emailWrapper( $subject, $member, $content, $unsubscribe, $placeholderRecipient=FALSE, $introText='', $email ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n\n\nCONTENT;\n\nif ( $member->member_id  ):\n$return .= <<<CONTENT\n\nCONTENT;\n$return .= htmlspecialchars( $email->language->addToStack(\"email_greeting_member\", FALSE, array( 'sprintf' => array( $member->name ) ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\nCONTENT;\n\nelseif ( $placeholderRecipient ):\n$return .= <<<CONTENT\n\nCONTENT;\n$return .= htmlspecialchars( $email->language->addToStack(\"email_greeting_member\", FALSE, array( 'sprintf' => array( '*|member_name|*' ) ) ), ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n{$content}\n\n-----\n\nCONTENT;\n\nif ( $unsubscribe ):\n$return .= <<<CONTENT\n\nCONTENT;\n$return .= htmlspecialchars( $unsubscribe, ENT_QUOTES | \\IPS\\HTMLENTITIES, 'UTF-8', FALSE );\n$return .= <<<CONTENT\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->privacy_type != \"none\" ):\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->privacy_type == \"internal\" ):\n$return .= <<<CONTENT\n\nCONTENT;\n\n$return .= \\IPS\\Http\\Url::internal( \"app=core&module=system&controller=privacy\", \"front\", \"privacy\", array(), 0 );\n$return .= <<<CONTENT\n\nCONTENT;\n\nelse:\n$return .= <<<CONTENT\n\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->privacy_link;\n$return .= <<<CONTENT\n)\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\n\n\nCONTENT;\n\n$return .= \\IPS\\Settings::i()->board_name;\n$return .= <<<CONTENT\n\nCONTENT;\n\nif ( \\IPS\\Settings::i()->site_address and \\IPS\\Settings::i()->site_address != 'null' ):\n$return .= <<<CONTENT\n, \nCONTENT;\n\n$return .= \\IPS\\GeoLocation::parseForOutput( \\IPS\\Settings::i()->site_address );\n$return .= <<<CONTENT\n\nCONTENT;\n\nendif;\n$return .= <<<CONTENT\n\nCONTENT;\n\n\t\treturn $return;\n}"
VALUE;