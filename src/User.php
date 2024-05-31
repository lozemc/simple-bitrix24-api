<?php

namespace Lozemc;

use RuntimeException;

trait User
{

    /**
     * Получение пользователя по ID
     * @param string $user_id
     * @return array
     */
    public function getUser(string $user_id): array
    {
        return $this->request('user.get', ['id' => $user_id]);
    }

    /**
     * Получение пользователей по фильтру
     * @param array $data
     * @return array
     */
    public function getUsers(array $data = []): array
    {
        return $this->request('user.get', $data);
    }
}
