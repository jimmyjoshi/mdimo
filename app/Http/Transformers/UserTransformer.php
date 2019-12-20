<?php

namespace App\Http\Transformers;
use URL;

class UserTransformer extends Transformer
{
    public function transform($data)
    {
        return [
            'user_id'       => (int) $data->id,
            'user_token'    => $data->token,
            'name'          => $this->nulltoBlank($data->name),
            'email'         => $this->nulltoBlank($data->email),
            'user_type'     => (int) $data->user_type,
            'phone'         => $this->nulltoBlank($data->phone),
            'gender'        => $this->nulltoBlank($data->gender),
            'birthdate'     => $this->nulltoBlank($data->birthdate),
            'profile_pic'   => URL('img/user/'. $data->profile_pic)
        ];
    }

    public function getUserInfo($data)
    {
        return [
            'userId'    => $data->id,
            'name'      => $this->nulltoBlank($data->name),
            'email'     => $this->nulltoBlank($data->email),
        ];
    }

    /**
     * userDetail
     * Single user detail.
     *
     * @param type $data
     * @return type
     */
    public function userDetail($data)
    {
        return [
            'UserId' => isset($data['id']) ? $data['id'] : '',
            'QuickBlocksId' => isset($data['quick_blocks_id']) ? $data['quick_blocks_id'] : '',
            'MobileNumber' => isset($data['mobile_number']) ? $data['mobile_number'] : '',
            'Name' => isset($data['username']) ? $data['username'] : '',
            'Specialty' => isset($data['specialty']) ? $data['specialty'] : '',
            'ProfilePhoto' => isset($data['profile_photo']) ? $this->getUserImage($data['profile_photo']) : '',
        ];
    }

    /*
     * User Detail and it's parameters
     */
    public function singleUserDetail($data)
    {
        return [
            'UserId' => $data['id'],
            'Name' => $this->nulltoBlank($data['name']),
            'Email' => $this->nulltoBlank($data['email']),
            'MobileNumber' => $this->nulltoBlank($data['mobile_number']),
        ];
    }

    public function transformStateCollection(array $items)
    {
        return array_map([$this, 'getState'], $items);
    }
}
