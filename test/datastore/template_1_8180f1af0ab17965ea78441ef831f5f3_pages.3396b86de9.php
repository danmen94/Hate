<?php

return <<<'VALUE'
"namespace IPS\\Theme;\nclass class_cms_admin_pages extends \\IPS\\Theme\\Template\n{\n\t\t\tfunction previewTemplateLink(  ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n<span data-role=\"viewTemplate\" class='ipsButton ipsButton_light ipsButton_verySmall'>\nCONTENT;\n\n$return .= \\IPS\\Member::loggedIn()->language()->addToStack( htmlspecialchars( 'cms_block_view_template', \\IPS\\HTMLENTITIES, 'UTF-8', FALSE ), TRUE, array(  ) );\n$return .= <<<CONTENT\n<\/span>\nCONTENT;\n\n\t\treturn $return;\n}}"
VALUE;
