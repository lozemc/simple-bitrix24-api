## Библиотека для работы с API Bitrix24

### Список доступных методов

| Метод в библиотеке  |                                                             Метод в Битрикс24                                                              |
|:-------------------:|:------------------------------------------------------------------------------------------------------------------------------------------:|
|     createLead      |                               [crm.lead.add](https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_add.php)                                |
|       getLead       |                               [crm.lead.get](https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_get.php)                                |
|      getLeads       |                              [crm.lead.list](https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_list.php)                               |
|     updateLead      |                            [crm.lead.update](https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_update.php)                             |
|     deleteLead      |                            [crm.lead.delete](https://dev.1c-bitrix.ru/rest_help/crm/leads/crm_lead_delete.php)                             |
|  getDuplicateLeads  |            [crm.duplicate.findbycomm](https://dev.1c-bitrix.ru/rest_help/crm/auxiliary/duplicates/crm_duplicate_findbycomm.php)            |
|     createDeal      |                               [crm.deal.add](https://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_add.php)                               |
|       getDeal       |                               [crm.deal.get](https://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_get.php)                               |
|      getDeals       |                              [crm.deal.list](https://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_list.php)                              |
|     updateDeal      |                            [crm.deal.update](https://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_update.php)                            |
|     deleteDeal      |                            [crm.deal.delete](https://dev.1c-bitrix.ru/rest_help/crm/cdeals/crm_deal_delete.php)                            |
|    createContact    |                           [crm.contact.add](https://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_add.php)                           |
|     getContact      |                           [crm.contact.get](https://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_get.php)                           |
|     getContacts     |                          [crm.contact.list](https://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_list.php)                          |
|    updateContact    |                        [crm.contact.update](https://dev.1c-bitrix.ru/rest_help/crm/contacts/crm_contact_update.php)                        |
| getDuplicateContact |            [crm.duplicate.findbycomm](https://dev.1c-bitrix.ru/rest_help/crm/auxiliary/duplicates/crm_duplicate_findbycomm.php)            |
|       getUser       |                                     [user.get](https://dev.1c-bitrix.ru/rest_help/users/user_get.php)                                      |
|      getUsers       |                                     [user.get](https://dev.1c-bitrix.ru/rest_help/users/user_get.php)                                      |
|     sendNotify      | [im.notify.personal.add](https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=93&LESSON_ID=12129&LESSON_PATH=7657.7685.7693.12129) |
| sendTimelineComment |              [crm.timeline.comment.add](https://dev.1c-bitrix.ru/rest_help/crm/timeline/comment/crm_timeline_comment_add.php)              |


### Пример использования

```php
<?php
use Lozemc\B24;

require __DIR__ . '/vendor/autoload.php';

// https://subdomain.bitrix24.ru/rest/1/0jdfg12ukk104oxf/ - Вебхук из настроек интеграций в Bitrix24
// Хук состоит из домена, ID пользователя и токена

$subdomain = 'subdomain.bitrix24.ru';
$user_id = 1;
$token = '0jdfg12ukk104oxf';

$b24 = B24::init($user_id, $subdomain, $token)

$response = $b24->getLead(123);
print_r($response);

/*
 
 Array
(
    [result] => Array
        (
            [ID] => 3
            [TITLE] => Lead Name New
....
   [time] => Array
        (
            [start] => 1717135411.1906
            [finish] => 1717135411.227
            [duration] => 0.036404848098755
            [processing] => 0.014520168304443
            [date_start] => 2024-05-31T09:03:31+03:00
            [date_finish] => 2024-05-31T09:03:31+03:00
            [operating_reset_at] => 1717136011
            [operating] => 0
        )
 */
```
