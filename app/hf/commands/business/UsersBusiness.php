<?php
class UsersBusiness extends BaseBusiness
{
    public function deleteUserById($id)
    {
        // db query doing ...
        $dummy_data = array(
            'id'    => $id,
            'email' => 'John@gmail.com'
        );

        return $dummy_data;
    }
}