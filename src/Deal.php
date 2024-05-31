<?php

namespace Lozemc;

use RuntimeException;

trait Deal
{
    /**
     * Создание сделки
     * @param array $data
     * @param bool $event
     * @return mixed|null
     */
    public function createDeal(array $data = [], bool $event = true)
    {
        return $this->request('crm.deal.add', $this->setDefaultParams($data, $event));
    }

    /**
     * Получение информации по сделке
     * @param $id
     * @return array
     */
    public function getDeal(string $id): array
    {
        return $this->request('crm.deal.get', ['id' => $id]);
    }

    /**
     * Получение списка сделок по фильтру
     * @param array $data
     * @return mixed|null
     */
    public function getDeals(array $data = [])
    {
        return $this->request('crm.deal.list', [
            'order' => !empty($data['order']) ? $data['order'] : ["ID" => 'DESC'],
            'filter' => $data['filter'] ?? [],
            'select' => !empty($data['select']) ? $data['select'] : ['ID'],
        ]);
    }

    /**
     * Изменение сделки
     * @param string|int $id
     * @param array $data
     * @param bool $event
     * @return mixed|null
     */
    public function updateDeal(string $id, array $data = [], bool $event = true)
    {
        return $this->request('crm.deal.update', array_merge(
            ['id' => $id],
            $this->setDefaultParams($data, $event)
        ));
    }

    /**
     * Удаление сделки
     * @param string $id
     * @return array
     */
    public function deleteDeal(string $id): array
    {
        return $this->request('crm.deal.delete', ['id' => $id]);
    }
}
