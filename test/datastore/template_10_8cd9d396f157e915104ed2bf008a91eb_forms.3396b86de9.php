<?php

return <<<'VALUE'
"namespace IPS\\Theme;\nclass class_awards_front_forms extends \\IPS\\Theme\\Template\n{\n\t\t\tfunction addAward( $form ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n<div class=\"ipsPad\">\n    {$form}\n<\/div>\nCONTENT;\n\n\t\treturn $return;\n}\n\n\tfunction edit( $form ) {\n\t\t$return = '';\n\t\t$return .= <<<CONTENT\n\n<div class=\"ipsPad\">\n    {$form}\n<\/div>\n\nCONTENT;\n\n\t\treturn $return;\n}}"
VALUE;
