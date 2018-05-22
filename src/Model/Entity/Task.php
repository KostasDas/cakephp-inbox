<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property int $hawk_file_id
 * @property int $owner_id
 * @property int $user_id
 * @property string $description
 * @property bool $read
 * @property bool $done
 * @property \Cake\I18n\FrozenDate $due
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\HawkFile $hawk_file
 * @property \App\Model\Entity\User $owner
 * @property \App\Model\Entity\User $user
 */
class Task extends Entity
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
        'hawk_file_id' => true,
        'owner_id' => true,
        'user_id' => true,
        'description' => true,
        'read' => true,
        'done' => true,
        'due' => true,
        'created' => true,
        'modified' => true,
        'hawk_file' => true,
        'owner' => true,
        'user' => true
    ];
}
