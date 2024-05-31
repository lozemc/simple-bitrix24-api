<?php

namespace Lozemc;

trait Timeline
{
    /**
     * Отправка уведомлений в сущности CRM
     * @param string $id
     * @param string $message
     * @param string $type
     * lead - лид;
     * deal - сделка;
     * contact - контакт;
     * company - компания;
     * order - заказ.
     * @return array
     */
    public function sendTimelineComment(string $id, string $message, string $type = 'lead'): array
    {
        return $this->request('crm.timeline.comment.add', [
            'fields' => [
                "ENTITY_ID" => $id,
                "ENTITY_TYPE" => $type,
                "COMMENT" => $message,
            ]
        ]);
    }
}
