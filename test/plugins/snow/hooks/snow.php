//<?php

class hook19 extends _HOOK_CLASS_
{

/* !Hook Data - DO NOT REMOVE */
public static function hookData() {
 return array_merge_recursive( array (
  'globalTemplate' => 
  array (
    0 => 
    array (
      'selector' => 'html > head',
      'type' => 'add_inside_end',
      'content' => '{{if settings.snow_enabler}}
<!-- LET IT SNOW -->
  <script src="{resource=\'plugins/snowstorm-min.js\' app=\'core\' location=\'global\'}"></script>
  <script>{{if settings.snow_mobile}}
    snowStorm.excludeMobile = false;
  {{endif}}
  snowStorm.animationInterval = {setting="snow_interval"};
  {{if settings.snow_flakebottom > 0}}
    snowStorm.flakeBottom = {setting="snow_flakebottom"};
  {{endif}}
  snowStorm.flakesMax = {setting="snow_max"};
  snowStorm.flakesMaxActive = {setting="snow_max_active"};
  snowStorm.snowColor = \'{setting="snow_color"}\';
  snowStorm.snowCharacter = \'{setting="snow_character"}\';
  snowStorm.flakeWidth = {setting="snow_flake_width"};
  snowStorm.flakeHeight = {setting="snow_flake_height"};
  {{if !settings.snow_stick}}
  snowStorm.useMeltEffect =  false;
  {{endif}}
  {{if !settings.snow_stick}}
  snowStorm.snowStick = false;
  {{endif}}
  {{if settings.snow_twinkle}}
  snowStorm.useTwinkleEffect = true;
  {{endif}}
  {{if settings.snow_target == \'document.body\'}}
    $(document).ready($(document.body).css(\'overflow\', \'hidden\'));
  {{else}}
    snowStorm.targetElement = \'{setting="snow_target"}\';
    $(document).ready($(\'{setting="snow_target"}\').css(\'overflow\', \'hidden\'));
  {{endif}}
  </script>
<!-- LET IT SNOW -->
{{endif}}',
    ),
  ),
), parent::hookData() );
}
/* End Hook Data */






















}
