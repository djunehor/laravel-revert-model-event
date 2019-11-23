<?php
/**
 * Created by PhpStorm.
 * User: Djunehor
 * Date: 10/5/2019
 * Time: 7:17 PM.
 */

return [

    'dashboard' => [
        'title'     => 'Model Event Log',
        'subtitle'  => 'Events',

        'labels'    => [
            'id'            => 'Id',
            'old'          => 'Old',
            'new'          => 'New',
            'model'          => 'Model',
            'model_id'   => 'Model ID',
            'action'   => 'Action',
            'causer'   => 'Causer',
            'revert'   => 'Revert',
            'reverted_by'   => 'Reverted By',
            'created_at'   => 'Occured At',
            'reverted_at'   => 'Reverted At',
        ],

        'action'      => [
            'update'           => 'Update',
            'delete'         => 'Delete',
            'create'          => 'Create',
        ],
    ],

    'modals' => [
        'shared' => [
            'btnCancel'     => 'Cancel',
            'btnConfirm'    => 'Confirm',
        ],

        'deleteLog' => [
            'title'     => 'Delete Model Event Log',
            'message'   => 'Are you sure you want to permanently DELETE the activity log?',
        ],
        'revertEvent' => [
            'title'     => 'Revert Model Event',
            'message'   => 'Are you sure you want to revert the selected model events?',
        ],
    ],

    'messages' => [
        'logClearedSuccessfully'   => 'Specified Event log(s) cleared successfully',
        'logRevertedSuccessfully'  => 'Model Event(s) reverted successfully',
        'logRevertedAlready'  => 'Model Event(s) reverted already!',
        'modelNotExist'  => 'Model no longer exists!',
        'unknownModelEvent'  => 'Unknown model event encountered!',
    ],

    'dashboardCleared' => [
        'title'     => 'Cleared Model Events',
        'subtitle'  => 'Cleared Model Events Log',

        'menu'      => [
            'deleteAll'  => 'Delete All Activity Logs',
            'revertAll' => 'Revert All Activity Logs',
        ],
    ],

    'pagination' => [
        'countText' => 'Showing :firstItem - :lastItem of :total results <small>(:perPage per page)</small>',
    ],

];
