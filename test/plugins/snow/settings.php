//<?php

$form->add( new \IPS\Helpers\Form\YesNo(
    'snow_enabler',
    \IPS\Settings::i()->snow_enabler
) );

$form->add( new \IPS\Helpers\Form\YesNo(
    'snow_mobile',
    \IPS\Settings::i()->snow_mobile
) );

$form->add( new \IPS\Helpers\Form\YesNo(
    'snow_melt',
    IPS\Settings::i()->snow_melt
) );

$form->add( new \IPS\Helpers\Form\YesNo(
    'snow_stick',
    \IPS\Settings::i()->snow_stick
) );

$form->add( new \IPS\Helpers\Form\YesNo(
    'snow_twinkle',
    \IPS\Settings::i()->snow_twinkle
) );

$form->add( new \IPS\Helpers\Form\Text(
    'snow_character',
    \IPS\Settings::i()->snow_character,
    TRUE
) );

$form->add( new \IPS\Helpers\Form\Color(
    'snow_color',
    \IPS\Settings::i()->snow_color,
    TRUE
) );

$form->add( new \IPS\Helpers\Form\Number(
    'snow_flakebottom',
    \IPS\Settings::i()->snow_flakebottom,
    TRUE,
    array(
        min => 0,
        max => 2048,
        step => 1,
        unlimited => NULL
    )
) );

$form->add( new \IPS\Helpers\Form\Number(
    'snow_max',
    \IPS\Settings::i()->snow_max,
    TRUE,
    array(
        min => 0,
        max => 2048,
        step => 1,
        unlimited => NULL
    )
) );

$form->add( new \IPS\Helpers\Form\Number(
    'snow_max_active',
    \IPS\Settings::i()->snow_max_active,
    TRUE,
    array(
        min => 0,
        max => 2048,
        step => 1,
        unlimited => NULL
    )
) );

$form->add( new \IPS\Helpers\Form\Number(
    'snow_interval',
    \IPS\Settings::i()->snow_interval,
    TRUE,
    array(
        min => 1,
        max => 100,
        step => 1,
        unlimited => NULL
    )
) );

$form->add( new \IPS\Helpers\Form\Number(
    'snow_flake_width',
    \IPS\Settings::i()->snow_flake_width,
    TRUE
) );
$form->add( new \IPS\Helpers\Form\Number(
    'snow_flake_height',
    \IPS\Settings::i()->snow_flake_height,
    TRUE
) );

$form->add( new \IPS\Helpers\Form\Text(
    'snow_target',
    \IPS\Settings::i()->snow_target
) );


if ( $values = $form->values() )
{
	$form->saveAsSettings();
	return TRUE;
}

return $form;



