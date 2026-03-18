<?php

namespace ChTombleson\Flowchart\Models;

use ChTombleson\Flowchart\Models\Flowchart;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

class FlowchartVote extends DataObject
{
    private static $table_name = 'FlowchartVote';

    private static $db = [
        'Value' => 'Int',
        'IP' => 'Varchar(50)'
    ];

    private static $has_one = [
        'Flowchart' => Flowchart::class,
    ];

    private static $summary_fields = [
        'ID',
        'Value'
    ];

    public function canCreate($member = null, $context = [])
    {
        return false;
    }

    public function canDelete($member = null)
    {
        return false;
    }

    public function canEdit($member = null)
    {
        return false;
    }

    public function canView($member = null)
    {
        return Permission::checkMember($member, ['VIEW_FLOWCHART']);
    }
}
