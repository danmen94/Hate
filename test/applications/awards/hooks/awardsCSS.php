//<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

class awards_hook_awardsCSS extends _HOOK_CLASS_
{

    /* !Hook Data - DO NOT REMOVE */
    public static function hookData()
    {
        return array_merge_recursive( array(
                                          'includeCSS' =>
                                              array(
                                                  0 =>
                                                      array(
                                                          'selector' => 'link[rel=\'stylesheet\'][media=\'all\']',
                                                          'type'     => 'add_before',
                                                          'content'  => '',
                                                      ),
                                              ),
                                      ), parent::hookData() );
    }
    /* End Hook Data */

    public function includeCSS()
    {
	try
	{
		try
		{
		
		        if ( \IPS\Dispatcher::i()->controllerLocation === "front" )
		        {
		            \IPS\Output::i()->cssFiles = array_merge( \IPS\Output::i()->cssFiles, \IPS\Theme::i()->css( 'awards.css', 'awards', 'front' ) );
		        }
		
		        return parent::includeCSS();
		
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	catch ( \RuntimeException $e )
	{
		if ( method_exists( get_parent_class(), __FUNCTION__ ) )
		{
			return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
		}
		else
		{
			throw $e;
		}
	}
    }


}