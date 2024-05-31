<?php

namespace Lozemc;

use RuntimeException;

trait Contact
{
    /**
     * Создание контакта
     * @param array $data
     * @return array
     */
    public function createContact(array $data = []): array
    {
        return $this->request('crm.contact.add', $this->setDefaultParams($data));
    }

    /**
     * Получение контакта
     * @param string $id
     * @return array
     */
    public function getContact(string $id): array
    {
        return $this->request('crm.contact.get', ['id' => $id]);
    }

    /**
     * Получение списка контактов по фильтру
     * @param array $data
     * @return array
     */
    public function getContacts(array $data = []): array
    {
        return $this->request('crm.contact.list', [
            'order' => !empty($data['order']) ? $data['order'] : ["ID" => 'DESC'],
            'filter' => $data['filter'] ?? [],
            'select' => !empty($data['select']) ? $data['select'] : ['ID'],
        ]);
    }

    /**
     * Изменение контакта
     * @param string|int $id
     * @param array $data
     * @return array
     */
    public function updateContact(string $id, array $data = []): array
    {
        return $this->request('crm.contact.update', array_merge(
            ['id' => $id],
            $this->setDefaultParams($data)
        ));
    }

    /**
     * Удаление контакта
     * @param string $id
     * @return array
     */
    public function deleteContact(string $id): array
    {
        return $this->request('crm.contact.delete', ['id' => $id]);
    }

    /**
     * Поиск дублей контактов по номеру телефона
     * @param string $phone
     * @return array
     */
    public function getDuplicateContact(string $phone): array
    {
        return $this->request('crm.duplicate.findbycomm', [
            'entity_type' => 'CONTACT',
            'values' => [$phone],
            'type' => "PHONE",
        ]);
    }
}
