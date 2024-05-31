<?php

namespace Lozemc;

trait Lead
{
    /**
     * Создание лида
     * @param array $data
     * @param bool $event
     * @return array
     */
    public function createLead(array $data = [], bool $event = true): array
    {
        return $this->request('crm.lead.add', $this->setDefaultParams($data, $event));
    }

    /**
     * Получение информации по лиду
     * @param string $id
     * @return array
     */
    public function getLead(string $id): array
    {
        return $this->request('crm.lead.get', ['id' => $id]);
    }

    /**
     * Получение списка лидов по фильтру
     * @param array $data
     * @return array
     */
    public function getLeads(array $data = []): array
    {
        return $this->request('crm.lead.list', [
            'order' => !empty($data['order']) ? $data['order'] : ["ID" => 'DESC'],
            'filter' => $data['filter'] ?? [],
            'select' => !empty($data['select']) ? $data['select'] : ['ID'],
        ]);
    }

    /**
     * Изменение лида
     * @param string $id
     * @param array $data
     * @param bool $event
     * @return array
     */
    public function updateLead(string $id, array $data = [], bool $event = true): array
    {
        return $this->request(
            'crm.lead.update',
            array_merge(
                ['ID' => $id],
                $this->setDefaultParams($data, $event)
            )
        );
    }

    /**
     * Удаление лида
     * @param string $id
     * @return array
     */
    public function deleteLead(string $id): array
    {
        return $this->request('crm.lead.delete', ['id' => $id]);
    }

    /**
     * Поиск дублей лидов по номеру телефона
     * @param string $phone
     * @return array
     */
    public function getDuplicateLeads(string $phone): array
    {
        return $this->request('crm.duplicate.findbycomm', [
            'entity_type' => 'LEAD',
            'values' => [$phone],
            'type' => "PHONE",
        ]);
    }
}
