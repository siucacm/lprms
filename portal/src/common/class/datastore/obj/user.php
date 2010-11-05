<?php
class User extends Object
{
    function __construct($id)
    {
        parent::__construct('core_events');

        $this->data = array(
            'id'                => $id,
            'first_name'        => '',
            'last_name'         => '',
            'email'             => '',
            'username'          => '',
            'password'          => '',
            'phone'             => '',
            'birthday'          => '',
            'gamertag'          => '',
            'blurb'             => '',
            'id_role'           => '',
            'id_steam'          => '',
            'id_xfire'          => '',
            'id_live'           => '',
            'datetime_join'     => '',
            'hash'              => '',
            'id_image'          => ''
        );

        $this->extra = array(
            'role'              => '',
            'steam_display'     => '',
            'steam_link'        => '',
            'steam_image'       => '',
            'xfire_display'     => '',
            'xfire_link'        => '',
            'xfire_image'       => '',
            'avatar'            => '',
            'active'            => ''
        );

    }

    protected function prepare()
    {
        $this->data = array(
            'id'                => SQLFormat::num($this->data['id']),
            'first_name'        => SQLFormat::string($this->data['first_name']),
            'last_name'         => SQLFormat::string($this->data['last_name']),
            'email'             => SQLFormat::string($this->data['email']),
            'username'          => SQLFormat::alphanum($this->data['username']),
            'password'          => SQLFormat::string($this->data['password']),
            'phone'             => SQLFormat::num($this->data['phone']),
            'birthday'          => SQLFormat::datetime($this->data['birthday']),
            'gamertag'          => SQLFormat::string($this->data['gamertag']),
            'blurb'             => SQLFormat::string($this->data['blurb']),
            'id_role'           => SQLFormat::num($this->data['id_role']),
            'id_steam'          => SQLFormat::num($this->data['id_steam']),
            'id_xfire'          => SQLFormat::num($this->data['id_xfire']),
            'id_live'           => SQLFormat::num($this->data['id_live']),
            'datetime_join'     => SQLFormat::datetime($this->data['datetime_join']),
            'hash'              => SQLFormat::hex($this->data['hash']),
            'id_image'          => SQLFormat::num($this->data['id_image'])
        );
    }

    private $extra;
}
?>
