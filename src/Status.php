<?php

namespace Lozemc;

trait Status
{
    /**
     * Получение списка статусов лида
     * @return array
     */
    public function getStatuses(): array
    {
        return $this->request('crm.status.list', [
           'order' => ['SORT' => 'ASC'],
            'filter' => ['ENTITY_ID' => 'STATUS'],
        ]);
    }

    /**
     * Получение списка источников
     * @return array
     */
    public function getSources(): array
    {
        return $this->request('crm.status.list', [
           'order' => ['SORT' => 'ASC'],
            'filter' => ['ENTITY_ID' => 'SOURCE'],
        ]);
    }
}
