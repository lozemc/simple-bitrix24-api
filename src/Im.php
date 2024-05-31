<?php

namespace Lozemc;

use RuntimeException;

trait Im
{
    /**
     * Отправка уведомлений пользователю
     * @param string $user_id
     * @param string $message
     * @return array
     */
    public function sendNotify(string $user_id, string $message): array
    {
        return $this->request('im.notify.personal.add', [
            'USER_ID' => $user_id,
            'MESSAGE' => $message,
        ]);
    }
}
