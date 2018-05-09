<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HawkFile Entity
 *
 * @property int $id
 * @property string $number
 * @property string $type
 * @property string $topic
 * @property string $sender
 * @property string $protocol
 * @property string $office
 * @property string $location
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class HawkFile extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'number' => true,
        'type' => true,
        'topic' => true,
        'sender' => true,
        'protocol' => true,
        'office' => true,
        'location' => true,
        'created' => true,
        'modified' => true
    ];
}
