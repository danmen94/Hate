<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2016 Invisionizer
 */

namespace IPS\awards;

class _Cats extends \IPS\Node\Model implements
    \IPS\Node\Permissions
{
    /**
     * @var
     */
    protected static $multitons;

    /**
     * @var null
     */
    protected static $defaultValues = NULL;

    /**
     * @var string
     */
    public static $databaseTable = 'awards_cats';

    /**
     * @var string
     */
    public static $databasePrefix = 'cat_';

    /**
     * @var string
     */
    public static $databaseColumnOrder = 'position';

    /**
     * @var string
     */
    public static $databaseColumnParent = 'parent';

    /**
     * @var string
     */
    public static $nodeTitle = 'awards';

    /**
     * @var string
     */
    public static $subnodeClass = 'IPS\awards\Awards';

    /**
     * @var array
     */
    protected static $restrictions = array(
        'app'    => 'awards',
        'module' => 'awards',
        'prefix' => 'cats_',
    );


    /**
     * @return mixed
     */
    protected function get__title()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    protected function get__enabled()
    {
        return $this->enabled;
    }

    /**
     * @param $enabled
     */
    protected function set__enabled( $enabled )
    {
        $this->enabled = $enabled;
    }

    /**
     * @var string
     */
    public static $permApp = 'awards';

    /**
     * @var string
     */
    public static $permType = 'cats';

    /**
     * @var array
     */
    public static $permissionMap = array(
        'view' => 'view',
        'add'  => 3
    );

    /**
     * @var string
     */
    public static $permissionLangPrefix = 'cat_perm_';


    /**
     * @param $form
     */
    public function form( &$form )
    {
        $form->addTab( 'cat_tab_main' );
        $form->addHeader( 'cat_header_main' );
        $form->add( new \IPS\Helpers\Form\Text( 'cat_title', $this ? $this->title : NULL, TRUE, array() ) );
        $form->add( new \IPS\Helpers\Form\Editor( 'cat_desc', $this ? $this->desc : NULL, TRUE, array( 'app' => 'awards', 'key' => 'Cats', 'autoSaveKey' => 'awards-new-award', 'attachIds' => ( $this->id === NULL ? NULL : array( $this->id ) ) ) ) );
        $form->add( new \IPS\Helpers\Form\Upload( 'cat_icon', $this ? \IPS\File::get( 'awards_Cats', $this->icon ) : NULL, TRUE, array( 'storageExtension' => 'awards_Cats', 'storageContainer' => 'awards', 'image' => TRUE, 'allowedFileTypes' => array( 'png', 'jpg', 'gif', 'svg' ), 'obscure' => true ), NULL, NULL, NULL, 'type_url' ) );
    }

    /**
     * @param $values
     */
    public function saveForm( $values )
    {
        if ( !$this->id )
        {
            $this->save();
        }

        foreach ( array() as $fieldKey => $langKey )
        {
            \IPS\Lang::saveCustom( 'cats', $langKey, $values[$fieldKey] );

            unset( $values[$fieldKey] );
        }

        foreach ( array() as $k )
        {
            $this->bitoptions[$k] = $values[$k];
            unset( $values[$k] );
        }

        $values['cat_name_seo']	= \IPS\Http\Url\Friendly::seoTitle( $values['cat_title'] );


        parent::saveForm( $values );
    }

    /**
     * @return mixed
     */
    public function url()
    {
        return \IPS\Http\Url::internal( "app=awards&module=awards&controller=awards&id={$this->id}", 'front', 'awards_cat', $this->name_seo );
    }

    /**
     * Clone
     */
    public function __clone()
    {
        if ( $this->skipCloneDuplication === TRUE )
        {
            return;
        }

        $oldIcon = $this->icon;

        parent::__clone();

        if ( $oldIcon )
        {
            try
            {
                $icon = \IPS\File::get( 'awards_Cats', $oldIcon );
                $newIcon = \IPS\File::create( 'awards_Cats', $icon->originalFilename, $icon->contents() );
                $this->icon = (string) $newIcon;
            }
            catch ( \Exception $e )
            {
                $this->icon = NULL;
            }

            $this->save();
        }
    }

    /**
     * @param $column
     * @param $query
     * @param null $order
     * @param array $where
     * @return mixed
     */
    public static function search( $column, $query, $order = NULL, $where = array() )
    {
        if ( $column === '_title' )
        {
            $column = 'cat_title';
        }

        if ( $order == '_title' )
        {
            $order = 'cat_title';
        }

        return parent::search( $column, $query, $order, $where );
    }

    public function canAwarded( $member=NULL )
    {
        if( !$this->canAwarded )
        {
            return false;
        }
        else
        {
            return true;
        }

    }
}