<?php
class UsersQuery extends BaseQuery
{
    public function findDetailByUserId($id)
    {
        //$data = $this->db->findbySql('SELECT * FROM admin');

        // db query doing ...
        $dummy_data = array(
            'name'  => 'John',
            'age'   => '21',
            'email' => 'John@gmail.com'
        );

        return $dummy_data;
    }

    public function findAllDetailsByOptions($options)
    {
        // db query doing ...
        $dummy_data = array(
            array(
                'name'  => 'John',
                'age'   => '21',
                'sex'   => 'male',
                'email' => 'John@gmail.com'
            ),
            array(
                'name'  => 'Emily',
                'age'   => '19',
                'sex'   => 'female',
                'email' => 'Emily@gmail.com'
            ),
            array(
                'name'  => 'Mike',
                'age'   => '30',
                'sex'   => 'male',
                'email' => 'Mike@gmail.com'
            ),
            array(
                'name'  => 'Tony',
                'age'   => '25',
                'sex'   => 'male',
                'email' => 'Tony@gmail.com'
            )
        );

        // calculate the total number
        $count = 150;

        return array($dummy_data, $count);
    }
}