<?php

namespace ChTombleson\Flowchart\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;

class FlowchartFeedback extends DataObject
{
    private static $table_name = 'FlowchartFeedback';

    private static $db = [
        'IP' => 'Varchar(50)',
        'Feedback' => 'Text',
    ];

    private static $has_one = [
        'Flowchart' => Flowchart::class,
    ];

    private static $summary_fields = [
        'ID',
        'Feedback'
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
        return (Permission::checkMember($member, ['VIEW_FLOWCHART']));
    }
}
